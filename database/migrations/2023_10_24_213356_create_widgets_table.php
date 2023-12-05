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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('widget_type', 255); // former stock_type
            $table->timestamp('date_posted')->nullable();
            $table->string('layout', 255)->nullable();
            $table->string('widget_title', 255)->nullable();
            $table->string('widget_width', 255)->nullable();
            $table->string('widget_height', 255)->nullable();
            $table->integer('symbols_length')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};