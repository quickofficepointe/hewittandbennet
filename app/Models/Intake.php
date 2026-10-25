<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date',
        'is_open' => 'boolean',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
