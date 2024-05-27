<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'embeded_code'];
}