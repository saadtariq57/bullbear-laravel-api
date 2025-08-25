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
        if (!Schema::hasTable('general_group_embeddings')) {
            Schema::create('general_group_embeddings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('group_id');
                $table->string('name')->nullable()->comment('Redundant group name for quick reference');
                $table->text('description');
                $table->longText('embedding')->comment('JSON array of embedding vector');
                $table->timestamps();
                
                // Foreign key constraint
                $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
                
                // Index for faster lookups
                $table->index('group_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_group_embeddings');
    }
};
