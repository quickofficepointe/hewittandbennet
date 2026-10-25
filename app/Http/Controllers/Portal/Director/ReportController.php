<?php

namespace App\Http\Controllers\Portal\Director;

use App\Http\Controllers\Controller;
use App\Models\AssessmentResult;
use App\Models\Attendance;
use App\Models\courses;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\LeaveRequest;
use App\Models\Payment;
use App\Models\PayrollRun;
use App\Models\Unit;
use App\Support\FinanceStats;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /** Enrolment, attendance and competency per course. */
    public function academic()
    {
        $courses = courses::with('department')->withCount([
            'students as active_count' => fn ($q) => $q->where('status', 'active'),
            'students as graduated_count' => fn ($q) => $q->where('status', 'graduated'),
            'students as dropped_count' => fn ($q) => $q->whereIn('status', ['discontinued', 'suspended']),
            'units',
        ])->orderBy('name')->get();

        $attendanceByCourse = Attendance::join('students', 'students.id', '=', 'attendances.student_id')
            ->selectRaw("students.course_id, SUM(CASE WHEN attendances.status IN ('present','late') THEN 1 ELSE 0 END) as attended, COUNT(*) as total")
            ->groupBy('students.course_id')->get()->keyBy('course_id');

        // Share of published results (per assessment) at 50% or more, per course.
        $passByCourse = AssessmentResult::join('assessments', 'assessments.id', '=', 'assessment_results.assessment_id')
            ->join('units', 'units.id', '=', 'assessments.unit_id')
            ->where('assessments.published', true)->whereNotNull('assessment_results.score')
            ->selectRaw('units.course_id, SUM(CASE WHEN assessment_results.score / assessments.max_score >= 0.5 THEN 1 ELSE 0 END) as passed, COUNT(*) as total')
            ->groupBy('units.course_id')->get()->keyBy('course_id');

        $trainerLoad = Unit::with('trainer')->whereNotNull('trainer_id')->get()
            ->groupBy('trainer_id')->map(fn ($units) => ['trainer' => $units->first()->trainer, 'units' => $units->count(), 'hours' => $units->sum('hours')])
            ->sortByDesc('units')->values();

        return view('portal.director.reports.academic', compact('courses', 'attendanceByCourse', 'passByCourse', 'trainerLoad'));
    }

    public function finance(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $monthly = FinanceStats::monthly($year);

        return view('portal.director.reports.finance', [
            'year' => $year,
            'monthly' => $monthly,
            'billed' => (float) Invoice::whereYear('invoice_date', $year)->sum('amount'),
            'collected' => array_sum(array_column($monthly, 'income')),
            'expenses' => array_sum(array_column($monthly, 'expenses')),
            'payroll' => array_sum(array_column($monthly, 'payroll')),
            'outstanding' => FinanceStats::outstanding(),
            'topExpenses' => Expense::with('category')->where('status', 'approved')->whereYear('expense_date', $year)->orderByDesc('amount')->take(10)->get(),
            'byMethod' => Payment::whereYear('paid_on', $year)->selectRaw('method, SUM(amount) as total')->groupBy('method')->pluck('total', 'method'),
        ]);
    }

    public function hr()
    {
        $employees = Employee::with('department')->where('status', '!=', 'exited')->get();

        return view('portal.director.reports.hr', [
            'headcount' => $employees->count(),
            'monthlyCost' => $employees->sum(fn ($e) => $e->gross_pay),
            'byDepartment' => $employees->groupBy(fn ($e) => $e->department?->name ?? 'Unassigned')
                ->map(fn ($group) => ['count' => $group->count(), 'cost' => $group->sum(fn ($e) => $e->gross_pay)])->sortByDesc('count'),
            'byType' => $employees->groupBy('employment_type')->map->count(),
            'onLeave' => LeaveRequest::with('employee', 'type')->where('status', 'approved')
                ->whereDate('start_date', '<=', today())->whereDate('end_date', '>=', today())->get(),
            'leaveDaysYear' => (int) LeaveRequest::where('status', 'approved')->whereYear('start_date', now()->year)->sum('days'),
            'payrollRuns' => PayrollRun::orderByDesc('period')->take(12)->get(),
            'recentHires' => Employee::with('department')->orderByDesc('date_hired')->take(5)->get(),
        ]);
    }
}
