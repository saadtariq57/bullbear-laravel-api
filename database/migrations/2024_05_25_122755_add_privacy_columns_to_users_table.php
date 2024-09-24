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
            $table->string('status_privacy')->default('Everyone')->after('status');
            $table->string('search_index_privacy')->default('Everyone')->after('status_privacy');
            $table->string('groups_privacy')->default('Everyone')->after('search_index_privacy');
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
            $table->dropColumn('status_privacy');
            $table->dropColumn('search_index_privacy');
            $table->dropColumn('groups_privacy');
            $table->dropColumn('watchlists_privacy');
            $table->dropColumn('photos_privacy');
        });
    }
};
