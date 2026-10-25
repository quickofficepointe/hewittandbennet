<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Payslip;

class PayslipController extends Controller
{
    /** Printable payslip: HR, accounts and directors see all; employees see their own once approved. */
    public function show(Payslip $payslip)
    {
        $payslip->load('run', 'employee.department');
        $user = auth()->user();

        $isOwner = $payslip->employee->user_id === $user->id && $payslip->run->status !== 'draft';
        abort_unless($isOwner || $user->hasRole('hr', 'accountant', 'director'), 403);

        return view('portal.payslip', compact('payslip'));
    }
}
