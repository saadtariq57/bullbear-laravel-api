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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('value'); // changed from varchar(20000) to text for flexibility
            $table->json('meta')->nullable(); // Optional metadata if needed for extra context

            $table->timestamps(); // Optional: To track when a configuration was updated
            $table->unique('name'); // Ensures each config name is unique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config');
    }
};
