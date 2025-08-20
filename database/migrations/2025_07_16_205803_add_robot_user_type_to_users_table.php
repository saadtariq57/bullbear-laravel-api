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
        // Ensure 'bot' is present in enum (idempotent with previous migration)
        DB::statement("ALTER TABLE `users` MODIFY `type` ENUM('user','admin','bot') NOT NULL DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE `users` MODIFY `type` ENUM('user','admin') NOT NULL DEFAULT 'user'");
    }
};
