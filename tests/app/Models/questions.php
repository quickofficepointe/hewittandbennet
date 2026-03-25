<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class questions extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'online_exams_id', // Add other fields as needed
        'text',
    ];

    // Define the relationship with the OnlineExam model (assuming the OnlineExam model exists)

    // Question.php (Model)
// Question.php (Model)
public function onlineExam()
{
    return $this->belongsTo(online_exams::class, 'online_exams_id');
}



}
