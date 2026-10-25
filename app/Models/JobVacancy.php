<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'closing_date' => 'date',
        'is_open' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(department::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('is_open', true)
            ->where(fn ($q) => $q->whereNull('closing_date')->orWhereDate('closing_date', '>=', today()));
    }
}
