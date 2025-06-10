<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trading_profits', function (Blueprint $table) {
            // Change the column to allow 8 total digits, with 2 after the decimal.
            // This will support values up to 999,999.99
            $table->decimal('profit_percentage', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trading_profits', function (Blueprint $table) {
            // Revert the column to its likely original state if needed.
            $table->decimal('profit_percentage', 5, 2)->change();
        });
    }
};