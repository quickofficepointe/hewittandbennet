<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fees_statement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_no', // Add any other relevant fields for fee statements
        'course_fee',
        'paid_amount',
        'remaining_amount',
        'payment_date',
    ];

    public function student()
    {
        return $this->belongsTo(student_data::class, 'student_no', 'student_no');
    }

    public function PaymentReceipts()
    {
        return $this->hasMany(PaymentReceipt::class, 'student_no', 'student_no');
    }
}
