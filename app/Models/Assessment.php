<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    public const TYPES = ['cat' => 'CAT', 'assignment' => 'Assignment', 'practical' => 'Practical', 'project' => 'Project', 'exam' => 'Final Exam'];

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
        'published' => 'boolean',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function term()
    {
        return $this->belongsTo(AcademicTerm::class, 'academic_term_id');
    }

    public function results()
    {
        return $this->hasMany(AssessmentResult::class);
    }
}
