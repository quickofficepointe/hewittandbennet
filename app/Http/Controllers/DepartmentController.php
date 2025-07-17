<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        Department::create($validatedData);

         return redirect()->back()->with('success', 'Department created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
{
    return view('dashboards.staff.courses.edit.deptedit', compact('department'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, department $department)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $department->update($validatedData);

        return redirect()->back()->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(department $department)
{
    $department->delete();

    return redirect()->back()->with('success', 'Department deleted successfully.');
}


}
