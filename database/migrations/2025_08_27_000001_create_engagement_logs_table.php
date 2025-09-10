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
        if (!Schema::hasTable('engagement_logs')) {
            Schema::create('engagement_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('bot_id')->constrained('bots')->onDelete('cascade');
                $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
                $table->enum('action_type', ['react', 'react+comment']);
                $table->foreignId('reaction_type_id')->nullable()->constrained('reaction_types')->nullOnDelete();
                $table->foreignId('comment_id')->nullable()->constrained('comments')->nullOnDelete();
                $table->enum('sentiment', ['positive', 'neutral', 'skeptical']);
                $table->timestamps();

                $table->index(['bot_id', 'post_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engagement_logs');
    }
};


