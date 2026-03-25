<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentreceipt extends Model
{
    protected $fillable = ['Name', 'user_id', 'contact', 'Amount', 'ReceiptNo', 'paymentfor', 'student_no', 'modeofpayment', 'served_by'];

    public function servedBy()
    {
        return $this->belongsTo(User::class, 'served_by');
    }
    public function feesStatement()
    {
        return $this->belongsTo(fees_statement::class, 'student_no', 'student_no'); // Relationship to the fees_statement model
    }
    public function student()
    {
        return $this->belongsTo(student_data::class, 'student_no', 'student_no'); // Update the foreign key reference
    }

}
