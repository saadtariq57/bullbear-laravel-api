<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minishlink\WebPush\VAPID;

class GenerateVapidKeys extends Command
{
    protected $signature = 'webpush:vapid-keys';

    protected $description = 'Generate VAPID keys for Web Push (add to .env and NEXT_PUBLIC_VAPID_PUBLIC_KEY)';

    public function handle(): int
    {
        try {
            $keys = VAPID::createVapidKeys();
        } catch (\Throwable $e) {
            $this->error('Could not generate keys via OpenSSL: ' . $e->getMessage());
            $this->newLine();
            $this->line('On Windows, enable OpenSSL EC support in php.ini, or run on Linux/macOS:');
            $this->line('  php artisan webpush:vapid-keys');
            $this->line('Or use npx: npx web-push generate-vapid-keys');

            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Add these to your .env file:');
        $this->newLine();
        $this->line('VAPID_PUBLIC_KEY=' . $keys['publicKey']);
        $this->line('VAPID_PRIVATE_KEY=' . $keys['privateKey']);
        $this->line('VAPID_SUBJECT=mailto:support@richtv.com');
        $this->newLine();
        $this->info('Frontend (.env.local):');
        $this->line('NEXT_PUBLIC_VAPID_PUBLIC_KEY=' . $keys['publicKey']);
        $this->newLine();

        return self::SUCCESS;
    }
}
