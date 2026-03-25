<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    use HasFactory;
    protected $table = 'courseregistrations';
    protected $fillable = [
        'name',
        'email',
        'location',
        'phoneNumber',
        'course',
        'startMonth',
        'startYear',
        'modeOfLearning', // Include the new field here
    ];
}
