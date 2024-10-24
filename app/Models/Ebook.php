<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ebooks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'icon_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['file_url', 'icon_url'];

    /**
     * Get the full URL for the E-book file.
     *
     * @return string
     */
    public function getFileUrlAttribute()
    {
        return asset('uploads/' . $this->file_path);
    }

    /**
     * Get the full URL for the E-book icon image.
     *
     * @return string
     */
    public function getIconUrlAttribute()
    {
        return asset('uploads/' . $this->icon_path);
    }
}