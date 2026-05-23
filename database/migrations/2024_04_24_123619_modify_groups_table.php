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
        Schema::table('groups', function (Blueprint $table) {
            // Change the 'join_privacy' column to enum with values 'public' or 'private'
            $table->string('join_privacy', 20)->default('public')->change();

            // Set default values for 'avatar' and 'cover'
            $table->string('avatar', 120)->default('photos/d-group.jpg')->change();
            $table->string('cover', 120)->default('photos/d-cover.jpg')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            // Revert the 'join_privacy' changes
            $table->enum('join_privacy', ['1', '2'])->default('1')->change();

            // Revert the 'avatar' and 'cover' default values
            $table->string('avatar', 120)->default('uploads/photos/d-group.jpg')->change();
            $table->string('cover', 120)->default('uploads/photos/d-group.jpg')->change();
        });
    }
};
