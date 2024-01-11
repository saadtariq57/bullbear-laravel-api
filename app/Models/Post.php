<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'post_id', // If this is for referencing the old DB, consider renaming for clarity
        'post_text',
        'post_link',
        'post_link_title',
        'post_link_image',
        'post_link_content',
        'post_type',
        'multi_image',
        'post_youtube',
        'post_file',
        'post_file_name',
        'colored_post_id',
        'comments_status',
        'active',
        'post_privacy'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class); // Assuming you have a Group model
    }

    public function coloredPost()
    {
        return $this->belongsTo(ColoredPost::class);
    }

    public function photos()
    {
        return $this->hasMany(PostPhoto::class);
    }

    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
}
