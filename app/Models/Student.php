<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    public const STATUSES = ['active', 'deferred', 'suspended', 'graduated', 'discontinued'];

    protected $guarded = ['id'];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(courses::class, 'course_id');
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function results()
    {
        return $this->hasMany(AssessmentResult::class);
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /** Units of the student's course, optionally limited to the current term. */
    public function units(bool $currentTermOnly = false)
    {
        return Unit::where('course_id', $this->course_id)
            ->when($currentTermOnly, fn ($q) => $q->where('term_no', $this->current_term))
            ->orderBy('term_no')->orderBy('code');
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getTotalBilledAttribute(): float
    {
        return (float) $this->invoices()->sum('amount');
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function getBalanceAttribute(): float
    {
        return $this->total_billed - $this->total_paid;
    }

    /** Adds `billed` and `paid` sub-select columns so balances can be listed without N+1 queries. */
    public function scopeWithBalance($query)
    {
        return $query->select('students.*')->addSelect([
            'billed' => Invoice::selectRaw('COALESCE(SUM(amount),0)')->whereColumn('student_id', 'students.id'),
            'paid' => Payment::selectRaw('COALESCE(SUM(amount),0)')->whereColumn('student_id', 'students.id'),
        ]);
    }

    public static function nextAdmissionNo(): string
    {
        $year = now()->format('Y');
        $count = static::withTrashed()->where('admission_no', 'like', "HBIC/{$year}/%")->count();

        do {
            $number = sprintf('HBIC/%s/%04d', $year, ++$count);
        } while (static::withTrashed()->where('admission_no', $number)->exists());

        return $number;
    }
}
