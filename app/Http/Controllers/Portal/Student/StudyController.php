<?php

namespace App\Http\Controllers\Portal\Student;

use App\Models\AssessmentResult;
use App\Models\TimetableEntry;
use App\Models\Unit;

class StudyController extends StudentPortalController
{
    public function units()
    {
        $student = $this->student();
        $units = $student->units()->with('trainer')->withCount('materials')->get()->groupBy('term_no');

        return view('portal.student.units', compact('student', 'units'));
    }

    public function unit(Unit $unit)
    {
        $student = $this->student();
        $this->authorizeUnit($student, $unit);
        $unit->load(['trainer', 'timetable', 'materials' => fn ($q) => $q->latest()]);

        $assessments = $unit->assessments()->where('published', true)
            ->with(['results' => fn ($q) => $q->where('student_id', $student->id)])
            ->orderBy('date')->get();
        $mark = $unit->finalMarkFor($student);

        return view('portal.student.unit', [
            'unit' => $unit,
            'assessments' => $assessments,
            'mark' => $mark,
            'grade' => AssessmentResult::grade($mark),
        ]);
    }

    public function timetable()
    {
        $student = $this->student();
        $entries = TimetableEntry::with('unit.course', 'unit.trainer')
            ->whereIn('unit_id', $student->units(true)->pluck('id'))
            ->orderBy('day_of_week')->orderBy('start_time')
            ->get()->groupBy('day_of_week');

        return view('portal.timetable', ['entries' => $entries, 'title' => 'My Class Timetable (Term '.$student->current_term.')']);
    }

    public function attendance()
    {
        $student = $this->student();
        $records = $student->attendances()->with('unit')->orderByDesc('date')->paginate(30);
        $byUnit = $student->attendances()->with('unit')
            ->selectRaw("unit_id, SUM(CASE WHEN status IN ('present','late') THEN 1 ELSE 0 END) as attended, COUNT(*) as total")
            ->groupBy('unit_id')->get();

        return view('portal.student.attendance', compact('student', 'records', 'byUnit'));
    }

    public function results()
    {
        $student = $this->student();

        return view('portal.student.results', ['student' => $student, 'terms' => $this->resultsByTerm($student)]);
    }

    public function transcript()
    {
        $student = $this->student();

        return view('portal.student.transcript', ['student' => $student, 'terms' => $this->resultsByTerm($student)]);
    }

    /** Units grouped by term with each unit's weighted mark, grade and competency. */
    private function resultsByTerm($student)
    {
        return $student->units()->get()->map(function ($unit) use ($student) {
            $mark = $unit->finalMarkFor($student);

            return ['unit' => $unit, 'mark' => $mark, 'grade' => AssessmentResult::grade($mark)];
        })->groupBy(fn ($row) => $row['unit']->term_no);
    }
}
