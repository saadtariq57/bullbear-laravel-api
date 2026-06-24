# Bull & Bear — Notifications

Notifications use three channels: **database** (in-app bell), **Ably** (live UI), and **Web Push** (OS notification).
Web Push is sent by the `App\Jobs\SendWebPushNotification` queue job. Watchlist alerts are created by the
`watchlist:check-thresholds` scheduled command.

## Local (Windows / XAMPP)

One-time setup:

1. Add Windows env var `OPENSSL_CONF = C:\xampp\php\extras\ssl\openssl.cnf`, then restart your terminal.
2. Copy env and run migrations:
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   ```
3. Set `VAPID_PUBLIC_KEY`, `VAPID_PRIVATE_KEY`, `VAPID_SUBJECT` in `.env` (and the same public key in the frontend `.env.local`).

Run in three terminals:

```bash
php artisan serve
php artisan schedule:work    # runs watchlist:check-thresholds every 5 min
php artisan queue:work       # processes SendWebPushNotification
```

Manual test push:

```bash
php TestingScripts/send_test_webpush.php 893
```

## Production (Linux VPS — Apache)

The app is a standard Laravel 10 monolith served by **Apache + PHP-FPM**. Do **not** use `php artisan serve` in production — Apache is the long-running server, every request hits `public/index.php` via the bundled `.htaccess`.

It is deployed as **one** codebase serving **two subdomains**:

| Subdomain | Serves |
|---|---|
| `api.bullbear.servicesground.com` | JSON API (`routes/api.php`) consumed by the Next.js frontend |
| `admin.bullbear.servicesground.com` | Blade admin panel (`routes/web.php`) |

Both subdomains point at the **same** `public/` directory. Laravel decides which is which from the `Host` header via `Route::domain()`, driven by the `ADMIN_DOMAIN` env var — there is **no** `/admin` path prefix in production (that prefix is only the local-dev fallback when `ADMIN_DOMAIN` is empty).

Three processes must always be running on the box:

| Process | Purpose | Manager |
|---|---|---|
| `apache2` + `php8.2-fpm` | Serves HTTP, executes Laravel | `systemd` |
| `cron` running `schedule:run` every minute | Fires `watchlist:check-thresholds` etc. | `cron` |
| `php artisan queue:work` | Processes `SendWebPushNotification` and other jobs | `supervisor` |

> **Multi-app server note:** this box also runs other apps on the **default PHP**. This app must run on **PHP 8.2** without disturbing them. PHP version is selected **per-vhost** (via the `SetHandler` line in step 5), so `php8.2-fpm` runs *alongside* the default PHP/`mod_php` — you never disable the default. The bare `php` CLI still points at the default version, so every CLI/cron/worker command below calls the **`/usr/bin/php8.2`** binary explicitly.

### 1. System packages

PHP 8.2 isn't in Ubuntu's default repos before 24.04, so add Ondřej Surý's PPA first. Install `php8.2-fpm` **alongside** whatever PHP is already on the box — do not remove the existing one. `apache2`, `mysql-server`, and `redis-server` are likely already installed for the other apps; the commands below are idempotent and won't disturb them:

```bash
sudo apt update
sudo apt install -y software-properties-common
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update

sudo apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-mysql \
    php8.2-redis php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip \
    php8.2-bcmath php8.2-gd php8.2-intl php8.2-gmp \
    supervisor certbot python3-certbot-apache git unzip

# Apache modules that let a vhost forward PHP to a specific FPM socket
sudo a2enmod rewrite headers ssl proxy_fcgi setenvif
sudo systemctl enable --now php8.2-fpm
sudo systemctl reload apache2
```

> `php8.2-gmp` is required by `minishlink/web-push` for VAPID signing.

> ⚠️ **Do NOT disable `mod_php` or the default PHP** (skip any `a2dismod phpX.Y`). Other apps on this server depend on it. The per-vhost `SetHandler` in step 5 is what routes *only* this app to 8.2-FPM; both coexist. Confirm both FPM sockets exist with `ls /run/php/` (you should see the default version's socket **and** `php8.2-fpm.sock`).

### 2. Code & dependencies

```bash
sudo mkdir -p /opt/bullbear
sudo chown -R $USER:www-data /opt/bullbear
cd /opt/bullbear
git clone <repo-url> bullbear-laravel-api
cd bullbear-laravel-api

