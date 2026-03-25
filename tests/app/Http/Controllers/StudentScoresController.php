<?php

namespace App\Http\Controllers;

use App\Models\student_scores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentScoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'online_exam_id' => 'required|exists:online_exams,id',
        'student_id' => 'required|exists:users,id',
        'score' => 'required|numeric|min:0|max:100',
    ]);

    // Get the currently authenticated tutor's ID
    $tutorId = Auth::user()->id;

    // Create a new score record
    $studentScore = new student_scores();
    $studentScore->online_exam_id = $request->input('online_exam_id');
    $studentScore->student_id = $request->input('student_id');
    $studentScore->score = $request->input('score');
    $studentScore->tutor_id = $tutorId;

    $studentScore->save();

    return redirect()->route('tutor.dashboard')->with('success', 'Score saved successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(student_scores $student_scores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(student_scores $student_scores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student_scores $student_scores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student_scores $student_scores)
    {
        //
    }
}
