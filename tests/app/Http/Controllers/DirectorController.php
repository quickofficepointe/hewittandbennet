<?php

namespace App\Http\Controllers;

use App\Models\courseapplication;

use App\Models\director;
use Illuminate\Http\Request;
use App\Models\User;
class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
{
    $courseapplications= courseapplication::all();
    $staffCount = User::where('role', 1)->count();
    $studentCount = User::where('role', 2)->count();
    $tutorCount = User::where('role', 3)->count();
    $registeredStudentCount = courseapplication::distinct('email')->count('email');

    return view('dashboards.Director.index',compact('courseapplications','staffCount', 'studentCount', 'tutorCount', 'registeredStudentCount'));
}

    public function index()
    {
        //
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
    public function show(director $director)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(director $director)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, director $director)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(director $director)
    {
        //
    }
}
