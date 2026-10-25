<?php

namespace App\Http\Controllers\Portal\Accounts;

use App\Http\Controllers\Controller;
use App\Models\courses;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Payment;
use App\Support\FinanceStats;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $monthly = FinanceStats::monthly($year);

        $byCategory = Expense::with('category')->where('status', 'approved')->whereYear('expense_date', $year)
            ->get()->groupBy(fn ($e) => $e->category?->name ?? 'Uncategorised')->map->sum('amount')->sortDesc();

        $byMethod = Payment::whereYear('paid_on', $year)->selectRaw('method, SUM(amount) as total')
            ->groupBy('method')->pluck('total', 'method');

        // Billed vs collected per course for the year.
        $billed = Invoice::whereYear('invoice_date', $year)->join('students', 'students.id', '=', 'invoices.student_id')
            ->selectRaw('students.course_id, SUM(invoices.amount) as total')->groupBy('students.course_id')->pluck('total', 'course_id');
        $collected = Payment::whereYear('paid_on', $year)->join('students', 'students.id', '=', 'payments.student_id')
            ->selectRaw('students.course_id, SUM(payments.amount) as total')->groupBy('students.course_id')->pluck('total', 'course_id');
        $byCourse = courses::orderBy('name')->get()->map(fn ($c) => [
            'course' => $c->name,
            'billed' => (float) ($billed[$c->id] ?? 0),
            'collected' => (float) ($collected[$c->id] ?? 0),
        ])->filter(fn ($row) => $row['billed'] || $row['collected'])->values();

        return view('portal.accounts.reports', [
            'year' => $year,
            'monthly' => $monthly,
            'byCategory' => $byCategory,
            'byMethod' => $byMethod,
            'byCourse' => $byCourse,
            'totals' => [
                'income' => array_sum(array_column($monthly, 'income')),
                'expenses' => array_sum(array_column($monthly, 'expenses')),
                'payroll' => array_sum(array_column($monthly, 'payroll')),
            ],
        ]);
    }
}
