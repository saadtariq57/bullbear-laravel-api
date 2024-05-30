<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class webinar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'zoom_join_link',
        'date',
        'start_time',
        'end_time',
    ];
}
