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
        Schema::table('reactions', function (Blueprint $table) {
            // Add composite indexes for common query patterns
            $table->index(['user_id', 'post_id'], 'reactions_user_post_index');
            $table->index(['user_id', 'comment_id'], 'reactions_user_comment_index');
            $table->index(['user_id', 'message_id'], 'reactions_user_message_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reactions', function (Blueprint $table) {
            $table->dropIndex('reactions_user_post_index');
            $table->dropIndex('reactions_user_comment_index');
            $table->dropIndex('reactions_user_message_index');
        });
    }
};
