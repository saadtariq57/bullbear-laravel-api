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
        Schema::create('richtv_content_apis', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Name of the content API');
            $table->text('description')->comment('Description of the content API');
            $table->string('url')->comment('URL of the content API');
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('richtv_content_apis');
    }
};
