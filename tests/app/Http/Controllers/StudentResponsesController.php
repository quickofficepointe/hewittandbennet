<?php

namespace App\Http\Controllers;

use App\Models\student_responses;
use Illuminate\Http\Request;

class StudentResponsesController extends Controller
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
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'question_id' => 'required|array',
        'question_id.*' => 'required|exists:questions,id',
        'answers' => 'required|array',
        'answers.*' => 'required|string',
    ]);

    $userId = $validatedData['user_id'];
    $questionIds = $validatedData['question_id'];
    $answers = $validatedData['answers'];

    // Check if the number of elements in both arrays match
    if (count($questionIds) !== count($answers)) {
        return redirect()->back()->withErrors(['Mismatched array lengths.']);
    }

    // Loop through the submitted answers and associate each response with 'question_id'
    foreach ($questionIds as $questionId) {
        if (array_key_exists($questionId, $answers)) {
            $responseText = $answers[$questionId];

            student_responses::create([
                'user_id' => $userId,
                'question_id' => $questionId,
                'answers' => $responseText,
            ]);
        }
    }

    return redirect()->route('exams_all.index')->with('success', 'Exam submitted successfully');
}



    /**
     * Display the specified resource.
     */
    public function show(student_responses $student_responses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(student_responses $student_responses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student_responses $student_responses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student_responses $student_responses)
    {
        //
    }
}
