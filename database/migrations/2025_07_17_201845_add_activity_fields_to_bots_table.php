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
            $table->enum('post_frequency', ['low', 'medium', 'high'])->default('low')->after('is_active');
            $table->integer('activity_level')->default(3)->comment('Activity level from 1-10')->after('post_frequency');
            $table->timestamp('last_active')->nullable()->after('activity_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bots', function (Blueprint $table) {
            $table->dropColumn(['post_frequency', 'activity_level', 'last_active']);
        });
    }
};
