<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public const METHODS = ['cash' => 'Cash', 'mpesa' => 'M-Pesa', 'bank' => 'Bank Deposit', 'cheque' => 'Cheque', 'card' => 'Card'];

    protected $guarded = ['id'];

    protected $casts = ['paid_on' => 'date'];

    public function student()
    {
        return $this->belongsTo(Student::class)->withTrashed();
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public static function nextReceiptNo(): string
    {
        return sprintf('RCT-%s-%05d', now()->format('Y'), (static::max('id') ?? 0) + 1);
    }
}
