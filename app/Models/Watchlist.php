<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWatchlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'watchlist_id',
        'user_id',
        'title',
        'who_can_view',
        'featured',
        'symbol_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
