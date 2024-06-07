<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewPostReaction implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reactionNotification;
    /**
     * Create a new event instance.
     */
    public function __construct(array $reactionNotification)
    {
        $this->reactionNotification = $reactionNotification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.notifications.' . $this->reactionNotification['reacted_to']);
    }

    public function broadcastWith()
    {
        return $this->reactionNotification;
    }

    public function broadcastAs()
    {
        return 'NewReaction';
    }
}
