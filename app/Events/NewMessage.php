<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Group;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Jobs\SendNewMessageNotifications;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $notificationData;
    public $members;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->prepareNotificationData();
        $this->queueNotifications();
    }

    public function broadcastOn()
    {
        return new PrivateChannel('group.chat.' . $this->message->group_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'text' => $this->message->text,
            'media' => $this->message->media,
            'media_file_name' => $this->message->media_file_name,
            'user' => [
                'id' => $this->message->user->id,
                'name' => $this->message->user->name,
                'avatar' => $this->message->user->avatar,
            ],
            'is_user_message_owner' => ($this->message->user_id == $this->message->user_id),
            'reply_to_message_id' => $this->message->reply_to_message_id,
            'created_at' => $this->message->created_at,
        ];
    }

    public function broadcastAs()
    {
        return 'NewMessage';
    }

    protected function queueNotifications()
    {
        \Log::info('Queue new notification Job ' . json_encode($this->message));
        SendNewMessageNotifications::dispatch($this->members, $this->notificationData);
    }

    protected function prepareNotificationData()
    {
        $group = Group::find($this->message->group_id);
        $members = $group->members;
        $this->members = $members;
        $this->notificationData = [
            'message_id' => $this->message->id,
            'type' => 'message',
            'group_id' => $group->id,
            'group_title' => $group->group_title,
            'group_avatar' => $group->avatar,
            'unread_count' => 1,
            'last_message' => $this->message->text,
            'last_message_time' => now(),
            'preview' => $this->message->text,
            'url' => url("/groups/{$this->message->group_id}/" . \Illuminate\Support\Str::slug($group->group_title) . "/live-chat"),
            'user' => [
                'id' => $this->message->user->id,
                'name' => $this->message->user->name,
                'avatar' => $this->message->user->avatar,
            ],
        ];
    }
}