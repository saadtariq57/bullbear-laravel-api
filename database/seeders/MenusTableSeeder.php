<?php

// MenusTableSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('menus')->insert([
            [
                'id' => 1,
                'name' => 'Main Menu',
                'created_at' => '2024-05-21 12:55:41',
                'updated_at' => '2024-05-22 07:03:09',
            ],
            // Add more menu data here if needed
        ]);
    }
}

