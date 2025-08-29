<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_id',
        'post_id',
        'action_type',
        'reaction_type_id',
        'comment_id',
        'sentiment',
    ];

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function reactionType()
    {
        return $this->belongsTo(ReactionType::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}


