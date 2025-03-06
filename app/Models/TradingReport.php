<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(TradingPerformanceCategory::class, 'category_id');
    }

    public function profits()
    {
        return $this->hasMany(TradingProfit::class);
    }
}