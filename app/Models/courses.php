<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courses extends Model
{
    use HasFactory;
    protected $fillable = ['department_id', 'name', 'school_fees', 'registration_fees', 'duration', 'course_description', 'image', 'school_uniform_fee'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function feesStructure()
    {
        return $this->hasOne(FeesStructure::class);
    }
    public function units()
{
    return $this->hasMany(Unit::class);
}
public function students()
    {
        return $this->hasMany(Student_data::class, 'course_id', 'id');
    }
}
