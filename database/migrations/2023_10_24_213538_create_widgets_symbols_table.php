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
        Schema::create('widget_symbols', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('widget_id');
            $table->unsignedBigInteger('symbol_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->double('price')->nullable(); // from `Wo_stock_symbols`
            $table->date('added_date')->nullable(); // from `Wo_stock_symbols`
            $table->double('peak_price')->default(0); // from `Wo_stock_symbols_data`
            $table->foreign('widget_id')->references('id')->on('widgets')->onDelete('cascade');
            $table->foreign('symbol_id')->references('id')->on('symbols')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets_symbols');
    }
};
