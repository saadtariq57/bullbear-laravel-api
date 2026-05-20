<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\WebPushService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWebPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param  array<string, mixed>  $notificationData
     */
    public function __construct(
        public int $userId,
        public array $notificationData,
    ) {
    }

    public function handle(WebPushService $webPushService): void
    {
        $user = User::find($this->userId);

        if (!$user) {
            return;
        }

        $webPushService->sendToUser($user, $this->notificationData);
    }
}
