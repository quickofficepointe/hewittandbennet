<?php

namespace App\Http\Controllers\Portal\Trainer;

use App\Models\AcademicTerm;
use App\Models\Assessment;
use App\Models\AssessmentResult;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AssessmentController extends TrainerController
{
    public function store(Request $request, Unit $unit)
    {
        $this->authorizeUnit($unit);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::in(array_keys(Assessment::TYPES))],
            'max_score' => 'required|numeric|min:1|max:1000',
            'weight' => 'required|integer|min:1|max:100',
            'date' => 'nullable|date',
        ]);

        $assessment = $unit->assessments()->create($data + [
            'academic_term_id' => AcademicTerm::current()?->id,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('portal.trainer.units.assessments.show', $assessment)->with('success', 'Assessment created. Enter the marks below.');
    }

    public function show(Assessment $assessment)
    {
        $this->authorizeUnit($assessment->unit);
        $assessment->load('unit.course');

        $students = $assessment->unit->students()->get();
        $results = $assessment->results()->get()->keyBy('student_id');

        return view('portal.trainer.assessment', compact('assessment', 'students', 'results'));
    }

    public function marks(Request $request, Assessment $assessment)
    {
        $this->authorizeUnit($assessment->unit);

        $data = $request->validate([
            'scores' => 'array',
            'scores.*' => 'nullable|numeric|min:0|max:'.$assessment->max_score,
            'remarks' => 'array',
            'remarks.*' => 'nullable|string|max:255',
        ]);

        $studentIds = $assessment->unit->students()->pluck('id')->all();

        DB::transaction(function () use ($data, $assessment, $studentIds) {
            foreach ($data['scores'] ?? [] as $studentId => $score) {
                if (! in_array((int) $studentId, $studentIds, true)) {
                    continue;
                }
                AssessmentResult::updateOrCreate(
                    ['assessment_id' => $assessment->id, 'student_id' => $studentId],
                    ['score' => $score, 'remarks' => $data['remarks'][$studentId] ?? null]
                );
            }
        });

        if ($request->boolean('publish')) {
            $assessment->update(['published' => true]);
        }

        return back()->with('success', $request->boolean('publish') ? 'Marks saved and published to students.' : 'Marks saved.');
    }

    public function publish(Assessment $assessment)
    {
        $this->authorizeUnit($assessment->unit);
        $assessment->update(['published' => ! $assessment->published]);

        return back()->with('success', $assessment->published ? 'Results published to students.' : 'Results hidden from students.');
    }

    public function destroy(Assessment $assessment)
    {
        $this->authorizeUnit($assessment->unit);
        $unit = $assessment->unit;
        $assessment->delete();

        return redirect()->route('portal.trainer.units.show', $unit)->with('success', 'Assessment deleted.');
    }
}
