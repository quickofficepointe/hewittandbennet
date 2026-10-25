<?php

namespace App\Http\Controllers\Portal\Hr;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\JobApplication;
use App\Models\LeaveRequest;
use App\Models\PayrollRun;

class DashboardController extends Controller
{
    public function index()
    {
        $active = Employee::where('status', '!=', 'exited');

        $stats = [
            'employees' => (clone $active)->count(),
            'onLeaveToday' => LeaveRequest::where('status', 'approved')
                ->whereDate('start_date', '<=', today())->whereDate('end_date', '>=', today())->count(),
            'pendingLeave' => LeaveRequest::where('status', 'pending')->count(),
            'newApplications' => JobApplication::where('status', 'new')->count(),
            'monthlyPayroll' => (float) (clone $active)->selectRaw('SUM(basic_salary + house_allowance + other_allowances) as total')->value('total'),
        ];

        $byDepartment = Employee::with('department')->where('status', '!=', 'exited')->get()
            ->groupBy(fn ($e) => $e->department?->name ?? 'Unassigned')->map->count()->sortDesc();
        $byType = (clone $active)->selectRaw('employment_type, count(*) as total')->groupBy('employment_type')->pluck('total', 'employment_type');

        $pending = LeaveRequest::with('employee', 'type')->where('status', 'pending')->oldest()->take(6)->get();
        $latestRun = PayrollRun::latest('period')->first();
        $noLogin = Employee::whereNull('user_id')->where('status', '!=', 'exited')->count();

        return view('portal.hr.dashboard', compact('stats', 'byDepartment', 'byType', 'pending', 'latestRun', 'noLogin'));
    }
}
