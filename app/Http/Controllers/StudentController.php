<?php

namespace App\Http\Controllers;

use App\Models\courseapplication;
use App\Models\courses;
use App\Models\student;
use App\Models\student_scores;
use App\Models\student_data;
use App\Models\unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
{
    $userEmail = Auth::user()->email; // Get the authenticated user's email

    $registrations = courseapplication::where('email', $userEmail)->get(); // Fetch registrations for the user's email
    return view('dashboards.student.index', ['registrations' => $registrations]);
}
public function myscores()
{
    $studentId = Auth::user()->id; // Get the currently authenticated student's ID
    $studentdata = student_data::where('id', $studentId)->get();
    if ($studentdata) {
        $myscores = student_scores::where('student_id', $studentId)->get();
        return view('dashboards.student.onlineexams.myscores', compact('studentdata', 'myscores'));
    } else {
        // Handle the case where the student data is not found (e.g., redirect or display an error)
    }
}



    public function courses()
    {
        $courses = courses::all();
        return view('dashboards.student.courses.courses', ['courses' => $courses]);
    }

    public function units($courseId)
    {
        $selectedCourse = courses::findOrFail($courseId);
        $units = unit::where('course_id', $courseId)->get();
        return view('dashboards.student.courses.units', ['selectedCourse' => $selectedCourse, 'units' => $units]);
    }
    public function enroll($unitId)
    {
        $unit = Unit::findOrFail($unitId);

        // Check if the student is already enrolled in the unit
        if (!$unit->students->contains(Auth::user()->id)) {
            // Attach the student to the unit in the pivot table
            $unit->students()->attach(Auth::user()->id);

            // Increment the enroll_count column
            $unit->increment('enroll_count');
        }

        return redirect()->back()->with('success', 'Enrolled successfully!');
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
    public function show(student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student $student)
    {
        //
    }
}
