<?php

namespace App\Http\Controllers;

use App\Models\student_exams;
use Illuminate\Http\Request;

class StudentExamsController extends Controller
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
        'online_exam_id' => 'required|exists:online_exams,id',
        // You can add more validation rules as needed
    ]);

    // Create a new student exam record
    $studentExam = student_exams::create([
        'user_id' => $validatedData['user_id'],
        'online_exam_id' => $validatedData['online_exam_id'],
        'status' => 'in_progress', // Set the initial status to 'in_progress'
    ]);

    // You can customize the response or redirect as needed
    return redirect()->route('exams.start', ['exam' => $studentExam->online_exam_id])
    ->with('success', 'Student exam created successfully');

}
    /**
     * Display the specified resource.
     */
    public function show(student_exams $student_exams)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(student_exams $student_exams)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student_exams $student_exams)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student_exams $student_exams)
    {
        //
    }
}
