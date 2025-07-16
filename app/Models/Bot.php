<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'role',
        'style',
        'topics',
        'instructions',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'topics' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the bot.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
