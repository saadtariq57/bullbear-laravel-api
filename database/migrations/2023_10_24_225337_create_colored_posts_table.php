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
        Schema::create('colored_posts', function (Blueprint $table) {
            $table->id();
            $table->string('color_1', 50);
            $table->string('color_2', 50);
            $table->string('text_color', 50);
            $table->timestamp('created_at')->useCurrent();
            $table->index(['color_1', 'color_2']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colored_posts');
    }
};
