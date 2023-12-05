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
            $table->string('name', 100);
            $table->string('exchange', 100)->nullable();
            $table->string('company_name', 500)->nullable();
            $table->string('currency', 50)->nullable();
            $table->string('mic_code', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->json('available_exchanges')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            // Additional columns from other tables if needed...
            $table->unique(['name', 'exchange']);
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
