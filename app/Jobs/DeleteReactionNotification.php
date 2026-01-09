<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DeleteReactionNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $postId;
    protected $commentId;
    protected $messageId;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $postId = null, $commentId = null, $messageId = null)
    {
        $this->userId = $userId;
        $this->postId = $postId;
        $this->commentId = $commentId;
        $this->messageId = $messageId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificationQuery = DB::table('notifications')
            ->where('type', 'App\Notifications\NewPostReactionNotification')
            ->where('data->reacted_by', $this->userId);

        if ($this->postId) {
            $notificationQuery->whereJsonContains('data->post_id', $this->postId);
        }
        if ($this->commentId) {
            $notificationQuery->whereJsonContains('data->comment_id', $this->commentId);
        }
        if ($this->messageId) {
            $notificationQuery->whereJsonContains('data->message_id', $this->messageId);
        }

        $notificationQuery->delete();
    }
}
