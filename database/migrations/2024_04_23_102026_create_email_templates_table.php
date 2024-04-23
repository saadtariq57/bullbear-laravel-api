<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('body');
            $table->text('default_body');
            $table->text('template_img');
            $table->timestamps();
        });
        // Directly seeding after creating the table
        $seeder = new \Database\Seeders\EmailTemplateSeeder();
        $seeder->run();
    }

    public function down()
    {
        Schema::dropIfExists('email_templates');
    }
};