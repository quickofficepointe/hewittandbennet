<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(courses::class, 'course_id');
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function timetable()
    {
        return $this->hasMany(TimetableEntry::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function materials()
    {
        return $this->hasMany(LearningMaterial::class);
    }

    public function exams()
    {
        return $this->hasMany(OnlineExam::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /** Active students taking this unit: same course and currently in the unit's term. */
    public function students()
    {
        return Student::where('course_id', $this->course_id)
            ->where('current_term', $this->term_no)
            ->where('status', 'active')
            ->orderBy('first_name')->orderBy('last_name');
    }

    public function isTakenBy(Student $student): bool
    {
        return $student->course_id === $this->course_id;
    }

    /** Learning outcomes, one per line in the stored text. */
    public function getOutcomesAttribute(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->learning_outcomes))
            ->map(fn ($line) => trim($line, " \t-*"))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Weighted final mark (0-100) from published assessments only.
     * Returns null when the student has no published marks yet.
     */
    public function finalMarkFor(Student $student): ?float
    {
        $assessments = $this->assessments()->where('published', true)
            ->with(['results' => fn ($q) => $q->where('student_id', $student->id)])
            ->get();

        $weightSum = 0;
        $total = 0;
        foreach ($assessments as $assessment) {
            $result = $assessment->results->first();
            if (! $result || $result->score === null || $assessment->max_score <= 0) {
                continue;
            }
            $weightSum += $assessment->weight;
            $total += ($result->score / $assessment->max_score) * $assessment->weight;
        }

        return $weightSum > 0 ? round($total / $weightSum * 100, 1) : null;
    }
}
