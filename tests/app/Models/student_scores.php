<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_scores extends Model
{
    use HasFactory;
    protected $fillable = ['online_exam_id', 'score', 'student_id', 'tutor_id'];

    public function onlineExam()
    {
        return $this->belongsTo(online_exams::class, 'online_exam_id');
    }



    public function tutor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function student()
{
    return $this->belongsTo(student_data::class, 'student_id');
}

}



