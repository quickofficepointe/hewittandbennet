<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }

    public function type()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /** Working days (Monday to Saturday) between two dates, inclusive. */
    public static function workingDays($start, $end): int
    {
        $days = 0;
        foreach (CarbonPeriod::create($start, $end) as $date) {
            if (! $date->isSunday()) {
                $days++;
            }
        }

        return $days;
    }
}
