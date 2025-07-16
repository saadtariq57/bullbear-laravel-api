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
        Schema::create('bots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role')->nullable(); // e.g., "moderator", "assistant", "entertainment"
            $table->string('style')->nullable(); // e.g., "friendly", "professional", "casual"
            $table->json('topics')->nullable(); // ["technology", "sports", "news"]
            $table->text('instructions')->nullable(); // AI instructions
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index for better performance
            $table->index(['user_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bots');
    }
};
