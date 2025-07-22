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
        Schema::create('news_api_endpoints', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Name of the news API endpoint');
            $table->text('description')->comment('Description of the news API endpoint');
            $table->string('url')->comment('URL of the news API endpoint');
            $table->string('provider')->comment('Provider name of the news API');
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('name');
            $table->index('provider');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_api_endpoints');
    }
};
