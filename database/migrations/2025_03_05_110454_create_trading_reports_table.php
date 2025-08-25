<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('trading_reports')) {
            Schema::create('trading_reports', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->unsignedBigInteger('category_id');
                $table->text('description')->nullable();
                $table->timestamps();

                $table->foreign('category_id')->references('id')->on('trading_performance_categories')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_reports');
    }
};
