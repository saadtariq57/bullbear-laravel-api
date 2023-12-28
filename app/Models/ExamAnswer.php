<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_id',
        'question_id',
        'user_answer',
        'is_correct',
    ];

    // Define the relationships
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming the User model is imported
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class); // Assuming the Exam model is imported
    }

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'question_id'); // Assuming the ExamQuestion model is imported
    }
}

