<?php

namespace App\Http\Controllers;

use App\Models\attachment;
use App\Models\hewitt_banners;
use App\Models\courses;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
        return view('frontendviews/careers/attachment/index',compact('banners', 'coursese'));
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
            // Validate the form data
            $request->validate([
                'name'       => 'required|string',
                'institution' => 'required|string',
                'department' => 'required|string',
                'course'     => 'required|string',
                'email'      => 'required|email',
                'document'   => 'required|mimes:pdf|max:2048', // Validate that it's a PDF file (2MB max)
            ]);

            // Upload the combined document and store it in a storage directory
            $documentPath = $request->file('document')->store('public/application_documents');

            // Save the form data and document path to the database
            Attachment::create([
                'name'          => $request->input('name'),
                'institution'   => $request->input('institution'),
                'department'    => $request->input('department'),
                'course'        => $request->input('course'),
                'email'         => $request->input('email'),
                'document_path' => $documentPath,
            ]);

            // Redirect the user or display a success message
            return redirect()->back()->with('success', 'Application submitted successfully.');
        }


    /**
     * Display the specified resource.
     */
    public function show(attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(attachment $attachment)
    {
        //
    }
}
