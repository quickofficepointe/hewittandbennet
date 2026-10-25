<?php

namespace App\Http\Controllers\Portal\Trainer;

use App\Models\Attendance;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AttendanceController extends TrainerController
{
    public function edit(Request $request, Unit $unit)
    {
        $this->authorizeUnit($unit);
        $date = Carbon::parse($request->input('date', today()->toDateString()));

        $students = $unit->students()->get();
        $existing = $unit->attendances()->whereDate('date', $date)->pluck('status', 'student_id');
        $recentDates = $unit->attendances()->select('date')->distinct()->orderByDesc('date')->take(10)->pluck('date');

        return view('portal.trainer.attendance', compact('unit', 'date', 'students', 'existing', 'recentDates'));
    }

    public function store(Request $request, Unit $unit)
    {
        $this->authorizeUnit($unit);

        $data = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'status' => 'required|array',
            'status.*' => ['required', Rule::in(Attendance::STATUSES)],
        ]);

        $studentIds = $unit->students()->pluck('id')->all();

        DB::transaction(function () use ($data, $unit, $studentIds) {
            foreach ($data['status'] as $studentId => $status) {
                if (! in_array((int) $studentId, $studentIds, true)) {
                    continue;
                }
                Attendance::updateOrCreate(
                    ['unit_id' => $unit->id, 'student_id' => $studentId, 'date' => $data['date']],
                    ['status' => $status, 'marked_by' => auth()->id()]
                );
            }
        });

        return redirect()->route('portal.trainer.units.attendance', [$unit, 'date' => $data['date']])
            ->with('success', 'Attendance saved for '.Carbon::parse($data['date'])->format('d M Y').'.');
    }
}
