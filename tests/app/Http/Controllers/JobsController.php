<?php

namespace App\Http\Controllers;

use App\Models\hewitt_banners;
use App\Models\courses;
use App\Models\jobs;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
        return view('frontendviews/careers/jobs/index',compact('banners', 'coursese'));
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
        $documentPath = $request->file('document')->store('public/jobapplication_documents');

        // Save the form data and document path to the database
        jobs::create([
            'name'          => $request->input('name'),
            'institution'   => $request->input('institution'),
            'department'    => $request->input('department'),
            'course'        => $request->input('course'),
            'email'         => $request->input('email'),
            'document_path' => $documentPath,
        ]);

        // Redirect the user or display a success message
        return redirect()->route('register')->with('success', 'Application submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(jobs $jobs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jobs $jobs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, jobs $jobs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jobs $jobs)
    {
        //
    }
}
