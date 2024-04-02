<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Initial columns from the first migration
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            // Additional columns from the second migration
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 32)->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone_number', 32)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip', 11)->nullable();
            $table->string('avatar')->default('upload/photos/d-avatar.jpg');
            $table->string('cover')->default('upload/photos/d-cover.jpg');
            $table->string('website', 50)->nullable();
            $table->string('twitter', 50)->nullable();
            $table->string('linkedin', 32)->nullable();
            $table->string('youtube', 100)->nullable();
            $table->enum('follow_privacy', ['public', 'private'])->default('public');
            $table->string('post_privacy')->default('ifollow');
            $table->boolean('showlastseen')->default(true);
            $table->boolean('emailNotification')->default(true);
            $table->text('about')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->enum('type', ['user', 'admin'])->default('user');
            $table->string('subscription_plan', 100)->default('free');
            $table->json('details')->nullable();
            $table->unsignedInteger('referrer_id')->nullable();
            $table->timestamp('last_data_update')->nullable();
            $table->unsignedInteger('user_id')->nullable();
        });

        // Creating a default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@richtv.io',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'created_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
