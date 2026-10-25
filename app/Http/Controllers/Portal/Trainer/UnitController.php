<?php

namespace App\Http\Controllers\Portal\Trainer;

use App\Models\Assessment;
use App\Models\Unit;

class UnitController extends TrainerController
{
    public function index()
    {
        $units = Unit::with('course')->withCount(['assessments', 'materials', 'exams'])
            ->where('trainer_id', auth()->id())
            ->orderBy('course_id')->orderBy('term_no')->get();
        $units->each(fn ($unit) => $unit->setAttribute('students_count', $unit->students()->count()));

        return view('portal.trainer.units.index', compact('units'));
    }

    public function show(Unit $unit)
    {
        $this->authorizeUnit($unit);
        $unit->load(['course', 'timetable', 'materials' => fn ($q) => $q->latest(), 'assessments' => fn ($q) => $q->withCount('results')->latest()]);

        $students = $unit->students()->get();
        $attendanceRates = $unit->attendances()
            ->selectRaw("student_id, SUM(CASE WHEN status IN ('present','late') THEN 1 ELSE 0 END) as attended, COUNT(*) as total")
            ->groupBy('student_id')->get()->keyBy('student_id');
        $marks = $students->mapWithKeys(fn ($s) => [$s->id => $unit->finalMarkFor($s)]);

        return view('portal.trainer.units.show', [
            'unit' => $unit,
            'students' => $students,
            'attendanceRates' => $attendanceRates,
            'marks' => $marks,
            'types' => Assessment::TYPES,
        ]);
    }
}
