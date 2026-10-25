<?php

namespace App\Http\Controllers\Portal\Hr;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = JobApplication::with('vacancy')
            ->when($request->filled('vacancy_id'), fn ($q) => $q->where('job_vacancy_id', $request->vacancy_id))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(25)->withQueryString();

        return view('portal.hr.applications', [
            'applications' => $applications,
            'vacancies' => JobVacancy::orderByDesc('created_at')->pluck('title', 'id'),
        ]);
    }

    public function update(Request $request, JobApplication $application)
    {
        $request->validate(['status' => ['required', Rule::in(JobApplication::STATUSES)]]);
        $application->update(['status' => $request->status]);

        return back()->with('success', "Application marked as {$request->status}.");
    }

    public function cv(JobApplication $application)
    {
        abort_unless(Storage::exists($application->cv_path), 404, 'CV file not found.');

        return Storage::download($application->cv_path, str($application->name)->slug().'-cv.'.pathinfo($application->cv_path, PATHINFO_EXTENSION));
    }
}
