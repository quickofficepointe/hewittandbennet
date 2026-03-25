<?php

namespace App\Http\Controllers;

use App\Mail\CourseRegistrationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\courseapplication;
use App\Models\courses;
use Illuminate\Http\Request;

class CourseapplicationController extends Controller
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'location' => 'required',
            'phoneNumber' => 'required',
            'course' => 'required',
            'startMonth' => 'required',
            'startYear' => 'required',
            'modeOfLearning' => 'required',
        ]);

        $courseRegistration = new courseapplication();
        $courseRegistration->name = $request->input('name');
        $courseRegistration->email = $request->input('email');
        $courseRegistration->location = $request->input('location');
        $courseRegistration->phoneNumber = $request->input('phoneNumber');

        // Get course name from ID
        $courseModel = courses::find($request->input('course'));
        $courseName = $courseModel ? $courseModel->name : $request->input('course');
        $courseRegistration->course = $courseName;

        $courseRegistration->startMonth = $request->input('startMonth');
        $courseRegistration->startYear = $request->input('startYear');
        $courseRegistration->modeOfLearning = $request->input('modeOfLearning');
        $courseRegistration->save();

        // Send email to admin with course name
        Mail::to('hewittbennet@gmail.com')->send(new CourseRegistrationMail(
            $request->input('name'),
            $request->input('phoneNumber'),
            $courseName,
            $request->input('startMonth')
        ));

        return redirect()->back()->with('success', 'Registration successful!');
    }

    /**
     * Display the specified resource.
     */
    public function show(courseapplication $courseapplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(courseapplication $courseapplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, courseapplication $courseapplication)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'location' => 'required',
            'phoneNumber' => 'required',
            'course' => 'required',
            'startMonth' => 'required',
            'startYear' => 'required',
            'modeOfLearning' => 'required',
        ]);

        $courseModel = courses::find($request->input('course'));
        $courseName = $courseModel ? $courseModel->name : $request->input('course');

        $courseapplication->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'location' => $request->input('location'),
            'phoneNumber' => $request->input('phoneNumber'),
            'course' => $courseName,
            'startMonth' => $request->input('startMonth'),
            'startYear' => $request->input('startYear'),
            'modeOfLearning' => $request->input('modeOfLearning'),
        ]);

        return redirect()->route('dashboards.staff.studentregistration.index', $courseapplication->id)->with('success', 'Application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(courseapplication $courseapplication)
    {
        $courseapplication->delete();
        return redirect()->back()->with('success', 'Student Application deleted successfully.');
    }
}
