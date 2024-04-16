<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'phone_number',
        'city',
        'state',
        'zip',
        'avatar',
        'cover',
        'website',
        'twitter',
        'linkedin',
        'youtube',
        'follow_privacy',
        'post_privacy',
        'showlastseen',
        'emailNotification',
        'about',
        'status',
        'type',
        'subscription_plan',
        'details',
        'referrer_id',
        'last_data_update',
        'user_id',
        // Cashier related fields
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        // You might want to hide billing related fields as well
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'details' => 'array',
        'showlastseen' => 'boolean',
        'emailNotification' => 'boolean',
        // Other casts as necessary
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function watchlists()
    {
        return $this->hasMany(UserWatchlist::class);
    }

    public function followers()
    {
        // This assumes your Follower model is named 'Follower'
        return $this->hasMany(Follower::class, 'following_id');
    }
    
    public function groupMemberships()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id');
    }

}