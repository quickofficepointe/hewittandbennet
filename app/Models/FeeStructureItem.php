<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructureItem extends Model
{
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(courses::class, 'course_id');
    }
}
