<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Campus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'city', 'country',
        'phone', 'email', 'banner_image', 'is_main', 'active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($campus) {
            $campus->slug = Str::slug($campus->name);
        });
    }
}
