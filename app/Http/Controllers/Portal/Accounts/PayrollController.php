<?php

namespace App\Http\Controllers\Portal\Accounts;

use App\Http\Controllers\Controller;
use App\Models\PayrollRun;

class PayrollController extends Controller
{
    public function index()
    {
        return view('portal.accounts.payroll', [
            'runs' => PayrollRun::withCount('payslips')->whereIn('status', ['approved', 'paid'])->orderByDesc('period')->get(),
        ]);
    }

    public function show(PayrollRun $payrollRun)
    {
        abort_if($payrollRun->status === 'draft', 403, 'This payroll has not been approved yet.');
        $payrollRun->load(['payslips.employee.department', 'preparer', 'approver', 'payer']);

        return view('portal.payroll-run', ['run' => $payrollRun, 'context' => 'accounts']);
    }

    public function markPaid(PayrollRun $payrollRun)
    {
        abort_unless($payrollRun->status === 'approved', 422, 'Only approved payrolls can be marked as paid.');
        $payrollRun->update(['status' => 'paid', 'paid_by' => auth()->id(), 'paid_at' => now()]);

        return back()->with('success', "{$payrollRun->period_label} salaries marked as paid.");
    }
}
