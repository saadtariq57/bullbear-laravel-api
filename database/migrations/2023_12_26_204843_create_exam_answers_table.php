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
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Column to store the user ID who attempted the exam
            $table->unsignedBigInteger('exam_id'); // Column to store the ID of the exam attempted
            $table->unsignedBigInteger('question_id'); // Column to store the ID of the question attempted
            $table->text('user_answer')->nullable(); // Column to store the user's selected answer
            $table->boolean('is_correct')->default(false); // Column to indicate if the user's answer is correct or not
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('exam_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_answers');
    }
};