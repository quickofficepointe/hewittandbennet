<?php

namespace App\Http\Controllers;

use App\Models\courseregistration;
use Illuminate\Http\Request;

class CourseregistrationController extends Controller
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
            'modeOfLearning' => 'required', // Validate the modeOfLearning field
        ]);

        $courseRegistration = new courseregistration();
        $courseRegistration->name = $request->input('name');
        $courseRegistration->email = $request->input('email');
        $courseRegistration->location = $request->input('location');
        $courseRegistration->phoneNumber = $request->input('phoneNumber');
        $courseRegistration->course = $request->input('course');
        $courseRegistration->startMonth = $request->input('startMonth');
        $courseRegistration->startYear = $request->input('startYear');
        $courseRegistration->modeOfLearning = $request->input('modeOfLearning'); // Store mode of learning
        $courseRegistration->save();

        return redirect()->back()->with('success', 'Registration successful!');
    }


    /**
     * Display the specified resource.
     */
    public function show(courseregistration $courseregistration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(courseregistration $courseregistration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, courseregistration $courseregistration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(courseregistration $courseregistration)
    {
        //
    }
}
