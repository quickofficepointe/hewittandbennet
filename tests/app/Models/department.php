<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class department extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description', 'image'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($department) {
            $department->slug = Str::slug($department->name);
        });

        static::updating(function ($department) {
            $department->slug = Str::slug($department->name);
        });
    }

    public function courses()
    {
        return $this->hasMany(courses::class);
    }
}
