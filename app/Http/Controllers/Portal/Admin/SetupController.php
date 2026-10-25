<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicTerm;
use App\Models\courses;
use App\Models\Intake;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Academic calendar: terms, intakes and end-of-term promotion. */
class SetupController extends Controller
{
    public function index()
    {
        return view('portal.admin.setup', [
            'terms' => AcademicTerm::orderByDesc('start_date')->get(),
            'intakes' => Intake::withCount('students')->orderByDesc('start_date')->get(),
            'courses' => courses::orderBy('name')->get(),
        ]);
    }

    public function storeTerm(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        DB::transaction(function () use ($data, $request) {
            if ($request->boolean('is_current')) {
                AcademicTerm::query()->update(['is_current' => false]);
            }
            AcademicTerm::create($data + ['is_current' => $request->boolean('is_current')]);
        });

        return back()->with('success', 'Term added.');
    }

    public function makeCurrent(AcademicTerm $term)
    {
        DB::transaction(function () use ($term) {
            AcademicTerm::query()->update(['is_current' => false]);
            $term->update(['is_current' => true]);
        });

        return back()->with('success', "{$term->name} is now the current term.");
    }

    public function destroyTerm(AcademicTerm $term)
    {
        $term->delete();

        return back()->with('success', 'Term deleted.');
    }

    public function storeIntake(Request $request)
    {
        Intake::create($request->validate([
            'name' => 'required|string|max:100|unique:intakes,name',
            'start_date' => 'required|date',
        ]) + ['is_open' => true]);

        return back()->with('success', 'Intake added.');
    }

    public function toggleIntake(Intake $intake)
    {
        $intake->update(['is_open' => ! $intake->is_open]);

        return back()->with('success', 'Intake '.($intake->is_open ? 'opened' : 'closed').'.');
    }

    public function destroyIntake(Intake $intake)
    {
        if ($intake->students()->exists()) {
            return back()->with('error', 'This intake has students and cannot be deleted. Close it instead.');
        }
        $intake->delete();

        return back()->with('success', 'Intake deleted.');
    }

    /**
     * Moves active students of a course (optionally one intake) to the next term.
     * Students already in the course's final term are marked as graduated.
     */
    public function promote(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'intake_id' => 'nullable|exists:intakes,id',
        ]);

        $course = courses::findOrFail($data['course_id']);
        $students = Student::where('course_id', $course->id)->where('status', 'active')
            ->when($data['intake_id'] ?? null, fn ($q, $id) => $q->where('intake_id', $id));

        $graduated = (clone $students)->where('current_term', '>=', $course->total_terms)->update(['status' => 'graduated']);
        $promoted = (clone $students)->where('current_term', '<', $course->total_terms)->increment('current_term');

        return back()->with('success', "{$promoted} student(s) promoted to the next term, {$graduated} graduated.");
    }
}
