<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingProfit extends Model
{
    use HasFactory;

    protected $fillable = [
        'trading_report_id',
        'date',
        'symbol',
        'profit_percentage',
        'linkedin_post_link',
        'tradingview_post_link',
        'web_post_link',
    ];

    public function report()
    {
        return $this->belongsTo(TradingReport::class, 'trading_report_id');
    }
}