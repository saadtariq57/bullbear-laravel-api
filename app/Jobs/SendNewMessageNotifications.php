<?php

namespace App\Jobs;

use App\Notifications\NewMessageNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Events\MessageNotificationUpdated;

class SendNewMessageNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $members;
    protected $notificationData;

    public function __construct($members, $notificationData)
    {
        $this->members = $members;
        $this->notificationData = $notificationData;
    }

    public function handle(): void
    {
        $members = $this->members;
        foreach ($members as $member) {
            //if ($member->id !== $this->message->user_id) {
                $existingNotification = $member->notifications()
                    ->where('data->group_id', $this->notificationData['group_id'])
                    ->first();

                if ($existingNotification) {
                    $data = $existingNotification->data;
                    $data['unread_count'] += 1;
                    $data['last_message'] = $this->notificationData['last_message'];
                    $data['last_message_time'] = now();
                    $data['preview'] = $this->notificationData['last_message'];
                    $existingNotification->update(['data' => $data, 'updated_at' => now()]);

                    // Broadcast the updated notification
                    \Log::info('Updating Notificationn For' . json_encode($data));
                    broadcast(new MessageNotificationUpdated($data, $member->id));
                } else {
                    \Log::info('Creating new notification for user ' . $member->id);
                    $newData = $this->notificationData;
                    $member->notify(new NewMessageNotification($newData));
                }
            //}
        }
    }
}