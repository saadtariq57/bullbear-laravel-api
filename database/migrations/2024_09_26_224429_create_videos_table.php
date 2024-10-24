<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('playlist_id');
            $table->string('channel_title')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('thumbnail_url');
            $table->string('youtube_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