php8.2 /usr/bin/composer install --no-dev --optimize-autoloader
cp .env.example .env
php8.2 artisan key:generate
```

> Run Composer and Artisan with the **`php8.2`** binary explicitly (`php8.2 /usr/bin/composer ...`), otherwise the bare `php` / `composer` will use the server's default PHP version and may fail the `^8.2` requirement.

Set permissions so Apache can write to `storage/` and `bootstrap/cache/`:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
sudo find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

Apache (`www-data`) also needs **execute (`x`) permission on every parent directory** in the path so it can traverse into `public/`. Verify the chain is readable end-to-end:

```bash
namei -l /opt/bullbear/bullbear-laravel-api/public/index.php
```

Every directory should show `x` for "other" (e.g. `drwxr-xr-x`). If `/opt/bullbear` is too restrictive, fix it:

```bash
sudo chmod 755 /opt/bullbear
```

### 3. `.env` (production essentials)

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.bullbear.servicesground.com
FRONTEND_URL=https://<your-nextjs-frontend-host>

# Activates subdomain routing for the Blade admin panel. When set, the panel is
# served at the root of this host (no "/admin" prefix); when empty it falls back
# to the "/admin" path on the main domain (local dev only).
ADMIN_DOMAIN=admin.bullbear.servicesground.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=rtv
DB_USERNAME=...
DB_PASSWORD=...

CACHE_DRIVER=redis
SESSION_DRIVER=database
QUEUE_CONNECTION=database   # or redis
BROADCAST_DRIVER=ably

VAPID_PUBLIC_KEY=...
VAPID_PRIVATE_KEY=...
VAPID_SUBJECT=mailto:support@bullbear.servicesground.com

# --- SPA cross-subdomain auth (Sanctum + session cookies) ---
# Hosts that should receive stateful (cookie) auth: the admin panel + the frontend.
SANCTUM_STATEFUL_DOMAINS=admin.bullbear.servicesground.com,<your-nextjs-frontend-host>

# Shared parent domain so the session cookie is valid across api/admin subdomains.
# The leading dot is required for cross-subdomain.
SESSION_DOMAIN=.bullbear.servicesground.com
SESSION_SECURE_COOKIE=true
```

Then (note the explicit `php8.2` binary):

```bash
php8.2 artisan migrate --force
php8.2 artisan storage:link
php8.2 artisan config:cache
php8.2 artisan route:cache
php8.2 artisan view:cache
```

