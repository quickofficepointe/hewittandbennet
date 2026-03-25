<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class courses extends Model
{
    use HasFactory;
    protected $fillable = ['department_id', 'name', 'slug', 'school_fees', 'registration_fees', 'duration', 'course_description', 'image', 'school_uniform_fee'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $course->slug = Str::slug($course->name);
        });

        static::updating(function ($course) {
            $course->slug = Str::slug($course->name);
        });
    }

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
    public function applications()
{
    return $this->hasMany(Courseapplication::class);
}
}