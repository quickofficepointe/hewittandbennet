<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_data extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'phone_number', 'email', 'id_number', 'guardian_name', 'guardian_phone_number',
        'guardian_email', 'passport_photo', 'course', 'student_no', 'course_fee'
    ];

    public function PaymentReceipts()
    {
        return $this->hasMany(PaymentReceipt::class, 'student_no', 'student_no'); // Update the foreign key reference
    }

    public function course()
    {
        return $this->belongsTo(courses::class, 'course_id', 'id');
    }

    public function feesStatement()
    {
        return $this->hasOne(fees_statement::class, 'student_no', 'student_no'); // Add the relationship to fees_statement
    }
}
