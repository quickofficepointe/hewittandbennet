<?php

namespace App\Http\Controllers\Portal\Trainer;

use App\Models\ExamQuestion;
use App\Models\OnlineExam;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Auto-marked multiple-choice online exams. */
class ExamController extends TrainerController
{
    public function index()
    {
        $units = Unit::where('trainer_id', auth()->id())->orderBy('code')->get();
        $exams = OnlineExam::with('unit')->withCount(['questions', 'attempts'])
            ->whereIn('unit_id', $units->pluck('id'))
            ->latest()->get();

        return view('portal.trainer.exams.index', compact('units', 'exams'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => ['required', Rule::exists('units', 'id')->where('trainer_id', auth()->id())],
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5|max:300',
            'opens_at' => 'nullable|date',
            'closes_at' => 'nullable|date|after:opens_at',
        ]);

        $exam = OnlineExam::create($data + ['created_by' => auth()->id(), 'published' => false]);

        return redirect()->route('portal.trainer.exams.show', $exam)->with('success', 'Exam created. Add questions, then publish it.');
    }

    public function show(OnlineExam $exam)
    {
        $this->authorizeUnit($exam->unit);
        $exam->load(['unit.course', 'questions', 'attempts' => fn ($q) => $q->with('student')->latest()]);

        return view('portal.trainer.exams.show', compact('exam'));
    }

    public function publish(OnlineExam $exam)
    {
        $this->authorizeUnit($exam->unit);

        if (! $exam->published && ! $exam->questions()->exists()) {
            return back()->with('error', 'Add at least one question before publishing.');
        }
        $exam->update(['published' => ! $exam->published]);

        return back()->with('success', $exam->published ? 'Exam published to students.' : 'Exam unpublished.');
    }

    public function destroy(OnlineExam $exam)
    {
        $this->authorizeUnit($exam->unit);
        $exam->delete();

        return redirect()->route('portal.trainer.exams.index')->with('success', 'Exam deleted.');
    }

    public function storeQuestion(Request $request, OnlineExam $exam)
    {
        $this->authorizeUnit($exam->unit);

        if ($exam->attempts()->exists()) {
            return back()->with('error', 'Students have already attempted this exam; questions can no longer change.');
        }

        $data = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2|max:6',
            'options.*' => 'nullable|string|max:500',
            'correct_option' => 'required|integer|min:0',
            'marks' => 'required|integer|min:1|max:20',
        ]);

        // Drop blank options but remember where the correct answer moved to.
        $options = [];
        $correct = null;
        foreach ($data['options'] as $index => $text) {
            if (trim((string) $text) === '') {
                continue;
            }
            if ((int) $index === (int) $data['correct_option']) {
                $correct = count($options);
            }
            $options[] = trim($text);
        }

        if (count($options) < 2 || $correct === null) {
            return back()->withInput()->withErrors(['options' => 'Provide at least two options and mark a non-empty one as correct.']);
        }

        $exam->questions()->create([
            'question' => $data['question'],
            'options' => $options,
            'correct_option' => $correct,
            'marks' => $data['marks'],
        ]);

        return back()->with('success', 'Question added.');
    }

    public function destroyQuestion(ExamQuestion $question)
    {
        $this->authorizeUnit($question->exam->unit);

        if ($question->exam->attempts()->exists()) {
            return back()->with('error', 'Students have already attempted this exam; questions can no longer change.');
        }
        $question->delete();

        return back()->with('success', 'Question removed.');
    }
}
