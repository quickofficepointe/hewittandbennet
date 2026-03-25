<?php

namespace App\Http\Controllers;

use App\Models\registrationform;
use App\Models\hewitt_banners;
use App\Models\courses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegistrationformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
        return view('frontendviews/onlineregistration/index', compact('banners', 'coursese'));
    }

    public function registrationforms()
    {
        $registrationform = registrationform::all(); // Assuming you fetch departments here
        return view('dashboards.staff.registrationforms.index', compact('registrationform'));
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
        // log to start
        Log::info('Registration form submission started.');

        // Inject selected course into validated data before validation
        $request->merge([
            'course_id' => $request->input('selected_course'),
        ]);

        // Validate the input
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'campus_id' => 'required|exists:campuses,id',
            'student_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'citizenship' => 'required|string|max:255',
            'religion' => 'required|string|max:255',
            'cityofresidence' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'emailadress' => 'required|email|max:255',
            'homephone' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'otherskills' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'gurdianname' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:255',
            'idnumber' => 'required|string|max:255',
            'gresidence' => 'required|string|max:255',
            'medical_info_yes' => 'nullable|string|max:255',
            'medical_info_explanation' => 'nullable|string',
            'reasonfortraining' => 'required|string',
            'gainfortraining' => 'required|string|max:255',
            'file_name.*' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
        ]);

        $pdfNames = [];

        if ($request->hasFile('file_name')) {
            foreach ($request->file('file_name') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/application_documents', $filename);
                $pdfNames[] = $filename;
            }
        }

        // Create and save the registration
        $student = new RegistrationForm($validatedData);
        $student->file_name = implode(', ', $pdfNames);
        $student->save();

        return redirect()->route('register')->with('success', 'Registration completed successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(registrationform $registrationform)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(registrationform $registrationform)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, registrationform $registrationform)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(registrationform $registrationform)
    {
        //
    }
}
