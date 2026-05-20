<?php

// Standalone script to send a test Web Push to a user's subscribed browsers.
//
// Usage:
//   php TestingScripts/send_test_webpush.php                 -> sends to user id 1
//   php TestingScripts/send_test_webpush.php 5               -> sends to user id 5
//   php TestingScripts/send_test_webpush.php 5 "Hi" "Body"   -> custom title/body
//
// Requirements:
//   - VAPID_PUBLIC_KEY / VAPID_PRIVATE_KEY / VAPID_SUBJECT set in .env
//   - At least one row in push_subscriptions for the target user
//   - Frontend service worker registered

use App\Models\PushSubscription;
use App\Models\User;
use App\Services\WebPushService;

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$userId      = (int) ($argv[1] ?? 1);
$title       = $argv[2] ?? 'RichTV test push';
$description = $argv[3] ?? 'If you see this, Web Push is working end-to-end.';
$url         = $argv[4] ?? '/';

$user = User::find($userId);

if (!$user) {
    echo "ERROR: user id {$userId} not found\n";
    exit(1);
}

$subs = PushSubscription::where('user_id', $userId)->get();

echo "User:                {$user->id} ({$user->email})\n";
echo "Subscriptions:       {$subs->count()}\n";
echo "VAPID public set:    " . (config('webpush.vapid.public_key') ? 'yes' : 'NO') . "\n";
echo "VAPID private set:   " . (config('webpush.vapid.private_key') ? 'yes' : 'NO') . "\n";
echo "VAPID subject:       " . (config('webpush.vapid.subject') ?: '(missing)') . "\n";
echo str_repeat('-', 60) . "\n";

if ($subs->isEmpty()) {
    echo "No push_subscriptions for this user. Subscribe from the frontend first.\n";
    exit(1);
}

foreach ($subs as $s) {
    echo "  - id={$s->id} endpoint=" . substr($s->endpoint, 0, 60) . "...\n";
}
echo str_repeat('-', 60) . "\n";

$payload = [
    'type'        => 'test_push',
    'title'       => $title,
    'description' => $description,
    'url'         => $url,
    'id'          => 'test-' . time(),
];

echo "Sending payload: " . json_encode($payload) . "\n";

/** @var WebPushService $service */
$service = app(WebPushService::class);
$service->sendToUser($user, $payload);

// Re-read so we can show what survived (expired ones are auto-deleted).
$remaining = PushSubscription::where('user_id', $userId)->count();
echo "Remaining subscriptions after send: {$remaining}\n";
echo "Done. Check the browser for the OS notification, and storage/logs/laravel.log for any errors.\n";
