<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Payslip;
use Illuminate\Http\Request;

/** Employee self-service: leave applications and payslips. */
class MyHrController extends Controller
{
    public function leave()
    {
        $employee = auth()->user()->employee;
        $types = LeaveType::orderBy('name')->get();

        $balances = $employee ? $types->map(fn ($type) => [
            'type' => $type,
            'taken' => $taken = $employee->leaveDaysTaken($type->id),
            'remaining' => max(0, $type->days_per_year - $taken),
        ]) : collect();

        $requests = $employee ? $employee->leaveRequests()->with('type', 'reviewer')->latest()->get() : collect();

        return view('portal.my.leave', compact('employee', 'types', 'balances', 'requests'));
    }

    public function applyLeave(Request $request)
    {
        $employee = $request->user()->employee;
        abort_unless($employee, 403, 'You do not have an employee record yet. Please contact HR.');

        $data = $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:1000',
        ]);

        $type = LeaveType::findOrFail($data['leave_type_id']);
        $days = LeaveRequest::workingDays($data['start_date'], $data['end_date']);
        $remaining = $type->days_per_year - $employee->leaveDaysTaken($type->id);

        if ($days < 1) {
            return back()->withInput()->withErrors(['end_date' => 'The selected dates contain no working days.']);
        }
        if ($days > $remaining) {
            return back()->withInput()->withErrors(['end_date' => "You only have {$remaining} day(s) of {$type->name} left this year."]);
        }

        $employee->leaveRequests()->create($data + ['days' => $days, 'status' => 'pending']);

        return back()->with('success', "Leave application for {$days} day(s) submitted to HR.");
    }

    public function cancelLeave(LeaveRequest $leaveRequest)
    {
        abort_unless($leaveRequest->employee?->user_id === auth()->id(), 403);
        abort_unless($leaveRequest->status === 'pending', 422, 'Only pending requests can be cancelled.');

        $leaveRequest->update(['status' => 'cancelled']);

        return back()->with('success', 'Leave request cancelled.');
    }

    public function payslips()
    {
        $employee = auth()->user()->employee;

        $payslips = $employee
            ? Payslip::with('run')->where('employee_id', $employee->id)
                ->whereHas('run', fn ($q) => $q->whereIn('status', ['approved', 'paid']))
                ->latest()->get()
            : collect();

        return view('portal.my.payslips', compact('employee', 'payslips'));
    }
}
