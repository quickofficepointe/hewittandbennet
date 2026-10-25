<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    public const TYPES = ['permanent' => 'Permanent', 'contract' => 'Contract', 'part_time' => 'Part time', 'intern' => 'Intern'];
    public const STATUSES = ['active', 'on_leave', 'suspended', 'exited'];

    protected $guarded = ['id'];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_hired' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(department::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getGrossPayAttribute(): float
    {
        return (float) $this->basic_salary + (float) $this->house_allowance + (float) $this->other_allowances;
    }

    public function leaveDaysTaken(int $leaveTypeId, ?int $year = null): int
    {
        return (int) $this->leaveRequests()
            ->where('leave_type_id', $leaveTypeId)
            ->where('status', 'approved')
            ->whereYear('start_date', $year ?? now()->year)
            ->sum('days');
    }

    public static function nextEmployeeNo(): string
    {
        $count = static::withTrashed()->count();

        do {
            $number = sprintf('HBIC-EMP-%04d', ++$count);
        } while (static::withTrashed()->where('employee_no', $number)->exists());

        return $number;
    }
}
