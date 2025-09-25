<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bots', function (Blueprint $table) {
            if (!Schema::hasColumn('bots', 'engagement_config')) {
                $table->json('engagement_config')->nullable()->after('caps_on_hype')
                    ->comment('JSON config: action weights, sentiment weights, reaction weights, comment templates, length prefs, active hours');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bots', function (Blueprint $table) {
            if (Schema::hasColumn('bots', 'engagement_config')) {
                $table->dropColumn('engagement_config');
            }
        });
    }
};


