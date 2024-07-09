<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $fillable = [
        'widget_type',
        'date_posted',
        'layout',
        'widget_title',
        'widget_width',
        'widget_height',
        'symbols_length',
        'category_id',
        'display_order'
    ];

    public function widgetSymbols()
	{
	    return $this->hasMany(WidgetSymbol::class);
	}

    public function category()
    {
        return $this->belongsTo(WidgetCategory::class, 'category_id');
    }
}
