<?php

namespace App\Http\Controllers\Portal\Trainer;

use App\Models\Announcement;
use App\Models\Assessment;
use App\Models\TimetableEntry;
use App\Models\Unit;

class DashboardController extends TrainerController
{
    public function index()
    {
        $user = auth()->user();
        $units = Unit::with('course')->where('trainer_id', $user->id)->orderBy('code')->get();
        $units->each(fn ($unit) => $unit->setAttribute('students_count', $unit->students()->count()));

        $today = TimetableEntry::with('unit.course')
            ->whereIn('unit_id', $units->pluck('id'))
            ->where('day_of_week', now()->dayOfWeekIso)
            ->orderBy('start_time')->get();

        $unpublished = Assessment::with('unit')->whereIn('unit_id', $units->pluck('id'))
            ->where('published', false)->latest()->take(5)->get();

        $attendanceToday = \App\Models\Attendance::whereIn('unit_id', $units->pluck('id'))
            ->whereDate('date', today())->distinct('unit_id')->count('unit_id');

        $announcements = Announcement::visibleTo($user)->take(3)->get();

        return view('portal.trainer.dashboard', compact('units', 'today', 'unpublished', 'attendanceToday', 'announcements'));
    }

    public function timetable()
    {
        $entries = TimetableEntry::with('unit.course', 'unit.trainer')
            ->whereHas('unit', fn ($q) => $q->where('trainer_id', auth()->id()))
            ->orderBy('day_of_week')->orderBy('start_time')
            ->get()->groupBy('day_of_week');

        return view('portal.timetable', ['entries' => $entries, 'title' => 'My Teaching Timetable']);
    }
}
