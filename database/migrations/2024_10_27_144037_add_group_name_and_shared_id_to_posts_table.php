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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('group_name')->after('group_id')->nullable();
            $table->unsignedBigInteger('shared_id')->after('group_name')->nullable();
            $table->foreign('shared_id')->references('id')->on('posts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['shared_id']);
            $table->dropColumn('shared_id');
            $table->dropColumn('group_name');
        });
    }
};
