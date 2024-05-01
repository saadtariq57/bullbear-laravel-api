<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplateSeeder extends Seeder
{
    public function run()
    {
        DB::table('email_templates')->insert([
            'name' => 'Empty Template',
            'body' => '', // Empty body
            'default_body' => '', // Empty default body
            'template_img' => '', // Path to a default image or empty
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

