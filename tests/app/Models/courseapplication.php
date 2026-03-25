<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseapplication extends Model
{
    use HasFactory;
    protected $fillable = [
    'name',
    'email',
    'location',
    'phoneNumber',
    'course',
    'startMonth',
    'startYear',
    'modeOfLearning', ];
}
