<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PayrollRun extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function preparer()
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function getPeriodLabelAttribute(): string
    {
        return Carbon::createFromFormat('Y-m-d', $this->period.'-01')->format('F Y');
    }

    public function recalculateTotals(): void
    {
        $gross = (float) $this->payslips()->sum('gross_pay');
        $net = (float) $this->payslips()->sum('net_pay');

        $this->update([
            'total_gross' => $gross,
            'total_net' => $net,
            'total_deductions' => $gross - $net,
        ]);
    }
}
