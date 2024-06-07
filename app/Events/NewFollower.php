<?php

namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewFollower implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $followerNotification;

    public function __construct(array $followerNotification)
    {
        $this->followerNotification = $followerNotification;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.notifications.' . $this->followerNotification['following_id']);
    }

    public function broadcastWith()
    {
        return $this->followerNotification;
    }

    public function broadcastAs()
    {
        return 'NewFollower';
    }
}