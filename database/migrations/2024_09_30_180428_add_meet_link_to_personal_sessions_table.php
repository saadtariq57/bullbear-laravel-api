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
        Schema::table('personal_sessions', function (Blueprint $table) {
            $table->string('meet_link')->nullable(); // Add the meet_link column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('personal_sessions', function (Blueprint $table) {
            $table->dropColumn('meet_link'); // Remove the meet_link column if rolling back
        });
    }
};
