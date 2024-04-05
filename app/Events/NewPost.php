<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use Ably\AblyRest;

class NewPost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Fetch group IDs, followed user IDs, and user ID related to the post
        $groupIds = $this->post->user->groupMemberships()->pluck('group_id');
        $followerIds = $this->post->user->followers()->pluck('follower_id');
        $userId = $this->post->user->id;

        // Prepare an array to store the channels
        $channels = [];

        // Add channels for groups, followers, and user
        foreach ($groupIds as $groupId) {
            $channels[] = new PrivateChannel('group.posts.updates.' . $groupId);
        }

        foreach ($followerIds as $followerId) {
            $channels[] = new PrivateChannel('feed.posts.updates.' . $followerId);
        }

        $channels[] = new PrivateChannel('feed.posts.updates.' . $userId);

        return $channels;
    }
    public function broadcastWith()
    {
        return [
            'post' => $this->post->load(['user', 'comments', 'reactions']),
        ];
    }
    public function broadcastAs()
    {
        return 'NewPost';
    }
    /*public function broadcastToAbly()
    {
        $ably = new AblyRest(env('ABLY_KEY'));
        $channels = $this->broadcastOn();
        $data = $this->broadcastWith();

        foreach ($channels as $channel) {
            $channelName = method_exists($channel, 'name') ? $channel->name : null;
            if ($channelName) {
                $ablyChannel = $ably->channels->get($channelName);
                $ablyChannel->publish('NewPost', $data);
            }
        }
    }*/
}
