<?php

namespace App\Http\Controllers;
use App\Mail\CourseRegistrationMail;
use App\Models\Campus;
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
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'location' => 'required|string|max:255',
        'phoneNumber' => 'required|string|max:20',
        'course_id' => 'required|exists:courses,id',
        'campus_id' => 'required|exists:campuses,id',
        'startMonth' => 'required|string|max:20',
        'startYear' => 'required|string|max:4',
        'modeOfLearning' => 'required|string|max:50',
    ]);

    // Get course and campus details
    $course = courses::findOrFail($request->course_id);
    $campus = Campus::findOrFail($request->campus_id);

    $courseRegistration = Courseapplication::create([
        'name' => $request->name,
        'email' => $request->email,
        'location' => $request->location,
        'phoneNumber' => $request->phoneNumber,
        'course_id' => $request->course_id,
        'campus_id' => $request->campus_id,
        'startMonth' => $request->startMonth,
        'startYear' => $request->startYear,
        'modeOfLearning' => $request->modeOfLearning,
        'status' => 'pending'
    ]);

    // Send email to admin
    Mail::raw("
        New Course Application Received:

        Name: {$request->name}
        Email: {$request->email}
        Phone: {$request->phoneNumber}
        Course: {$course->name}
        Campus: {$campus->name}
        Start Date: {$request->startMonth} {$request->startYear}
        Mode of Learning: {$request->modeOfLearning}
        Location: {$request->location}
    ", function ($message) {
        $message->to('hewittbennet@gmail.com')
                ->subject('New Course Application Submission');
    });

    // Send confirmation email to applicant
    Mail::raw("
        Dear {$request->name},

        Thank you for applying to {$course->name} at Hewitt And Bennet International College.
        We have received your application and will process it shortly.

        Application Details:
        - Course: {$course->name}
        - Campus: {$campus->name}
        - Start Date: {$request->startMonth} {$request->startYear}
        - Mode of Learning: {$request->modeOfLearning}

        If you have any questions, please contact us at hewittbennet@gmail.com or call +254 740 197 796.

        Best regards,
        Hewitt And Bennet International College
    ", function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Your Course Application Confirmation');
    });

    return response()->json([
        'success' => true,
        'message' => 'Registration successful! A confirmation has been sent to your email.'
    ]);
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
