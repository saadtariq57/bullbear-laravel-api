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
        Schema::table('users', function (Blueprint $table) {
            $table->string('groups_privacy')->default('Everyone')->after('post_privacy');
            $table->string('watchlists_privacy')->default('Everyone')->after('groups_privacy');
            $table->string('photos_privacy')->default('Everyone')->after('watchlists_privacy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('groups_privacy');
            $table->dropColumn('watchlists_privacy');
            $table->dropColumn('photos_privacy');
        });
    }
};
