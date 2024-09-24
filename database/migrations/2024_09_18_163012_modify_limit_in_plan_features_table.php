<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyLimitInPlanFeaturesTable extends Migration
{
    public function up()
    {
        Schema::table('plan_features', function (Blueprint $table) {
            $table->integer('limit')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('plan_features', function (Blueprint $table) {
            $table->text('limit')->nullable()->change();
        });
    }
}