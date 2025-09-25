<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Extend enum to include 'curious' and 'critical'
        DB::statement("ALTER TABLE `engagement_logs` MODIFY COLUMN `sentiment` ENUM('positive','neutral','skeptical','curious','critical') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to the original 3-value enum
        DB::statement("ALTER TABLE `engagement_logs` MODIFY COLUMN `sentiment` ENUM('positive','neutral','skeptical') NOT NULL");
    }
};


