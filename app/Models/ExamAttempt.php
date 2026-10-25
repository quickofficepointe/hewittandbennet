<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'answers' => 'array',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(OnlineExam::class, 'online_exam_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getPercentAttribute(): ?float
    {
        return $this->total > 0 ? round($this->score / $this->total * 100, 1) : null;
    }
}
