<?php

namespace App\Http\Controllers;

use App\Models\staff;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\newsandevent;
use App\Models\paymentreceipt;
use App\Models\registrationform;
use App\Models\courseapplication;
class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        // Get the number of students registered this month
        $registrationsThisMonth = CourseApplication::whereMonth('created_at', now()->month)
                                                    ->whereYear('created_at', now()->year)
                                                    ->count();

        // Get the number of students registered last month
        $registrationsLastMonth = CourseApplication::whereMonth('created_at', now()->subMonth()->month)
                                                    ->whereYear('created_at', now()->year)
                                                    ->count();

        // Get the number of students registered this month last year
        $registrationsLastYear = CourseApplication::whereMonth('created_at', now()->month)
                                                   ->whereYear('created_at', now()->subYear()->year)
                                                   ->count();

        // Get the total number of students registered in the current year
        $registrationsThisYear = CourseApplication::whereYear('created_at', now()->year)->count();

        // Get the number of news and events added
        $newsEventsCount = newsandevent::count(); // Assuming you have a NewsAndEvent model

        // Get the total number of registered users
        $totalRegisteredUsers = User::count(); // Assuming users are the registered individuals

        // Get the number of receipts generated
        $receiptsGenerated = paymentreceipt::count(); // Assuming you have a Receipt model

        // Get the number of online registration forms
        $onlineRegistrationForms = registrationform::count(); // Assuming you have a RegistrationForm model

        // Get the total number of online registrations
        $totalOnlineRegistrations = CourseApplication::where('modeOfLearning', 'online')->count();

        // Define month labels for the chart (e.g., ["January", "February", ...])
        $months = [
            now()->subMonth()->format('F'),
            now()->format('F'),
        ];

        // Pass the data to the view
        return view('dashboards.staff.index', compact(
            'registrationsThisMonth',
            'registrationsLastMonth',
            'registrationsLastYear',
            'registrationsThisYear',
            'newsEventsCount',
            'totalRegisteredUsers',
            'receiptsGenerated',
            'onlineRegistrationForms',
            'totalOnlineRegistrations',
            'months'
        ));
    }


    public function index()
    {
        $courseapplications = CourseApplication::orderBy('created_at', 'desc')->get();
        $months = [
            now()->subMonth()->format('F'),
            now()->format('F'),
        ];
         // Get the number of students registered this month
         $registrationsThisMonth = CourseApplication::whereMonth('created_at', now()->month)
         ->whereYear('created_at', now()->year)
         ->count();

// Get the number of students registered last month
$registrationsLastMonth = CourseApplication::whereMonth('created_at', now()->subMonth()->month)
         ->whereYear('created_at', now()->year)
         ->count();

// Get the number of students registered this month last year
$registrationsLastYear = CourseApplication::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->subYear()->year)
        ->count();

// Get the total number of students registered in the current year
$registrationsThisYear = CourseApplication::whereYear('created_at', now()->year)->count();
        // Only pass the variables needed for this view
        return view('dashboards.staff.studentregistration.index', compact('courseapplications', 'months','registrationsThisMonth',
            'registrationsLastMonth',
            'registrationsLastYear',
            'registrationsThisYear', ));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(staff $staff)
    {
        //
    }
}