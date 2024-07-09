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
        Schema::create('symbols', function (Blueprint $table) {
            $table->id();
            $table->string('symbol')->unique();
            $table->string('name', 255)->nullable();
            $table->string('currency', 255)->nullable();
            $table->string('exchange', 255)->nullable();
            $table->string('cik_code', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->enum('type', ['stocks', 'etf', 'indices', 'crypto', 'futures', 'bonds', 'trust', 'fund'])->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('symbols');
    }
};