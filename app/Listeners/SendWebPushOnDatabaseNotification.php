<?php

namespace App\Listeners;

use App\Jobs\SendWebPushNotification;
use App\Models\User;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendWebPushOnDatabaseNotification
{
    public function handle(NotificationSent $event): void
    {
        if ($event->channel !== 'database') {
            return;
        }

        if (!$event->notifiable instanceof User) {
            return;
        }

        $notification = $event->notification;

        if (!method_exists($notification, 'toArray')) {
            return;
        }

        $data = $notification->toArray($event->notifiable);

        if (!is_array($data) || empty($data)) {
            return;
        }

        try {
            SendWebPushNotification::dispatch($event->notifiable->id, $data);
        } catch (Throwable $e) {
            Log::error('Failed to queue SendWebPushNotification', [
                'user_id' => $event->notifiable->id,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
