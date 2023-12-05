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
		Schema::create('posts', function (Blueprint $table) {
		    $table->id();
		    $table->unsignedBigInteger('user_id');
		    $table->unsignedBigInteger('group_id')->nullable(); // For posts in groups
		    $table->integer('post_id')->nullable(); // For referencing old DB
		    $table->text('post_text')->nullable();
		    $table->string('post_link', 1000)->nullable();
		    $table->text('post_link_title')->nullable();
		    $table->string('post_link_image', 1000)->nullable();
		    $table->text('post_link_content')->nullable();
		    $table->enum('post_type', ['text', 'link', 'photo', 'video', 'file', 'poll', 'color'])->nullable();
		    $table->enum('multi_image', ['0', '1'])->default('0');
		    $table->string('post_youtube', 255)->nullable();
		    $table->string('post_file', 255)->nullable();
		    $table->string('post_file_name', 200)->nullable();
		    $table->unsignedBigInteger('colored_post_id')->nullable();
		    $table->integer('comments_status')->default(1);
		    $table->integer('active')->default(1);
		    $table->timestamps();
		    // Foreign key constraints
		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		    $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null'); // Assuming you have a groups table
		    $table->foreign('colored_post_id')->references('id')->on('colored_posts')->onDelete('set null');
		});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
