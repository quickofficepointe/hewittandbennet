<?php

namespace App\Http\Controllers;

use App\Models\courses;
use App\Models\online_exams;
use Illuminate\Http\Request;

class OnlineExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = courses::all();
        $onlineExams = online_exams::all();
        return view('dashboards.tutor.onlineexams.index',compact('courses','onlineExams'));
    }
    public function start($online_exams_id)
{
    // Check if the user is logged in
    if (!auth()->check()) {
        // Redirect to the login page
        return redirect()->route('login');
    }

    // Find the OnlineExam record by ID
    $exam = online_exams::findOrFail($online_exams_id); // Use the correct model name and namespace

    // Get the questions related to this exam
    $questions = $exam->questions;

    return view('dashboards.student.onlineexams.exams', compact('questions', 'exam'));
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
        // Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'required|string',
        'description' => 'nullable|string',
        'duration' => 'nullable|integer',
        'start_time' => 'nullable|date',
        'end_time' => 'nullable|date|after:start_time',
        'user_id' => 'required|exists:users,id', // Make sure the user exists in your users table
        'course_id' => 'required|exists:courses,id', // Make sure the course exists in your courses table
        'status' => 'required|in:active,inactive,hidden',
    ]);

    // Create a new online exam using the validated data
    $onlineExam = new online_exams();
    $onlineExam->title = $validatedData['title'];
    $onlineExam->description = $validatedData['description'];
    $onlineExam->duration = $validatedData['duration'];
    $onlineExam->start_time = $validatedData['start_time'];
    $onlineExam->end_time = $validatedData['end_time'];
    $onlineExam->user_id = $validatedData['user_id'];
    $onlineExam->course_id = $validatedData['course_id'];
    $onlineExam->status = $validatedData['status'];

    // Save the online exam to the database
    $onlineExam->save();

    // Redirect to a success page or return a response as needed
    return redirect()->route('tutor_exams.index')->with('success', 'Online exam created successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(online_exams $online_exams)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(online_exams $online_exams)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, online_exams $online_exams)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(online_exams $online_exams)
    {
        //
    }
}