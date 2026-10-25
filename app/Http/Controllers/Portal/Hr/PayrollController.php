<?php

namespace App\Http\Controllers\Portal\Hr;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PayrollRun;
use App\Models\Payslip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Payroll workflow: HR generates a draft for a month -> Director approves -> Accounts marks it paid.
 */
class PayrollController extends Controller
{
    public function index()
    {
        return view('portal.hr.payroll.index', [
            'runs' => PayrollRun::withCount('payslips')->with('approver')->orderByDesc('period')->get(),
            'activeEmployees' => Employee::where('status', '!=', 'exited')->count(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['period' => 'required|date_format:Y-m|unique:payroll_runs,period']);

        $run = DB::transaction(function () use ($data) {
            $run = PayrollRun::create(['period' => $data['period'], 'status' => 'draft', 'prepared_by' => auth()->id()]);
            $this->generatePayslips($run);

            return $run;
        });

        return redirect()->route('portal.hr.payroll.show', $run)
            ->with('success', "Draft payroll for {$run->period_label} generated for {$run->payslips()->count()} employee(s). Review it, then send it to the Director for approval.");
    }

    public function show(PayrollRun $payrollRun)
    {
        $payrollRun->load(['payslips.employee.department', 'preparer', 'approver', 'payer']);

        return view('portal.payroll-run', ['run' => $payrollRun, 'context' => 'hr']);
    }

    /** Saves "other deductions" (loans, advances) on a draft run, or regenerates it from current salaries. */
    public function update(Request $request, PayrollRun $payrollRun)
    {
        abort_unless($payrollRun->status === 'draft', 422, 'Only draft payrolls can be changed.');

        if ($request->boolean('regenerate')) {
            DB::transaction(function () use ($payrollRun) {
                $payrollRun->payslips()->delete();
                $this->generatePayslips($payrollRun);
            });

            return back()->with('success', 'Payroll regenerated from current employee salaries.');
        }

        $data = $request->validate([
            'other_deductions' => 'array',
            'other_deductions.*' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($payrollRun, $data) {
            foreach ($payrollRun->payslips()->with('employee')->get() as $payslip) {
                $other = (float) ($data['other_deductions'][$payslip->id] ?? $payslip->other_deductions);
                $payslip->update(['other_deductions' => $other, 'net_pay' => round($payslip->gross_pay - $payslip->nssf - $payslip->shif - $payslip->housing_levy - $payslip->paye - $other, 2)]);
            }
            $payrollRun->recalculateTotals();
        });

        return back()->with('success', 'Deductions saved.');
    }

    public function destroy(PayrollRun $payrollRun)
    {
        abort_unless($payrollRun->status === 'draft', 422, 'Approved payrolls cannot be deleted.');
        $payrollRun->delete();

        return redirect()->route('portal.hr.payroll.index')->with('success', 'Draft payroll deleted.');
    }

    private function generatePayslips(PayrollRun $run): void
    {
        Employee::where('status', '!=', 'exited')->where('basic_salary', '>', 0)->get()
            ->each(fn ($employee) => $run->payslips()->create(['employee_id' => $employee->id] + Payslip::figuresFor($employee)));

        $run->recalculateTotals();
    }
}
