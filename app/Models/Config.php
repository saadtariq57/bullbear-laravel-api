<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'meta'
    ];

    // Optionally, you can cast the 'meta' column to an array for easy interaction
    protected $casts = [
        'meta' => 'array'
    ];
}
