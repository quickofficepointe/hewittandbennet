<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicTerm;
use App\Models\courseapplication;
use App\Models\courses;
use App\Models\registrationform;
use App\Models\Student;
use App\Models\Unit;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => Student::where('status', 'active')->count(),
            'applications' => courseapplication::whereNull('student_id')->where(fn ($q) => $q->whereNull('status')->orWhere('status', 'pending'))->count(),
            'courses' => courses::count(),
            'units' => Unit::count(),
            'unassignedUnits' => Unit::whereNull('trainer_id')->count(),
            'trainers' => User::where('role', User::TRAINER)->where('is_active', true)->count(),
            'registrationForms' => registrationform::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        $recentApplications = courseapplication::with('course', 'campus')->latest()->take(6)->get();
        $recentStudents = Student::with('course')->latest()->take(6)->get();
        $byCourse = courses::withCount(['students' => fn ($q) => $q->where('status', 'active')])
            ->orderByDesc('students_count')->take(8)->get();
        $term = AcademicTerm::current();

        return view('portal.admin.dashboard', compact('stats', 'recentApplications', 'recentStudents', 'byCourse', 'term'));
    }
}
