<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'number_of_questions',
        'per_question_time_limit',
        'featured_img'
    ];

    public function questions() {
	    return $this->hasMany(ExamQuestion::class);
	}

	public function results() {
	    return $this->hasMany(ExamResult::class);
	}

	public function category() {
	    return $this->belongsTo(ExamCategory::class, 'category', 'name');
	}
}
