<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    // Assuming you might have a relationship between categories and exams
    public function exams()
    {
        return $this->hasMany(Exam::class, 'category', 'name');
    }
}
