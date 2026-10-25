<?php

namespace App\Http\Controllers\Portal\Director;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\courseapplication;
use App\Models\courses;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\LeaveRequest;
use App\Models\Payment;
use App\Models\PayrollRun;
use App\Models\Student;
use App\Models\Unit;
use App\Support\FinanceStats;

/** Executive overview of the whole college. */
class DashboardController extends Controller
{
    public function index()
    {
        $year = now()->year;
        $collected = (float) Payment::whereYear('paid_on', $year)->sum('amount');
        $billed = (float) Invoice::whereYear('invoice_date', $year)->sum('amount');

        $attendance = Attendance::where('date', '>=', now()->subDays(30))
            ->selectRaw("SUM(CASE WHEN status IN ('present','late') THEN 1 ELSE 0 END) as attended, COUNT(*) as total")->first();

        $kpis = [
            'students' => Student::where('status', 'active')->count(),
            'newThisYear' => Student::whereYear('admission_date', $year)->count(),
            'staff' => Employee::where('status', '!=', 'exited')->count(),
            'collectedYear' => $collected,
            'collectionRate' => $billed > 0 ? round($collected / $billed * 100) : null,
            'outstanding' => FinanceStats::outstanding(),
            'collectedMonth' => (float) Payment::whereYear('paid_on', $year)->whereMonth('paid_on', now()->month)->sum('amount'),
            'attendanceRate' => $attendance?->total ? round($attendance->attended / $attendance->total * 100) : null,
            'pendingApplications' => courseapplication::whereNull('student_id')->where(fn ($q) => $q->whereNull('status')->orWhere('status', 'pending'))->count(),
            'unassignedUnits' => Unit::whereNull('trainer_id')->count(),
        ];

        $approvals = [
            'expenses' => Expense::where('status', 'pending')->count(),
            'expensesValue' => (float) Expense::where('status', 'pending')->sum('amount'),
            'payroll' => PayrollRun::where('status', 'draft')->withCount('payslips')->get(),
            'leave' => LeaveRequest::where('status', 'pending')->count(),
        ];

        $enrolment = courses::withCount(['students' => fn ($q) => $q->where('status', 'active')])
            ->orderByDesc('students_count')->get()->filter(fn ($c) => $c->students_count > 0)->values();

        $statusMix = Student::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        // Admissions per month for the last 12 months.
        $admissions = collect(range(11, 0))->map(function ($ago) {
            $month = now()->startOfMonth()->subMonths($ago);

            return [
                'label' => $month->format('M y'),
                'total' => Student::whereYear('admission_date', $month->year)->whereMonth('admission_date', $month->month)->count(),
            ];
        });

        return view('portal.director.dashboard', [
            'kpis' => $kpis,
            'approvals' => $approvals,
            'enrolment' => $enrolment,
            'statusMix' => $statusMix,
            'admissions' => $admissions,
            'monthly' => FinanceStats::monthly($year),
            'recentPayments' => Payment::with('student')->latest()->take(5)->get(),
        ]);
    }
}
