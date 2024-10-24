<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconPathToEbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('ebooks', function (Blueprint $table) {
            $table->string('icon_path')->after('file_path')->nullable()->comment('Path to the E-book icon image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('ebooks', function (Blueprint $table) {
            $table->dropColumn('icon_path');
        });
    }
}
