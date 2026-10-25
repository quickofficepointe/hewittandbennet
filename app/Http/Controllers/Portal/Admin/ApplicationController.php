<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\courseapplication;
use Illuminate\Http\Request;

/** Online course applications submitted from the public website. */
class ApplicationController extends Controller
{
    public const STATUSES = ['pending', 'contacted', 'admitted', 'rejected'];

    public function index(Request $request)
    {
        $applications = courseapplication::with('course', 'campus', 'student')
            ->when($request->filled('status'), function ($q) use ($request) {
                $request->status === 'pending'
                    ? $q->where(fn ($q) => $q->whereNull('status')->orWhere('status', 'pending'))
                    : $q->where('status', $request->status);
            })
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($q) => $q
                ->where('name', 'like', "%{$request->q}%")
                ->orWhere('email', 'like', "%{$request->q}%")
                ->orWhere('phoneNumber', 'like', "%{$request->q}%")))
            ->latest()
            ->paginate(25)->withQueryString();

        return view('portal.admin.applications', ['applications' => $applications, 'statuses' => self::STATUSES]);
    }

    public function update(Request $request, courseapplication $application)
    {
        $request->validate(['status' => 'required|in:'.implode(',', self::STATUSES)]);
        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application marked as '.$request->status.'.');
    }
}
