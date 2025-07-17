<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_responses extends Model
{
    use HasFactory;

protected $fillable = [
        'user_id',
        'question_id',
        'answers',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(questions::class, 'question_id');
    }

    public function studentExam()
    {
        return $this->belongsTo(student_exams::class, 'student_exam_id');
    }


}
