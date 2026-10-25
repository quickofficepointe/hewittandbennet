<?php

namespace App\Http\Controllers\Portal\Director;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\PayrollRun;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function expenses(Request $request)
    {
        $status = $request->input('status', 'pending');

        return view('portal.director.expenses', [
            'status' => $status,
            'expenses' => Expense::with('category', 'recorder', 'approver')
                ->when($status !== 'all', fn ($q) => $q->where('status', $status))
                ->latest('expense_date')->paginate(30)->withQueryString(),
            'pendingTotal' => (float) Expense::where('status', 'pending')->sum('amount'),
        ]);
    }

    public function decideExpense(Request $request, Expense $expense)
    {
        $request->validate(['decision' => 'required|in:approved,rejected']);
        abort_unless($expense->status === 'pending', 422, 'This expense has already been reviewed.');

        $expense->update([
            'status' => $request->decision,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Expense '.$request->decision.'.');
    }

    public function payroll(Request $request)
    {
        if ($request->filled('run')) {
            $run = PayrollRun::with(['payslips.employee.department', 'preparer', 'approver', 'payer'])->findOrFail($request->run);

            return view('portal.payroll-run', ['run' => $run, 'context' => 'director']);
        }

        return view('portal.director.payroll', [
            'runs' => PayrollRun::withCount('payslips')->with('preparer', 'approver')->orderByDesc('period')->get(),
        ]);
    }

    public function approvePayroll(PayrollRun $payrollRun)
    {
        abort_unless($payrollRun->status === 'draft', 422, 'This payroll is not awaiting approval.');
        $payrollRun->update(['status' => 'approved', 'approved_by' => auth()->id(), 'approved_at' => now()]);

        return redirect()->route('portal.director.payroll')->with('success', "Payroll for {$payrollRun->period_label} approved. Accounts can now pay salaries.");
    }
}
