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
        // Load all necessary relations for the post, including shared post data
        $post = $this->post->load([
            'user:id,name,avatar',
            'photos',
            'poll.options',
            'coloredPost',
            'reactions' => function ($query) {
                $query->with('reactionType:id,name,icon')
                      ->with('user:id,name,avatar,about');
            },
            'sharedPost.user:id,name,avatar',
            'sharedPost.photos',
            'sharedPost.poll.options',
            'sharedPost.coloredPost',
            'sharedPost.reactions' => function ($query) {
                $query->with('reactionType:id,name,icon')
                      ->with('user:id,name,avatar,about');
            }
        ]);

        // Apply the same transformation as in the controllers to set originalPost
        if ($post->sharedPost) {
            $sharedPost = $post->sharedPost;
            
            // Apply similar transformations to the shared post
            switch ($sharedPost->post_type) {
                case 'photo':
                    break;
                case 'poll':
                    if ($sharedPost->poll) {
                        $sharedPost->poll->options = $sharedPost->poll->options;
                    }
                    unset($sharedPost->pollDetails);
                    break;
                case 'color':
                    unset($sharedPost->colorDetails);
                    break;
            }

            // Ensure relations are preserved
            $sharedPost->setRelation('user', $sharedPost->user);
            if ($sharedPost->coloredPost) {
                $sharedPost->setRelation('coloredPost', $sharedPost->coloredPost);
            }
            $post->originalPost = $sharedPost;
            $post->unsetRelation('sharedPost');
        }

        return [
            'post' => $post,
        ];
    }
    public function broadcastAs()
    {
        return 'NewPost';
    }
}
