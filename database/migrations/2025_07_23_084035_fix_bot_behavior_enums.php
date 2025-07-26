<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if misspellings column exists and drop it
        if (Schema::hasColumn('bots', 'misspellings')) {
            Schema::table('bots', function (Blueprint $table) {
                $table->dropColumn('misspellings');
            });
        }

        // First expand the enums to include both old and new values
        DB::statement("ALTER TABLE bots MODIFY COLUMN slang_level ENUM('none', 'low', 'medium', 'high', 'very low', 'occasional', 'moderate', 'frequent', 'heavy') NULL");
        DB::statement("ALTER TABLE bots MODIFY COLUMN emoji_use ENUM('none', 'low', 'medium', 'heavy', 'very low', 'occasional', 'moderate', 'frequent') NULL");
        DB::statement("ALTER TABLE bots MODIFY COLUMN punctuation ENUM('perfect', 'light', 'broken', 'none', 'very low', 'low', 'occasional', 'moderate', 'frequent', 'heavy') NULL");

        // Update existing data to new values
        DB::statement("UPDATE bots SET slang_level = 'low' WHERE slang_level = 'medium'");
        DB::statement("UPDATE bots SET slang_level = 'heavy' WHERE slang_level = 'high'");
        
        DB::statement("UPDATE bots SET emoji_use = 'moderate' WHERE emoji_use = 'medium'");
        
        DB::statement("UPDATE bots SET punctuation = 'low' WHERE punctuation = 'perfect'");
        DB::statement("UPDATE bots SET punctuation = 'moderate' WHERE punctuation = 'light'");
        DB::statement("UPDATE bots SET punctuation = 'heavy' WHERE punctuation = 'broken'");

        // Now set the final enum values with only the new ones
        DB::statement("ALTER TABLE bots MODIFY COLUMN slang_level ENUM('none', 'very low', 'low', 'occasional', 'moderate', 'frequent', 'heavy') NULL");
        DB::statement("ALTER TABLE bots MODIFY COLUMN emoji_use ENUM('none', 'very low', 'low', 'occasional', 'moderate', 'frequent', 'heavy') NULL");
        DB::statement("ALTER TABLE bots MODIFY COLUMN punctuation ENUM('none', 'very low', 'low', 'occasional', 'moderate', 'frequent', 'heavy') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the misspellings field
        Schema::table('bots', function (Blueprint $table) {
            $table->json('misspellings')->nullable()->after('punctuation')->comment('Common intentional misspellings');
        });

        // Revert to original enum values (map current values back)
        DB::statement("UPDATE bots SET slang_level = 'medium' WHERE slang_level = 'low'");
        DB::statement("UPDATE bots SET slang_level = 'high' WHERE slang_level = 'heavy'");
        
        DB::statement("UPDATE bots SET emoji_use = 'medium' WHERE emoji_use = 'moderate'");
        
        DB::statement("UPDATE bots SET punctuation = 'perfect' WHERE punctuation = 'low'");
        DB::statement("UPDATE bots SET punctuation = 'light' WHERE punctuation = 'moderate'");
        DB::statement("UPDATE bots SET punctuation = 'broken' WHERE punctuation = 'heavy'");

        // Revert enum fields to original values
        DB::statement("ALTER TABLE bots MODIFY COLUMN slang_level ENUM('none', 'low', 'medium', 'high') NULL");
        DB::statement("ALTER TABLE bots MODIFY COLUMN emoji_use ENUM('none', 'low', 'medium', 'heavy') NULL");
        DB::statement("ALTER TABLE bots MODIFY COLUMN punctuation ENUM('perfect', 'light', 'broken') NULL");
    }
};
