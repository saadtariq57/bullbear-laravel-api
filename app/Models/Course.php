<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'drive_link',
        'icon_path',
    ];

    protected $appends = ['icon_url'];

    public function getIconUrlAttribute()
    {
        return asset('uploads/' . $this->icon_path);
    }

    public $timestamps = false;
}
