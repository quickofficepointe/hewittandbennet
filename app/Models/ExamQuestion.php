<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'options' => 'array',
        'correct_option' => 'integer',
        'marks' => 'integer',
    ];

    public function exam()
    {
        return $this->belongsTo(OnlineExam::class, 'online_exam_id');
    }
}
