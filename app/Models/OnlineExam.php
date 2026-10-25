<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineExam extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'opens_at' => 'datetime',
        'closes_at' => 'datetime',
        'published' => 'boolean',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function isOpen(): bool
    {
        return $this->published
            && (! $this->opens_at || $this->opens_at->isPast())
            && (! $this->closes_at || $this->closes_at->isFuture());
    }
}
