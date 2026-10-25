<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    protected $guarded = ['id'];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * TVET / CBET grading used across the portal.
     *
     * @return array{0: string, 1: string, 2: string} [grade, competency, colour]
     */
    public static function grade(?float $mark): array
    {
        return match (true) {
            $mark === null => ['-', 'Pending', 'gray'],
            $mark >= 80 => ['Distinction', 'Competent', 'green'],
            $mark >= 65 => ['Credit', 'Competent', 'blue'],
            $mark >= 50 => ['Pass', 'Competent', 'indigo'],
            default => ['Fail', 'Not Yet Competent', 'red'],
        };
    }
}
