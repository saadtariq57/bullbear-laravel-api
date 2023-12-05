<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WidgetSymbol extends Model
{
    use HasFactory;

    protected $fillable = [
        'widget_id',
        'symbol_id',
        'price',
        'added_date',
        'peak_price'
    ];

    public function widget()
    {
        return $this->belongsTo(Widget::class);
    }

    public function symbol()
    {
        return $this->belongsTo(Symbol::class);
    }
}
