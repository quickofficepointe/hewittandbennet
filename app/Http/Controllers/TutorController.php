<?php

namespace App\Http\Controllers;

use App\Models\online_exams;
use App\Models\student_exams;
use App\Models\student_responses;
use App\Models\tutor;
use App\Models\User;
use Illuminate\Http\Request;

class TutorController extends Controller
{

public function viewExamResults()
{
    $studentResponses = student_responses::with('question')->get();

    return view('dashboards.tutor.onlineexams.student_responses', compact('studentResponses'));
}

public function StudentScores()
{

    // Fetch the list of student exams and students (customize these queries as needed)
    $studentExams = online_exams::all();
    $students = user::where('role', '2')->get();

    return view('dashboards.tutor.onlineexams.student_score', compact('studentExams', 'students'));
}


    /**
     * Display a listing of the resource.
     */
    public function dashboard()
{
    return view('dashboards.tutor.index');
}
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(tutor $tutor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tutor $tutor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, tutor $tutor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tutor $tutor)
    {
        //
    }
}