> The leading dot on `SESSION_DOMAIN` is what allows the session cookie to be shared across `api.` and `admin.` subdomains (and the frontend, if it's on the same parent domain). Without it, `auth()->check()` will always be false even after CORS passes. If your Next.js frontend lives on an unrelated domain, it must use **bearer-token** auth instead of the shared session cookie.

### 4. CORS & SPA frontend (cross-origin)

When the Next.js frontend lives on a different host than the API (e.g. `bb.saadtariq.app` → `api.bb.saadtariq.app`), Laravel must explicitly allow that origin **and** allow credentials, otherwise browsers will block every XHR preflight with:

```text
Access to XMLHttpRequest at 'https://api.example.com/api/...' from origin 'https://example.com'
has been blocked by CORS policy: No 'Access-Control-Allow-Origin' header is present on the requested resource.
```

Replace `config/cors.php` with the production-ready version below. The shipped default is intentionally permissive for local dev (`localhost`/`127.0.0.1` only) — it does **not** allow any deployed origin out of the box.

```php
<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout', 'register'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        env('FRONTEND_URL', 'https://example.com'),
    ],

    'allowed_origins_patterns' => [
        '#^https?://localhost(:\d+)?$#',
        '#^https?://127\.0\.0\.1(:\d+)?$#',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
```

Why each line:

| Line | Why |
|---|---|
| `paths` | CORS headers are only emitted on actual API/auth routes, not on Blade pages or static assets. `sanctum/csrf-cookie` is required so the SPA can fetch the CSRF cookie before stateful POSTs. |
| `allowed_origins` reads `FRONTEND_URL` | Keeps the origin out of code; staging/prod each set their own. **No trailing slash.** |
| Keeping `localhost` patterns | Lets local dev hit the deployed API for testing. Drop them for strict prod-only. |
| `supports_credentials => true` | Required so the session cookie travels cross-origin. Forces an explicit origin echo (you cannot combine this with `allowed_origins => ['*']`). |

After editing, on the server:

```bash
cd /opt/bullbear/bullbear-laravel-api
php8.2 artisan config:clear
php8.2 artisan config:cache
```

`config:clear` is critical — `config/cors.php` is cached into `bootstrap/cache/config.php`, so a stale cache silently ignores your changes.

Verify the preflight from any machine:

```bash
curl -i -X OPTIONS https://api.bullbear.servicesground.com/api/check-login \
  -H "Origin: https://<your-nextjs-frontend-host>" \
  -H "Access-Control-Request-Method: GET" \
  -H "Access-Control-Request-Headers: content-type,x-requested-with"
```

Healthy response:

```text
HTTP/2 204
access-control-allow-origin: https://example.com
access-control-allow-credentials: true
access-control-allow-methods: GET
access-control-allow-headers: content-type,x-requested-with
vary: Origin
```

If `access-control-allow-origin` is missing, CORS is still wrong (config cache stale, wrong origin, trailing slash). If it shows `*`, `supports_credentials` got disabled — browsers will still reject credentialed requests because credentials require an exact origin echo, never `*`.

**Frontend reminder:** CORS headers are only half the equation — the SPA must send credentials on every API call, otherwise the session cookie is dropped and `auth()->check()` is always false:

```js
// Axios (set once, globally)
axios.defaults.withCredentials = true;

// fetch (per call)
fetch(url, { credentials: 'include' });
```

### 5. Apache vhost

Create `/etc/apache2/sites-available/bullbear.conf` with **two** plain HTTP vhosts — one per subdomain. Both share the same `DocumentRoot` and the same PHP 8.2-FPM handler; only `ServerName` differs. `certbot --apache` will auto-generate the matching `*:443` SSL vhosts and add the HTTP→HTTPS redirects in the next step.

```apache
# ---- API ----
<VirtualHost *:80>
    ServerName api.bullbear.servicesground.com
    DocumentRoot /opt/bullbear/bullbear-laravel-api/public

    <Directory /opt/bullbear/bullbear-laravel-api/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php8.2-fpm.sock|fcgi://localhost/"
    </FilesMatch>

    ErrorLog  ${APACHE_LOG_DIR}/bullbear-api-error.log
    CustomLog ${APACHE_LOG_DIR}/bullbear-api-access.log combined
</VirtualHost>

# ---- ADMIN ----
<VirtualHost *:80>
    ServerName admin.bullbear.servicesground.com
    DocumentRoot /opt/bullbear/bullbear-laravel-api/public   # SAME folder as the API

    <Directory /opt/bullbear/bullbear-laravel-api/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php8.2-fpm.sock|fcgi://localhost/"
    </FilesMatch>

    ErrorLog  ${APACHE_LOG_DIR}/bullbear-admin-error.log
    CustomLog ${APACHE_LOG_DIR}/bullbear-admin-access.log combined
</VirtualHost>
```

The `SetHandler` line is what routes **only these two vhosts** to PHP 8.2-FPM; the other apps on the box keep using their own handler. Enable the site and reload gracefully — **do not** touch `000-default` or any other app's site:

```bash
sudo a2ensite bullbear
sudo apache2ctl configtest
sudo systemctl reload apache2
```

> ⚠️ The single-app version of this guide told you to `a2dismod php8.2` so PHP-FPM is the sole handler. **Do NOT do that here** — disabling `mod_php` is global and would break every other app that relies on the default PHP. The per-vhost `SetHandler` above already overrides the handler for this app only, so `mod_php` and `php8.2-fpm` coexist safely. Use `reload` (not `restart`) so the other apps' connections aren't dropped.

Then issue one certificate covering **both** subdomains. **Make sure DNS A/AAAA records for `api.bullbear.servicesground.com` and `admin.bullbear.servicesground.com` already point to the server** — certbot uses HTTP-01 over port 80 to validate ownership.

```bash
sudo certbot --apache \
  -d api.bullbear.servicesground.com \
  -d admin.bullbear.servicesground.com
```

When prompted, choose option **2 (Redirect)** so certbot adds the HTTP→HTTPS redirect to both `*:80` vhosts. After it completes, you'll have a new auto-managed file at `/etc/apache2/sites-available/bullbear-le-ssl.conf` containing the `*:443` blocks with `SSLEngine on` and the certificate paths filled in — do not edit it by hand; certbot owns that file and will rewrite it on renewals. Renewals run automatically via the `certbot.timer` systemd unit (verify with `systemctl status certbot.timer`).

`AllowOverride All` lets the bundled `public/.htaccess` rewrite all traffic to `index.php`. Because certbot copies your `*:80` directives into the SSL vhosts, the same setting (and the `FilesMatch` PHP-FPM handler) will apply on HTTPS too.

### 6. Cron (Laravel scheduler)

```bash
sudo crontab -u www-data -e
```

Add (note the explicit `php8.2` binary so the scheduler runs on the right PHP version):

```cron
* * * * * cd /opt/bullbear/bullbear-laravel-api && /usr/bin/php8.2 artisan schedule:run >> /dev/null 2>&1
```

### 7. Supervisor (queue worker)

Create `/etc/supervisor/conf.d/bullbear-worker.conf`. The `command` calls `/usr/bin/php8.2` directly — the bare `php` would use the server's default PHP:

```ini
[program:bullbear-worker]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/php8.2 /opt/bullbear/bullbear-laravel-api/artisan queue:work --tries=3 --timeout=60 --sleep=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/bullbear-worker.log
stopwaitsecs=3600
```

Activate:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start bullbear-worker:*
```

### 8. Deploy / update workflow

From `/opt/bullbear/bullbear-laravel-api`:

```bash
git pull
php8.2 /usr/bin/composer install --no-dev --optimize-autoloader
php8.2 artisan migrate --force
php8.2 artisan config:cache
php8.2 artisan route:cache
php8.2 artisan view:cache
php8.2 artisan queue:restart   # so Supervisor workers pick up new code
```

### 9. Health checks

Laravel is not a long-running process — it runs per-request via PHP-FPM. So "is the app up?" decomposes into three questions:

| Question | Command | Healthy output |
|---|---|---|
| Is Apache + PHP-FPM up? | `sudo systemctl is-active apache2 php8.2-fpm` | `active` (twice) |
| Are queue workers running? | `sudo supervisorctl status` | `bullbear-worker:* RUNNING` |
| Does the API respond? | `curl -I https://api.bullbear.servicesground.com` | `HTTP/2 200` |
| Does the admin panel respond? | `curl -I https://admin.bullbear.servicesground.com` | `HTTP/2 302` to `/login` + `Set-Cookie: laravel_session=...` |

The last two are the real proof. A `Set-Cookie: laravel_session` header (or a redirect to `/login` on the admin host) means Laravel booted and `ADMIN_DOMAIN` routing is working; if you only see `Server: Apache/...` and `Content-Type: text/html; charset=iso-8859-1`, that's Apache's own default page — usually because `DocumentRoot` points at a directory that doesn't exist (`AH00112: DocumentRoot ... does not exist` will be in the Apache error log).

Tail logs side-by-side while you hit the app:

```bash
sudo tail -f /var/log/apache2/bullbear-api-error.log \
             /var/log/apache2/bullbear-admin-error.log \
             storage/logs/laravel.log
```

For the scheduler (cron-driven, exits each minute):

```bash
sudo grep CRON /var/log/syslog | tail -5
```

You should see `php artisan schedule:run` entries every minute.
