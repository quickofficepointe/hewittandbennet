<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_exams extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'online_exam_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function onlineExam()
    {
        return $this->belongsTo(OnlineExam::class, 'online_exam_id');
    }

}
