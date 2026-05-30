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

Three processes must always be running on the box:

| Process | Purpose | Manager |
|---|---|---|
| `apache2` + `php8.2-fpm` | Serves HTTP, executes Laravel | `systemd` |
| `cron` running `schedule:run` every minute | Fires `watchlist:check-thresholds` etc. | `cron` |
| `php artisan queue:work` | Processes `SendWebPushNotification` and other jobs | `supervisor` |

### 1. System packages

PHP 8.2 isn't in Ubuntu's default repos before 24.04, so add Ondřej Surý's PPA first:

```bash
sudo apt update
sudo apt install -y software-properties-common
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update

sudo apt install -y apache2 php8.2 php8.2-fpm php8.2-cli php8.2-mysql \
    php8.2-redis php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip \
    php8.2-bcmath php8.2-gd php8.2-intl php8.2-gmp \
    mysql-server redis-server supervisor certbot python3-certbot-apache \
    composer git unzip

sudo a2enmod rewrite headers ssl proxy_fcgi setenvif
sudo a2enconf php8.2-fpm
sudo systemctl enable --now apache2 php8.2-fpm mysql redis-server
```

> `php8.2-gmp` is required by `minishlink/web-push` for VAPID signing.

### 2. Code & dependencies

```bash
sudo mkdir -p /opt/bull-and-bear
sudo chown -R $USER:www-data /opt/bull-and-bear
cd /opt/bull-and-bear
git clone <repo-url> bullandbear-laravel-api
cd bullandbear-laravel-api

composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Set permissions so Apache can write to `storage/` and `bootstrap/cache/`:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
sudo find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

Apache (`www-data`) also needs **execute (`x`) permission on every parent directory** in the path so it can traverse into `public/`. Verify the chain is readable end-to-end:

```bash
namei -l /opt/bull-and-bear/bullandbear-laravel-api/public/index.php
```

Every directory should show `x` for "other" (e.g. `drwxr-xr-x`). If `/opt/bull-and-bear` is too restrictive, fix it:

```bash
sudo chmod 755 /opt/bull-and-bear
```

### 3. `.env` (production essentials)

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.example.com
FRONTEND_URL=https://example.com

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
VAPID_SUBJECT=mailto:support@example.com

# --- SPA cross-subdomain auth (Sanctum + session cookies) ---
# Frontend host(s) that should receive stateful (cookie) auth.
SANCTUM_STATEFUL_DOMAINS=example.com,www.example.com

# Shared parent domain so the session cookie is sent on api.example.com requests
# from example.com. The leading dot is required for cross-subdomain.
SESSION_DOMAIN=.example.com
SESSION_SECURE_COOKIE=true
```

Then:

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> Replace `example.com` / `api.example.com` with your real frontend + API hosts (e.g. `bb.saadtariq.app` + `api.bb.saadtariq.app`, in which case `SESSION_DOMAIN=.saadtariq.app`). The leading dot on `SESSION_DOMAIN` is what allows the session cookie set by the API to be sent back from the frontend's origin on cross-subdomain XHR — without it, `auth()->check()` will always be false even after CORS passes.

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
cd /opt/bull-and-bear/bullandbear-laravel-api
php artisan config:clear
php artisan config:cache
```

`config:clear` is critical — `config/cors.php` is cached into `bootstrap/cache/config.php`, so a stale cache silently ignores your changes.

Verify the preflight from any machine:

```bash
curl -i -X OPTIONS https://api.example.com/api/check-login \
  -H "Origin: https://example.com" \
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

Create `/etc/apache2/sites-available/bullandbear.conf`. Define only the plain HTTP vhost — `certbot --apache` will auto-generate the matching `*:443` SSL vhost and add the HTTP→HTTPS redirect for you in the next step.

