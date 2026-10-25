<?php

namespace App\Http\Controllers\Portal\Student;

use App\Models\Announcement;
use App\Models\OnlineExam;
use App\Models\TimetableEntry;

class DashboardController extends StudentPortalController
{
    public function index()
    {
        $student = $this->student();
        $units = $student->units(true)->with('trainer')->get();

        $today = TimetableEntry::with('unit.trainer')
            ->whereIn('unit_id', $units->pluck('id'))
            ->where('day_of_week', now()->dayOfWeekIso)
            ->orderBy('start_time')->get();

        $attendance = $student->attendances()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $attended = ($attendance['present'] ?? 0) + ($attendance['late'] ?? 0);
        $attendanceRate = $attendance->sum() ? round($attended / $attendance->sum() * 100) : null;

        $attemptedIds = $student->examAttempts()->pluck('online_exam_id');
        $openExams = OnlineExam::with('unit')->whereIn('unit_id', $units->pluck('id'))
            ->whereNotIn('id', $attemptedIds)->get()->filter->isOpen();

        return view('portal.student.dashboard', [
            'student' => $student,
            'units' => $units,
            'today' => $today,
            'attendanceRate' => $attendanceRate,
            'balance' => $student->balance,
            'openExams' => $openExams,
            'announcements' => Announcement::visibleTo(auth()->user())->take(4)->get(),
        ]);
    }
}
