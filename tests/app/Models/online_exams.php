<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class online_exams extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'duration',
        'start_time',
        'end_time',
        'user_id',
        'status',
        'course_id',
    ];
    protected $casts = [
        'start_time' => 'datetime', // Cast the start_time attribute to a datetime
        'end_time' => 'datetime', // You can also cast the end_time if it's not already a datetime
    ];
    // Define the relationship with the User model (assuming the User model exists)


    public function questions()
    {
        return $this->hasMany(questions::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Course model (assuming the Course model exists)
    public function course()
    {
        return $this->belongsTo(courses::class);
    }

}
