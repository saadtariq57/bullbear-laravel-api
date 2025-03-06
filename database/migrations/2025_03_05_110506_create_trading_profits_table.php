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
    Schema::create('trading_profits', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('trading_report_id');
        $table->date('date');
        $table->string('symbol');
        $table->decimal('profit_percentage', 5, 2);
        $table->string('linkedin_post_link')->nullable();
        $table->string('tradingview_post_link')->nullable();
        $table->string('web_post_link')->nullable();
        $table->timestamps();

        // Define foreign key constraint
        $table->foreign('trading_report_id')->references('id')->on('trading_reports')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_profits');
    }
};
