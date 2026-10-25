<?php

namespace App\Http\Controllers\Portal\Hr;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveTypeController extends Controller
{
    public function index()
    {
        return view('portal.hr.leave-types', ['types' => LeaveType::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        LeaveType::create($this->validated($request));

        return back()->with('success', 'Leave type added.');
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $leaveType->update($this->validated($request, $leaveType));

        return back()->with('success', 'Leave type updated.');
    }

    public function destroy(LeaveType $leaveType)
    {
        if (LeaveRequest::where('leave_type_id', $leaveType->id)->exists()) {
            return back()->with('error', 'This leave type has been used and cannot be deleted.');
        }
        $leaveType->delete();

        return back()->with('success', 'Leave type deleted.');
    }

    private function validated(Request $request, ?LeaveType $type = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('leave_types')->ignore($type?->id)],
            'days_per_year' => 'required|integer|min:0|max:365',
        ]) + ['is_paid' => $request->boolean('is_paid')];
    }
}
