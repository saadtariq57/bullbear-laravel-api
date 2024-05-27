<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('menu_relation')->after('url')->default('parent');
            $table->string('menu_type')->after('parent_id');
            $table->unsignedBigInteger('widget_id')->nullable()->after('menu_type');
            // $table->string('widget_name')->nullable()->after('widget_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('menu_relation');
            $table->dropColumn('menu_type');
            $table->dropColumn('widget_id');
            // $table->dropColumn('widget_name');
        });
    }
}
