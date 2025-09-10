<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the action_type enum to remove 'comment' option
        // Only allow 'react' and 'react+comment'
        DB::statement("ALTER TABLE `engagement_logs` MODIFY COLUMN `action_type` ENUM('react','react+comment') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum with 'comment' option
        DB::statement("ALTER TABLE `engagement_logs` MODIFY COLUMN `action_type` ENUM('react','comment','react+comment') NOT NULL");
    }
};
