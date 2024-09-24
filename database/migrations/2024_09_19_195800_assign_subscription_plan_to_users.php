<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AssignSubscriptionPlanToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        // Ensure the free plan exists
        $freePlan = DB::table('subscription_plans')->where('id', 1)->first();
        if (!$freePlan) {
            throw new \Exception('Free plan with id=1 does not exist in subscription_plans table.');
        }

        // Fetch all users
        $users = DB::table('users')->select('id')->get();

        foreach ($users as $user) {
            // Check for active subscription
            $subscription = DB::table('subscriptions')
                ->where('user_id', $user->id)
                ->where('stripe_status', 'active')
                ->first();

            if ($subscription) {
                // Find the corresponding plan based on stripe_price
                $plan = DB::table('subscription_plans')
                    ->where('stripe_monthly_price_id', $subscription->stripe_price)
                    ->orWhere('stripe_yearly_price_id', $subscription->stripe_price)
                    ->first();

                if ($plan) {
                    // Assign the found plan's id
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['subscription_plan_id' => $plan->id]);
                } else {
                    // If no matching plan is found, assign free plan
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['subscription_plan_id' => 1]);
                }
            } else {
                // No active subscription, assign free plan
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['subscription_plan_id' => 1]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        // Optionally, you can reset subscription_plan_id to null
        DB::table('users')->update(['subscription_plan_id' => null]);
    }
}
