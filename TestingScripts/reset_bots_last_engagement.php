<?php

// Standalone script to reset every bot's last_engagement to 24 hours ago
// Usage: php TestingScripts/reset_bots_last_engagement.php

use Illuminate\Support\Carbon;
use App\Models\Bot;

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$newTimestamp = Carbon::now()->subDay();
$affected = Bot::query()->update(['last_engagement' => $newTimestamp]);

echo "Updated last_engagement for {$affected} bots to {$newTimestamp->toDateTimeString()}\n";


