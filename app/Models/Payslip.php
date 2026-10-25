<?php

namespace App\Models;

use App\Support\KenyaPayroll;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $guarded = ['id'];

    public function run()
    {
        return $this->belongsTo(PayrollRun::class, 'payroll_run_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }

    public function getTotalDeductionsAttribute(): float
    {
        return (float) $this->nssf + (float) $this->shif + (float) $this->housing_levy + (float) $this->paye + (float) $this->other_deductions;
    }

    /** Payslip figures for an employee using the statutory rates in KenyaPayroll. */
    public static function figuresFor(Employee $employee, float $otherDeductions = 0): array
    {
        $gross = $employee->gross_pay;
        $deductions = KenyaPayroll::calculate($gross);

        return [
            'basic_salary' => (float) $employee->basic_salary,
            'house_allowance' => (float) $employee->house_allowance,
            'other_allowances' => (float) $employee->other_allowances,
            'gross_pay' => $gross,
            'nssf' => $deductions['nssf'],
            'shif' => $deductions['shif'],
            'housing_levy' => $deductions['housing_levy'],
            'paye' => $deductions['paye'],
            'other_deductions' => $otherDeductions,
            'net_pay' => round($gross - $deductions['total'] - $otherDeductions, 2),
        ];
    }
}
