<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    public const STATUSES = ['new', 'shortlisted', 'interviewed', 'hired', 'rejected'];

    protected $guarded = ['id'];

    public function vacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
}
