<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return view('dashboards.staff.courses.deptindex', compact('departments'));
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
            'slug' => 'nullable|string|unique:departments,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Auto-generate slug from name
        $validatedData['slug'] = Str::slug($validatedData['name']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('department_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        Department::create($validatedData);

        return redirect()->back()->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
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
    public function update(Request $request, Department $department)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($department->image) {
                Storage::disk('public')->delete($department->image);
            }

            $imagePath = $request->file('image')->store('department_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $department->update($validatedData);

        return redirect()->back()->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        // Delete associated image if exists
        if ($department->image) {
            Storage::disk('public')->delete($department->image);
        }

        $department->delete();

        return redirect()->back()->with('success', 'Department deleted successfully.');
    }
}