<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Courseapplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'location',
        'phoneNumber',
        'course_id',
        'campus_id',
        'startMonth',
        'startYear',
        'modeOfLearning',
        'status'
    ];

    /**
     * Get the course associated with the application.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(courses::class);
    }

    /**
     * Get the campus associated with the application.
     */
    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }
}
