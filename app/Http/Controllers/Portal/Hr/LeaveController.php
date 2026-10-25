<?php

namespace App\Http\Controllers\Portal\Hr;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        $requests = LeaveRequest::with('employee.department', 'type', 'reviewer')
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(25)->withQueryString();

        return view('portal.hr.leave', compact('requests', 'status'));
    }

    public function decide(Request $request, LeaveRequest $leaveRequest)
    {
        $data = $request->validate([
            'decision' => 'required|in:approved,rejected',
            'review_notes' => 'nullable|string|max:255',
        ]);

        abort_unless($leaveRequest->status === 'pending', 422, 'This request has already been reviewed.');
        abort_if($leaveRequest->employee?->user_id === auth()->id(), 403, 'You cannot approve your own leave.');

        $leaveRequest->update([
            'status' => $data['decision'],
            'review_notes' => $data['review_notes'] ?? null,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Leave request '.$data['decision'].'.');
    }
}
