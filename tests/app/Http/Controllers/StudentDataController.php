<?php

namespace App\Http\Controllers;

use App\Models\student_data;
use App\Models\courses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
class StudentDataController extends Controller
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
        $students = student_data::all();
        $coursese = courses::all(); // Rename $coursese to $courses
    return view('dashboards.staff.student_data.index',[
            'coursese' => $coursese,
            'students' => $students
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'student_no'=>'required',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:student_datas',
            'id_number' => 'required|string|max:255|unique:student_datas',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone_number' => 'required|string|max:20',
            'guardian_email' => 'required|string|email|max:255',
            'passport_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size and allowed extensions as needed
            'course' => 'required|string|max:255',
            'course_fee' => 'required|numeric|min:0',
        ];

        $request->validate($rules);

        // Store the passport photo
        $passportPhotoPath = $request->file('passport_photo')->store('passport-photos', 'public');

        // Create a new student record
        $student = new student_data([
            'name' => $request->input('name'),
            'student_no' => $request->input('student_no'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'id_number' => $request->input('id_number'),
            'guardian_name' => $request->input('guardian_name'),
            'guardian_phone_number' => $request->input('guardian_phone_number'),
            'guardian_email' => $request->input('guardian_email'),
            'passport_photo' => $passportPhotoPath,
            'course' => $request->input('course'),
            'course_fee' => $request->input('course_fee'),
            'fee_balance' => $request->input('course_fee'), // Set fee_balance to course_fee initially
        ]);

        $student->save();
        Mail::to($student->email)->send(new WelcomeEmail($student));

        return redirect()->back()->with('success', 'Student record created successfully');

    }
    /**
     * Display the specified resource.
     */
    public function show(student_data $student_data)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the student data by ID
        $student_data = student_data::findOrFail($id);

        // Fetch the list of available courses (assuming you have a courses table)
        $courses = courses::all();

        return view('dashboards.staff.student_data.edit.edit', compact('student_data', 'courses'));

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student_data $student_data)
{
    $validatedData = $request->validate([
        'name' => 'required|string',
        'student_no' => 'required|string|unique:student_datas,student_no,' . $student_data->id,
        'phone_number' => 'required|string',
        'email' => 'required|string|email|unique:student_datas,email,' . $student_data->id,
        'id_number' => 'required|string|unique:student_datas,id_number,' . $student_data->id,
        'guardian_name' => 'required|string',
        'guardian_phone_number' => 'required|string',
        'guardian_email' => 'required|string|email',
        'course' => 'required|string',
        'course_fee' => 'required|numeric',
        'passport_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        // Add validation for the passport photo if needed
    ]);

    // Update student data
    $student_data->update($validatedData);

    // Handle passport photo upload
    if ($request->hasFile('passport_photo')) {
        $imagePath = $request->file('passport_photo')->store('passport-photos', 'public');

        // Update the student's passport_photo attribute with the new image path
        $student_data->passport_photo = $imagePath;
        $student_data->save();
    }

    return redirect()->route('students.index')->with('success', 'Student updated successfully.');
}





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student_data $student_data)
    {
        //
    }
}
