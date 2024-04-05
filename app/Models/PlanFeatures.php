<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanFeatures extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id',
        'feature_name',
        'feature_type',
        'limit',
        'enabled',
    ];

    /**
     * Get the subscription plan that this feature belongs to.
     */
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }
}