<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\Follower;

class NewFollowerNotification extends Notification
{
    use Queueable;
    protected $follower;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $follower)
    {
        $this->follower = $follower;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return $this->follower;
    }
}
