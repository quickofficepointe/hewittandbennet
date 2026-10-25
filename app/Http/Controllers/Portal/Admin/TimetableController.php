<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\courses;
use App\Models\TimetableEntry;
use App\Models\Unit;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $courseId = $request->input('course_id');

        $entries = TimetableEntry::with('unit.course', 'unit.trainer')
            ->when($courseId, fn ($q) => $q->whereHas('unit', fn ($q) => $q->where('course_id', $courseId)))
            ->orderBy('day_of_week')->orderBy('start_time')
            ->get()->groupBy('day_of_week');

        $units = Unit::with('course')->when($courseId, fn ($q) => $q->where('course_id', $courseId))
            ->orderBy('code')->get()
            ->mapWithKeys(fn ($u) => [$u->id => "{$u->code} - {$u->name} ({$u->course?->name}, Term {$u->term_no})"]);

        return view('portal.admin.timetable', [
            'entries' => $entries,
            'units' => $units,
            'courses' => courses::orderBy('name')->pluck('name', 'id'),
            'courseId' => $courseId,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'day_of_week' => 'required|integer|between:1,7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'venue' => 'nullable|string|max:100',
        ]);

        $unit = Unit::findOrFail($data['unit_id']);

        // Prevent double-booking the trainer or the venue.
        $clash = TimetableEntry::with('unit')
            ->where('day_of_week', $data['day_of_week'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->where(function ($q) use ($data, $unit) {
                $q->whereRaw('1 = 0');
                if (! empty($data['venue'])) {
                    $q->orWhere('venue', $data['venue']);
                }
                if ($unit->trainer_id) {
                    $q->orWhereHas('unit', fn ($q) => $q->where('trainer_id', $unit->trainer_id));
                }
            })
            ->first();

        if ($clash) {
            return back()->withInput()->with('error', "Clash with {$clash->unit->code} ({$clash->day_name} ".substr($clash->start_time, 0, 5).'-'.substr($clash->end_time, 0, 5).') - same trainer or venue.');
        }

        TimetableEntry::create($data);

        return back()->with('success', 'Lesson added to the timetable.');
    }

    public function destroy(TimetableEntry $entry)
    {
        $entry->delete();

        return back()->with('success', 'Lesson removed.');
    }
}
