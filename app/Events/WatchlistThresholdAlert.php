<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WatchlistThresholdAlert implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $alertNotification)
    {
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('user.notifications.' . $this->alertNotification['user_id']);
    }

    public function broadcastWith(): array
    {
        return $this->alertNotification;
    }

    public function broadcastAs(): string
    {
        return 'WatchlistAlert';
    }
}
