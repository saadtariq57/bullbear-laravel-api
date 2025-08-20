<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RichTvContentApi extends Model
{
    use HasFactory;

    protected $table = 'richtv_content_apis';

    protected $fillable = [
        'name',
        'description',
        'url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}


