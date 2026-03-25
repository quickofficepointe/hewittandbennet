<?php

namespace App\Http\Controllers;

use App\Models\unit;
use Illuminate\Http\Request;
use App\Models\courses;
use App\Models\User;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = courses::all();
        $units = Unit::all();
        $tutors = User::where('role', '3')->get(); // Assuming you have a role field in your users table
        return view ('dashboards.tutor.units.index', compact('courses','units', 'tutors'));
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
            $request->validate([
                'course_id' => 'required',
                'name' => 'required',
                'unit_code' => 'required|unique:units',
                'tutor_id' => 'required',
                'enroll_count'=>'nullable',

            ]);

            $unit = Unit::create([
                'course_id' => $request->course_id,
                'name' => $request->name,
                'unit_code' => $request->unit_code,
                'tutor_id' => $request->tutor_id,
            ]);


            return redirect()->route('index.units')
                ->with('success', 'Unit created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $unit = Unit::findOrFail($id);
    $courses = Courses::all();
    $tutors = User::where('role', '3')->get();
    return view('dashboards.tutor.units.edit', compact('unit', 'courses', 'tutors'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)

    {$request->validate([
        'course_id' => 'required',
        'name' => 'required',
        'unit_code' => 'required|unique:units,unit_code,'.$unit->id,
        'tutor_id' => 'required',
    ]);

    $unit->update([
        'course_id' => $request->course_id,
        'name' => $request->name,
        'unit_code' => $request->unit_code,
        'tutor_id' => $request->tutor_id,
    ]);

    return redirect()->route('index.units')
        ->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(unit $unit)
    {
        $unit->delete();

    return redirect()->route('units.index')
        ->with('success', 'Unit deleted successfully.');
    }
}
