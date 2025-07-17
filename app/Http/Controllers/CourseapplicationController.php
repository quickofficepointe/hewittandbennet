<?php

namespace App\Http\Controllers;
use App\Mail\CourseRegistrationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\courseapplication;
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
    $courseRegistration->course = $request->input('course');
    $courseRegistration->startMonth = $request->input('startMonth');
    $courseRegistration->startYear = $request->input('startYear');
    $courseRegistration->modeOfLearning = $request->input('modeOfLearning');
    $courseRegistration->save();

    // Send email to admin
    Mail::to('hewittbennet@gmail.com')->send(new CourseRegistrationMail(
        $request->input('name'),
        $request->input('phoneNumber'),
        $request->input('course'),
        $request->input('startMonth')
    ));

    return redirect()->route('registration.create')->with('success', 'Registration successful!');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(courseapplication $courseapplication)
    {
        //
    }
}