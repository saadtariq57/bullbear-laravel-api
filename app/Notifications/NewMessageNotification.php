<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $message;

    public function __construct(array $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return $this->message;
    }

    public function broadcastType()
    {
        return 'NewMessageNotification';
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->message);
    }
}