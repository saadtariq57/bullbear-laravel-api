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
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('following_id'); // User being followed
            $table->unsignedBigInteger('follower_id');  // User who follows
            $table->unsignedTinyInteger('active')->default(1); // 1 if following, 0 if unfollowed
            $table->unsignedInteger('time'); // Timestamp of when the follow action was done
            
            $table->index(['following_id']);
            $table->index(['follower_id']);
            $table->index(['active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
