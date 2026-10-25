<?php

namespace App\Http\Controllers\Portal\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PayrollRun;
use App\Support\FinanceStats;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'today' => (float) Payment::whereDate('paid_on', today())->sum('amount'),
            'month' => (float) Payment::whereYear('paid_on', now()->year)->whereMonth('paid_on', now()->month)->sum('amount'),
            'outstanding' => FinanceStats::outstanding(),
            'expensesMonth' => (float) Expense::where('status', 'approved')->whereYear('expense_date', now()->year)->whereMonth('expense_date', now()->month)->sum('amount'),
            'pendingExpenses' => Expense::where('status', 'pending')->count(),
            'billedYear' => (float) Invoice::whereYear('invoice_date', now()->year)->sum('amount'),
            'collectedYear' => (float) Payment::whereYear('paid_on', now()->year)->sum('amount'),
        ];

        return view('portal.accounts.dashboard', [
            'stats' => $stats,
            'recentPayments' => Payment::with('student')->latest()->take(8)->get(),
            'byMethod' => Payment::whereYear('paid_on', now()->year)->whereMonth('paid_on', now()->month)
                ->selectRaw('method, SUM(amount) as total')->groupBy('method')->pluck('total', 'method'),
            'monthly' => FinanceStats::monthly(now()->year),
            'payrollToPay' => PayrollRun::where('status', 'approved')->get(),
        ]);
    }
}
