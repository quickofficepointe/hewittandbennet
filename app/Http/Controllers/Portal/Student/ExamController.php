<?php

namespace App\Http\Controllers\Portal\Student;

use App\Models\ExamAttempt;
use App\Models\OnlineExam;
use Illuminate\Http\Request;

class ExamController extends StudentPortalController
{
    public function index()
    {
        $student = $this->student();
        $unitIds = $student->units()->pluck('id');

        $exams = OnlineExam::with('unit')->withCount('questions')
            ->whereIn('unit_id', $unitIds)->where('published', true)
            ->latest()->get();
        $attempts = $student->examAttempts()->get()->keyBy('online_exam_id');

        return view('portal.student.exams.index', compact('exams', 'attempts'));
    }

    /** Starts (or resumes) the attempt. The timer runs from the first time the exam is opened. */
    public function take(OnlineExam $exam)
    {
        $student = $this->student();
        $this->authorizeUnit($student, $exam->unit);

        $attempt = ExamAttempt::where('online_exam_id', $exam->id)->where('student_id', $student->id)->first();

        if ($attempt?->submitted_at) {
            return view('portal.student.exams.result', ['exam' => $exam->load('questions', 'unit'), 'attempt' => $attempt]);
        }
        if (! $exam->isOpen()) {
            return redirect()->route('portal.student.exams.index')->with('error', 'This exam is not open right now.');
        }

        $attempt ??= ExamAttempt::create([
            'online_exam_id' => $exam->id,
            'student_id' => $student->id,
            'started_at' => now(),
        ]);

        $deadline = $attempt->started_at->copy()->addMinutes($exam->duration_minutes);
        if ($exam->closes_at && $exam->closes_at->lt($deadline)) {
            $deadline = $exam->closes_at;
        }

        return view('portal.student.exams.take', [
            'exam' => $exam->load('questions', 'unit'),
            'attempt' => $attempt,
            'secondsLeft' => max(0, now()->diffInSeconds($deadline, false)),
        ]);
    }

    public function submit(Request $request, OnlineExam $exam)
    {
        $student = $this->student();
        $attempt = ExamAttempt::where('online_exam_id', $exam->id)->where('student_id', $student->id)->firstOrFail();

        if ($attempt->submitted_at) {
            return redirect()->route('portal.student.exams.take', $exam);
        }

        $answers = collect($request->input('answers', []))->map(fn ($v) => (int) $v)->all();
        $score = 0;
        $total = 0;
        foreach ($exam->questions as $question) {
            $total += $question->marks;
            if (array_key_exists($question->id, $answers) && $answers[$question->id] === $question->correct_option) {
                $score += $question->marks;
            }
        }

        $attempt->update([
            'answers' => $answers,
            'score' => $score,
            'total' => $total,
            'submitted_at' => now(),
        ]);

        // The page auto-submits when time runs out; allow one minute of grace for slow connections.
        $late = now()->gt($attempt->started_at->copy()->addMinutes($exam->duration_minutes + 1));
        $message = "Exam submitted. You scored {$score} out of {$total}.".($late ? ' Note: it was submitted after the time limit.' : '');

        return redirect()->route('portal.student.exams.take', $exam)->with('success', $message);
    }
}
