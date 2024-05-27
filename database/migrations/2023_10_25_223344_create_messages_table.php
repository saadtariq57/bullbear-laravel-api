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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->text('text')->nullable();
            $table->string('media', 255)->nullable();
            $table->string('media_file_name', 200)->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->boolean('sent_push')->default(false);
            $table->string('notification_id', 50)->nullable();
            $table->unsignedBigInteger('reply_to_message_id')->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reply_to_message_id')->references('id')->on('messages')->onDelete('set null');

            $table->index(['group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
