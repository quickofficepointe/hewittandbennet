<?php

namespace App\Support;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PayrollRun;

/** Figures shared by the accounts dashboard, financial reports and the director's dashboard. */
class FinanceStats
{
    /** Total owed by students who still have a positive balance (credits are not netted off). */
    public static function outstanding(): float
    {
        $billed = Invoice::selectRaw('student_id, SUM(amount) as total')->groupBy('student_id')->pluck('total', 'student_id');
        $paid = Payment::selectRaw('student_id, SUM(amount) as total')->groupBy('student_id')->pluck('total', 'student_id');

        return (float) $billed->map(fn ($total, $studentId) => max(0, $total - ($paid[$studentId] ?? 0)))->sum();
    }

    /**
     * Month-by-month income, expenses (approved) and paid payroll for a year.
     *
     * @return array<int, array{month: string, income: float, expenses: float, payroll: float}>
     */
    public static function monthly(int $year): array
    {
        $income = Payment::whereYear('paid_on', $year)->get(['paid_on', 'amount'])
            ->groupBy(fn ($p) => (int) $p->paid_on->format('n'))->map->sum('amount');
        $expenses = Expense::where('status', 'approved')->whereYear('expense_date', $year)->get(['expense_date', 'amount'])
            ->groupBy(fn ($e) => (int) $e->expense_date->format('n'))->map->sum('amount');
        $payroll = PayrollRun::where('status', 'paid')->where('period', 'like', "{$year}-%")->get(['period', 'total_net'])
            ->groupBy(fn ($r) => (int) substr($r->period, 5, 2))->map->sum('total_net');

        return collect(range(1, 12))->map(fn ($m) => [
            'month' => date('M', mktime(0, 0, 0, $m, 1)),
            'income' => (float) ($income[$m] ?? 0),
            'expenses' => (float) ($expenses[$m] ?? 0),
            'payroll' => (float) ($payroll[$m] ?? 0),
        ])->all();
    }
}
