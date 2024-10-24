<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'thumbnail_url',
        'youtube_id',
        'playlist_id',
        'channel_title',
        'published_at',
    ];

    public $timestamps = false;
}
