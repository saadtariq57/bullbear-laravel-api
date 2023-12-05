<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'stripe_product_id',
        'stripe_monthly_price_id',
        'stripe_yearly_price_id',
        'description',
        'features',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'features' => 'array',
    ];

    /**
     * Get the features attribute.
     *
     * @param  string  $value
     * @return array
     */
    public function getFeaturesAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Set the features attribute.
     *
     * @param  array  $value
     * @return void
     */
    public function setFeaturesAttribute($value)
    {
        $this->attributes['features'] = json_encode($value);
    }
}