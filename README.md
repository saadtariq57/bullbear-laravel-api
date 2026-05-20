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

## Production (Linux VPS)

1. Set `.env` (`VAPID_*`, `QUEUE_CONNECTION=database` or `redis`).
2. Migrate: `php artisan migrate --force`.
3. Cron:
   ```cron
   * * * * * cd /var/www/richtv && php artisan schedule:run >> /dev/null 2>&1
   ```
4. Supervisor (or systemd) running:
   ```bash
   php artisan queue:work --tries=3 --timeout=60
   ```
5. After deploys: `php artisan queue:restart`.
