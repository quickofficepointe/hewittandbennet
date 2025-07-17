<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'name', 'unit_code','tutor_id', 'enroll_count'];

    // Define the relationship between Unit and Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function tutor()
{
    return $this->belongsTo(User::class, 'tutor_id');
}
public function students()
{
    return $this->belongsToMany(User::class, 'unit_student', 'unit_id', 'student_id');
}

}
