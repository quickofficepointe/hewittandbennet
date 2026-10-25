<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tiktokvid extends Model
{
    use HasFactory;

    protected $table = 'tik_tok_vids';

    protected $fillable = ['video_url'];
}
