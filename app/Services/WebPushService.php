<?php

namespace App\Services;

use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class WebPushService
{
    public function isConfigured(): bool
    {
        return !empty(config('webpush.vapid.public_key'))
            && !empty(config('webpush.vapid.private_key'));
    }

    /**
     * Send a Web Push payload to all subscriptions for a user.
     *
     * @param  array<string, mixed>  $notificationData  Laravel notification toArray() payload
     */
    public function sendToUser(User|int $user, array $notificationData): void
    {
        if (!$this->isConfigured()) {
            Log::warning('Web push skipped: VAPID keys not configured');

            return;
        }

        $userId = $user instanceof User ? $user->id : $user;
        $subscriptions = PushSubscription::where('user_id', $userId)->get();

        if ($subscriptions->isEmpty()) {
            Log::info('Web push skipped: no push_subscriptions for user', ['user_id' => $userId]);

            return;
        }

        $payload = json_encode($this->buildPushPayload($notificationData));
        $webPush = $this->createWebPushClient();

        foreach ($subscriptions as $record) {
            $subscription = Subscription::create([
                'endpoint' => $record->endpoint,
                'publicKey' => $record->public_key,
                'authToken' => $record->auth_token,
                'contentEncoding' => $record->content_encoding ?: 'aesgcm',
            ]);

            try {
                $report = $webPush->sendOneNotification($subscription, $payload);

                if ($report->isSubscriptionExpired()) {
                    $record->delete();
                    continue;
                }

                if ($report->isSuccess()) {
                    $record->update(['last_used_at' => now()]);
                } else {
                    Log::warning('Web push delivery failed', [
                        'user_id' => $userId,
                        'endpoint' => $record->endpoint,
                        'reason' => $report->getReason(),
                    ]);
                }
            } catch (\Throwable $e) {
                Log::error('Web push exception', [
                    'user_id' => $userId,
                    'endpoint' => $record->endpoint,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function buildPushPayload(array $data): array
    {
        $appUrl = rtrim((string) config('app.url'), '/');
        $icon = $appUrl . config('webpush.default_icon', '/favicon.ico');

        $title = $data['title'] ?? 'RichTV';
        $body = $data['description']
            ?? $data['preview']
            ?? $data['last_message']
            ?? 'You have a new notification';

        $url = $data['url'] ?? '/';
        if ($url !== '/' && !str_starts_with($url, 'http')) {
            $url = $appUrl . (str_starts_with($url, '/') ? $url : '/' . $url);
        }

        $tag = isset($data['id'])
            ? (string) $data['id']
            : (($data['type'] ?? 'notification') . '-' . ($data['group_id'] ?? $data['user']['id'] ?? uniqid()));

        return [
            'title' => $title,
            'body' => $body,
            'icon' => $icon,
            'badge' => $icon,
            'url' => $url,
            'tag' => $tag,
            'data' => [
                'url' => $url,
                'type' => $data['type'] ?? null,
                'notificationId' => $data['id'] ?? null,
            ],
        ];
    }

    private function createWebPushClient(): WebPush
    {
        return new WebPush([
            'VAPID' => [
                'subject' => config('webpush.vapid.subject'),
                'publicKey' => config('webpush.vapid.public_key'),
                'privateKey' => config('webpush.vapid.private_key'),
            ],
        ]);
    }
}
