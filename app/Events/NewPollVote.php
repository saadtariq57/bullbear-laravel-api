<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewPollVote implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pollVoteNotification;
    /**
     * Create a new event instance.
     */
    public function __construct(array $pollVoteNotification)
    {
        $this->pollVoteNotification = $pollVoteNotification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.notifications.' . $this->pollVoteNotification['voted_to']);
    }

    public function broadcastWith()
    {
        return $this->pollVoteNotification;
    }

    public function broadcastAs()
    {
        return 'NewPollVote';
    }
}
