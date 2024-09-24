<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplateSeeder extends Seeder
{
    public function run()
    {
        // Inserting multiple email templates
        DB::table('email_templates')->insert([
            [
                'name' => 'user_registration',
                'body' => '<p>Dear {{name}} ,<br />Welcome to our platform,&nbsp; We are glad to have you.</p>',
                'default_body' => '<p>Dear {{name}} ,<br />Welcome to our platform,&nbsp; We are glad to have you.</p>',
                'template_img' => '', // Path to a default image or empty
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'password_reset',
                'body' => '<p>Dear {{name}},</p>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p><a href="{{reset_url}}">Click here to reset your password</a></p>
<p>This password reset link will expire in 60 minutes.</p>
<p>If you did not request a password reset, no further action is required.</p>
<p>Thank you,</p>',
                'default_body' => '<p>Dear {{name}},</p>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p><a href="{{reset_url}}">Click here to reset your password</a></p>
<p>This password reset link will expire in 60 minutes.</p>
<p>If you did not request a password reset, no further action is required.</p>
<p>Thank you,</p>',
                'template_img' => '', // Path to a default image or empty
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

