<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('watchlist_symbols', function (Blueprint $table) {
            $table->decimal('alert_price_above', 16, 4)->nullable()->after('position');
            $table->decimal('alert_price_below', 16, 4)->nullable()->after('alert_price_above');
            $table->boolean('alerts_enabled')->default(false)->after('alert_price_below');
            $table->boolean('alert_triggered_above')->default(false)->after('alerts_enabled');
            $table->boolean('alert_triggered_below')->default(false)->after('alert_triggered_above');
            $table->timestamp('alert_last_triggered_at')->nullable()->after('alert_triggered_below');
        });
    }

    public function down(): void
    {
        Schema::table('watchlist_symbols', function (Blueprint $table) {
            $table->dropColumn([
                'alert_price_above',
                'alert_price_below',
                'alerts_enabled',
                'alert_triggered_above',
                'alert_triggered_below',
                'alert_last_triggered_at',
            ]);
        });
    }
};
