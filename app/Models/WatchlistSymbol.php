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
        'symbol_id',
        'position',
        'alert_price_above',
        'alert_price_below',
        'alerts_enabled',
        'alert_triggered_above',
        'alert_triggered_below',
        'alert_last_triggered_at',
    ];

    protected $casts = [
        'alert_price_above' => 'float',
        'alert_price_below' => 'float',
        'alerts_enabled' => 'boolean',
        'alert_triggered_above' => 'boolean',
        'alert_triggered_below' => 'boolean',
        'alert_last_triggered_at' => 'datetime',
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

    /**
     * Threshold fields exposed to API consumers (Next.js).
     */
    public function getThresholdsAttribute(): array
    {
        return [
            'price_above' => $this->alert_price_above,
            'price_below' => $this->alert_price_below,
            'alerts_enabled' => $this->alerts_enabled,
            'last_triggered_at' => $this->alert_last_triggered_at,
        ];
    }

    protected $appends = ['thresholds'];
}
