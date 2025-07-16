<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\ResetPasswordMailable;
use Illuminate\Support\Facades\Mail;

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
        'subscription_plan_id',
        'details',
        'referrer_id',
        'last_data_update',
        'user_id',
        'groups_privacy',
        'watchlists_privacy',
        'photos_privacy',
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
    ];

    public function personalSessions()
    {
        return $this->hasMany(PersonalSession::class);
    }
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
        return $this->hasMany(Follower::class, 'following_id');
    }

    public function followings()
    {
        return $this->hasMany(Follower::class, 'follower_id');
    }
    /*public function followersUser()
    {
        return $this->belongsToMany(User::class, 'followings', 'following_id', 'follower_id',);
    }*/
    public function followingsUser()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
    }
    public function groupMemberships()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id')->withPivot('status');
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'user.notifications.' . $this->id;
    }

    public function bot()
    {
        return $this->hasOne(Bot::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function getSubscriptionFeatures()
    {
        return $this->subscriptionPlan->planFeatures()->where('enabled', true)->get();
    }

    public function hasFeature($featureName)
    {
        return $this->subscriptionPlan->planFeatures()
                    ->where('feature_name', $featureName)
                    ->where('enabled', true)
                    ->exists();
    }

    public function getFeatureLimit($featureName)
    {
        return $this->subscriptionPlan->planFeatures()
                    ->where('feature_name', $featureName)
                    ->value('limit');
    }

    /**
     * Override the default password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $this->email], false));
        Mail::to($this->email)->send(new ResetPasswordMailable($this, $resetUrl));
    }
}