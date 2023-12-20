<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchlistSymbol extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'watchlist_id',
        'symbol_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userWatchlist()
    {
        return $this->belongsTo(UserWatchlist::class, 'watchlist_id');
    }

    // Assuming you have a `Symbol` model
    public function symbol()
    {
        return $this->belongsTo(Symbol::class);
    }
}
