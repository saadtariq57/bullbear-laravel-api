<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Update existing 'Everyone' values to 'Online'
        DB::table('users')->where('status_privacy', 'Everyone')->update(['status_privacy' => 'Online']);

        // Modify the column to have only two enum values ('Online' and 'Offline')
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status_privacy', ['Online', 'Offline'])->default('Online')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Revert back to the original enum values
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status_privacy', ['Everyone', 'Online', 'Offline'])->default('Everyone')->change();
        });
    }
};
