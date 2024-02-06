<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'group_name',
        'group_title',
        'avatar',
        'cover',
        'about',
        'category_id',
        'privacy',
        'join_privacy',
        'active',
        'time',
        'symbol',
        'exchange'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(GroupCategory::class, 'category_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
