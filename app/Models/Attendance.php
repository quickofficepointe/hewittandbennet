<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public const STATUSES = ['present', 'absent', 'late', 'excused'];

    protected $guarded = ['id'];

    protected $casts = ['date' => 'date'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
