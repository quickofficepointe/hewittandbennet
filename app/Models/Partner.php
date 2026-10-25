<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model  // Changed to PascalCase
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'description',
    ];
}
