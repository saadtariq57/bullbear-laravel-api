<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\UserPollVotes;

class NewPollVoteNotification extends Notification
{
    use Queueable;

    protected $pollVote;
    /**
     * Create a new notification instance.
     */
    public function __construct(array $pollVote)
    {
        $this->pollVote = $pollVote;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return $this->pollVote;
    }
}
