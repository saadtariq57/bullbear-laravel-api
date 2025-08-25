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
        // Use raw SQL to modify ENUM to include 'bot' to avoid Doctrine DBAL enum issues
        DB::statement("ALTER TABLE `users` MODIFY `type` ENUM('user','admin','bot') NOT NULL DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert ENUM to original values
        DB::statement("ALTER TABLE `users` MODIFY `type` ENUM('user','admin') NOT NULL DEFAULT 'user'");
    }
};
