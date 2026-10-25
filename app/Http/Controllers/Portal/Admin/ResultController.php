<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentResult;
use App\Models\courses;
use App\Models\Unit;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $units = Unit::with('course', 'trainer')
            ->withCount(['assessments', 'assessments as published_count' => fn ($q) => $q->where('published', true)])
            ->when($request->filled('course_id'), fn ($q) => $q->where('course_id', $request->course_id))
            ->orderBy('course_id')->orderBy('term_no')->orderBy('code')
            ->paginate(30)->withQueryString();

        return view('portal.admin.results.index', [
            'units' => $units,
            'courses' => courses::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    /** Broadsheet of every student's weighted mark and competency for one unit. */
    public function show(Unit $unit)
    {
        $unit->load('course', 'trainer', 'assessments');
        $rows = $unit->students()->get()->map(function ($student) use ($unit) {
            $mark = $unit->finalMarkFor($student);

            return ['student' => $student, 'mark' => $mark, 'grade' => AssessmentResult::grade($mark)];
        });

        return view('portal.admin.results.show', compact('unit', 'rows'));
    }
}
