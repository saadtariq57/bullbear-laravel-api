<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use App\Models\PlanFeatures;

class SubscriptionPlansSeeder extends Seeder
{
    public function run()
    {
        // Define the subscription plans
        $plans = [
            'Free' => [
                'stripe_product_id' => 'prod_QsE6jH20fIJRGE',
                'stripe_monthly_price_id' => 'price_1Q0TdvJYG6q3yq60ItzXbw7K',
                'stripe_yearly_price_id' => 'price_1Q0TdvJYG6q3yq60AjykirVu',
                'description' => 'Free Plan: Perfect for beginners to start tracking stocks and gain access to essential market insights and tools.',
                'features' => [
                    ['feature_name' => 'real_time_watchlists', 'feature_type' => 'limit', 'limit' => 2, 'enabled' => true],
                    ['feature_name' => 'market_insights_digest', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'community_chatroom_access', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'richtv_live', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'daily_watchlist_snapshot_email', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'basic_alerts', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                ],
            ],
            'Pro' => [
                'stripe_product_id' => 'prod_Pn8jFBP9gltMKX',
                'stripe_monthly_price_id' => 'price_1OxYRgJYG6q3yq60lKtlNOyP',
                'stripe_yearly_price_id' => 'price_1OxYVSJYG6q3yq60MR7zLNrn',
                'description' => 'Pro Plan: Designed for advanced users seeking more watchlists, personalized insights, and exclusive resources.',
                'features' => [
                    ['feature_name' => 'real_time_watchlists', 'feature_type' => 'limit', 'limit' => 5, 'enabled' => true],
                    ['feature_name' => 'stock_screener_access', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'richpicks_pro_access', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'pro_chatroom_access', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'daily_pro_watchlist_email', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'monthly_personal_session', 'feature_type' => 'limit', 'limit' => 1, 'enabled' => true],
                    ['feature_name' => 'basic_trading_exams', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'educational_content', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                ],
            ],
            'Premium' => [
                'stripe_product_id' => 'prod_Pn8cPkJWhn6sCZ',
                'stripe_monthly_price_id' => 'price_1OxYLgJYG6q3yq60SKQtVXe3',
                'stripe_yearly_price_id' => 'price_1OxYQJJYG6q3yq60NTTyeudH',
                'description' => 'Premium Plan: For serious traders requiring maximum flexibility, advanced tools, and exclusive market intelligence.',
                'features' => [
                    ['feature_name' => 'real_time_watchlists', 'feature_type' => 'limit', 'limit' => 10, 'enabled' => true],
                    ['feature_name' => 'advanced_stock_screener', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'richpicks_premium', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'advanced_exam_trading_videos', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'pro_meeting_chat_sessions', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'daily_premium_watchlist_email', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'monthly_personal_session', 'feature_type' => 'limit', 'limit' => 2, 'enabled' => true],
                    ['feature_name' => 'advanced_trading_exams', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                    ['feature_name' => 'exclusive_market_intelligence', 'feature_type' => 'boolean', 'limit' => null, 'enabled' => true],
                ],
            ],
        ];

        foreach ($plans as $planName => $planData) {
            $plan = SubscriptionPlan::create([
                'name' => $planName,
                'stripe_product_id' => $planData['stripe_product_id'],
                'stripe_monthly_price_id' => $planData['stripe_monthly_price_id'],
                'stripe_yearly_price_id' => $planData['stripe_yearly_price_id'],
                'description' => $planData['description'],
            ]);

            foreach ($planData['features'] as $feature) {
                $plan->planFeatures()->create($feature);
            }
        }
    }
}