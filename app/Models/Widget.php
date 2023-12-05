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
        'symbols_length'
    ];

    public function symbols()
	{
	    return $this->hasMany(WidgetSymbol::class);
	}
}
