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
        Schema::table('bots', function (Blueprint $table) {
            // Behavior style fields
            $table->enum('slang_level', ['none', 'low', 'medium', 'high'])->nullable()->after('group_post_probability');
            $table->enum('emoji_use', ['none', 'low', 'medium', 'heavy'])->nullable()->after('slang_level');
            $table->enum('punctuation', ['perfect', 'light', 'broken'])->nullable()->after('emoji_use');
            
            // Array fields stored as JSON
            $table->json('misspellings')->nullable()->after('punctuation')->comment('Common intentional misspellings');
            $table->json('quirks')->nullable()->after('misspellings')->comment('Behavioral quirks like catchphrases or habits');
            $table->json('post_style')->nullable()->after('quirks')->comment('Preferred formats like one-liner, short rant, bullet points');
            $table->json('formats')->nullable()->after('post_style')->comment('Special post types like reaction only, stat dump, meme comment');
            
            // Boolean behavior flag
            $table->boolean('caps_on_hype')->default(false)->after('formats')->comment('Use ALL CAPS on hype posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bots', function (Blueprint $table) {
            $table->dropColumn([
                'slang_level',
                'emoji_use', 
                'punctuation',
                'misspellings',
                'quirks',
                'post_style',
                'formats',
                'caps_on_hype'
            ]);
        });
    }
};
