<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

/** Public careers page: open vacancies (managed by HR) and the application form. */
class JobsController extends Controller
{
    public function index()
    {
        $vacancies = JobVacancy::with('department')->open()->latest()->get();

        return view('frontendviews/careers/jobs/index', compact('vacancies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'job_vacancy_id' => 'nullable|exists:job_vacancies,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'position' => 'nullable|string|max:255',
            'cover_letter' => 'nullable|string|max:5000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if (! empty($data['job_vacancy_id']) && ! JobVacancy::open()->whereKey($data['job_vacancy_id'])->exists()) {
            return back()->withInput()->withErrors(['job_vacancy_id' => 'This vacancy is no longer accepting applications.']);
        }

        // Stored on the private disk; HR downloads CVs through the portal.
        $data['cv_path'] = $request->file('cv')->store('job-applications');
        unset($data['cv']);

        JobApplication::create($data + ['status' => 'new']);

        return redirect()->route('index.jobs')->with('success', 'Thank you! Your application has been received. Our HR team will contact shortlisted candidates.');
    }
}
