<?php

namespace App\Http\Controllers;

use App\Models\registrationform;
use App\Models\hewitt_banners;
use App\Models\courses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class RegistrationformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
        return view('frontendviews/onlineregistration/index',compact('banners', 'coursese'));
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
        $validatedData = $request->validate([
            'student_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'citizenship' => 'required|string|max:255',
            'religion' => 'required|string|max:255',
            'cityofresidence' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'emailadress' => 'required|email|max:255', // Fix the field name here
            'homephone' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'otherskills' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'gurdianname' => 'required|string|max:255', // Fix the field name here
            'phonenumber' => 'required|string|max:255',
            'idnumber' => 'required|string|max:255',
            'gresidence' => 'required|string|max:255',
            'medical_info_yes' => 'nullable|string|max:255',
            'medical_info_explanation' => 'nullable|string',
            'reasonfortraining' => 'required|string',
            'gainfortraining' => 'required|string|max:255',
            'file_name.*' => 'required|mimes:pdf|max:2048', // Adjust this rule to match your file types and size limits
        ]);

        if ($request->hasFile("file_name")) {
            $pdfNames = []; // Initialize an array to store file names

            foreach ($request->file("file_name") as $file) {
                // Generate a unique file name
                $file_name = time() . '_' . $file->getClientOriginalName();

                // Store the file in the temporary directory and move it to the desired location
                $file->storeAs('temp', $file_name); // Store in the 'temp' directory

                // Move the file to your desired storage location
                Storage::move("temp/$file_name", "public/application_documents/$file_name");

                // Collect the file name
                $pdfNames[] = $file_name;
            }

            // Debugging: Check if $pdfNames contains the correct values
         

            // Store the PDF information in your database
            // Assuming you have a 'pdf_path' column in your database table
            $student = new RegistrationForm($validatedData);

            // Convert the array of file names to a comma-separated string
            $student->file_name = implode(', ', $pdfNames);

            $student->save();
        }






        // Redirect to a thank you page or display a success message
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
