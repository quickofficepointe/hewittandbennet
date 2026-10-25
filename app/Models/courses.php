<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class courses extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'department_id', 'name', 'code', 'level', 'examining_body', 'slug', 'school_fees', 'registration_fees',
        'duration', 'total_terms', 'course_description', 'image', 'school_uniform_fee', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

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
        return $this->belongsTo(department::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'course_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'course_id');
    }

    public function feeItems()
    {
        return $this->hasMany(FeeStructureItem::class, 'course_id');
    }

    public function applications()
    {
        return $this->hasMany(courseapplication::class, 'course_id');
    }
}
