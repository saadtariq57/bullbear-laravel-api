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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('group_id')->nullable(); // For referencing old DB
            $table->string('group_name', 32);
            $table->string('group_title', 40);
            $table->string('avatar', 120)->default('upload/photos/d-group.jpg');
            $table->string('cover', 120)->default('upload/photos/d-cover.jpg');
            $table->text('about')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('privacy', 120)->default('public');
            $table->enum('join_privacy', ['1', '2'])->default('1');
            $table->enum('active', ['0', '1'])->default('0');
            $table->unsignedBigInteger('time');
            $table->string('symbol', 10)->nullable();
            $table->string('exchange', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