```apache
<VirtualHost *:80>
    ServerName richtv.io
    ServerAlias www.richtv.io
    DocumentRoot /opt/bull-and-bear/bullandbear-laravel-api/public

    <Directory /opt/bull-and-bear/bullandbear-laravel-api/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php8.2-fpm.sock|fcgi://localhost/"
    </FilesMatch>

    ErrorLog  ${APACHE_LOG_DIR}/bullandbear-error.log
    CustomLog ${APACHE_LOG_DIR}/bullandbear-access.log combined
</VirtualHost>
```

Enable and reload:

```bash
sudo a2dissite 000-default   # harmless if it errors with "Site does not exist"
sudo a2ensite bullandbear
sudo apache2ctl configtest
sudo systemctl reload apache2
```

If you see `AH01574: module php_module is already loaded` in the reload output, both `mod_php` and PHP-FPM are enabled. Disable `mod_php` so PHP-FPM is the sole handler:

```bash
apache2ctl -M | grep -i php   # look for both php_module and proxy_fcgi_module
sudo a2dismod php8.2
sudo systemctl reload apache2
```

Then issue the certificate. **Make sure your DNS A/AAAA records for `richtv.io` and `www.richtv.io` already point to the server** — certbot uses HTTP-01 over port 80 to validate ownership.

```bash
sudo certbot --apache -d richtv.io -d www.richtv.io
```

When prompted, choose option **2 (Redirect)** so certbot adds the HTTP→HTTPS redirect to your `*:80` vhost. After it completes, you'll have a new auto-managed file at `/etc/apache2/sites-available/bullandbear-le-ssl.conf` containing the `*:443` block with `SSLEngine on` and the certificate paths filled in — do not edit it by hand; certbot owns that file and will rewrite it on renewals. Renewals run automatically via the `certbot.timer` systemd unit (verify with `systemctl status certbot.timer`).

`AllowOverride All` lets the bundled `public/.htaccess` rewrite all traffic to `index.php`. Because certbot copies your `*:80` directives into the SSL vhost, the same setting (and the `FilesMatch` PHP-FPM handler) will apply on HTTPS too.

### 6. Cron (Laravel scheduler)

```bash
sudo crontab -u www-data -e
```

Add:

```cron
* * * * * cd /opt/bull-and-bear/bullandbear-laravel-api && php artisan schedule:run >> /dev/null 2>&1
```

### 7. Supervisor (queue worker)

Create `/etc/supervisor/conf.d/bullandbear-worker.conf`:

```ini
[program:bullandbear-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /opt/bull-and-bear/bullandbear-laravel-api/artisan queue:work --tries=3 --timeout=60 --sleep=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/bullandbear-worker.log
stopwaitsecs=3600
```

Activate:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start bullandbear-worker:*
```

### 8. Deploy / update workflow

From `/opt/bull-and-bear/bullandbear-laravel-api`:

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart   # so Supervisor workers pick up new code
```

### 9. Health checks

Laravel is not a long-running process — it runs per-request via PHP-FPM. So "is the app up?" decomposes into three questions:

| Question | Command | Healthy output |
|---|---|---|
| Is Apache + PHP-FPM up? | `sudo systemctl is-active apache2 php8.2-fpm` | `active` (twice) |
| Are queue workers running? | `sudo supervisorctl status` | `bullandbear-worker:* RUNNING` |
| Did Laravel actually serve a request? | `curl -I https://richtv.io` | `HTTP/2 200` + `Set-Cookie: laravel_session=...` |

The last one is the real proof. The `Set-Cookie: laravel_session` header means Laravel booted; if you only see `Server: Apache/...` and `Content-Type: text/html; charset=iso-8859-1`, that's Apache's own default 404 page — usually because `DocumentRoot` points at a directory that doesn't exist (`AH00112: DocumentRoot ... does not exist` will be in the Apache error log).

Tail logs side-by-side while you hit the app:

```bash
sudo tail -f /var/log/apache2/bullandbear-error.log \
             /var/log/apache2/bullandbear-access.log \
             storage/logs/laravel.log
```

For the scheduler (cron-driven, exits each minute):

```bash
sudo grep CRON /var/log/syslog | tail -5
```

You should see `php artisan schedule:run` entries every minute.
