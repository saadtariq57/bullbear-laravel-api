<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSubscriptionPlanFromUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('subscription_plan');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('subscription_plan', 100)->default('free');
        });
    }
}