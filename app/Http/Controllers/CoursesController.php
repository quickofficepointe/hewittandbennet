<?php

namespace App\Http\Controllers;

use App\Models\courses;
use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\hewitt_banners;
class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function medicalsciences() {
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all(); // Rename $coursese to $courses
        $othercourses = department::where('name', 'like', '%other courses%')->pluck('id');
        $othercourses = courses::whereIn('department_id', $othercourses)->get();

        return view('frontendviews.medicalsciences.index', [
            'othercourses' => $othercourses,
            'coursese' => $coursese,
            'banners' => $banners
        ]);
    }

    public function fees(){
        $courses = courses::all();
        $coursese = courses::all();
        $banners = hewitt_banners::where('status', true)->get();

        return view('frontendviews.feesstructure.index', compact('courses', 'coursese', 'banners'));
    }

    public function shortcourses() {
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
        $shortDepartments = department::where('name', 'like', '%caregiver%')->pluck('id');
        $shortCourses = courses::whereIn('department_id', $shortDepartments)->get();

        return view('frontendviews.shortcourses.index', compact('shortCourses', 'coursese', 'banners'));
    }
public function nursing() {
    $banners = hewitt_banners::where('status', true)->get();
    $coursese = courses::all();
    $nursingDepartments = department::where('name', 'like', '%nursing%')->pluck('id');
    $nursingCourses = courses::whereIn('department_id', $nursingDepartments)->get();

    return view('frontendviews.nursing.index', compact('nursingCourses', 'coursese', 'banners'));
}
public function hosipitality() {
    $banners = hewitt_banners::where('status', true)->get();
    $coursese = courses::all();
    $hosipitalityDepartments = department::where('name', 'like', '%hospitality%')->pluck('id');
    $hosipitalityCourses = courses::whereIn('department_id', $hosipitalityDepartments)->get();

    return view('frontendviews.hosipitality.index', compact('hosipitalityCourses', 'coursese', 'banners'));
}
    public function index()
{
    $departments = department::all(); // Assuming you fetch departments here
    $courses = courses::all();
    return view('dashboards.staff.courses.index', compact('departments','courses'));
}

public function accreditations()
{
    $banners = hewitt_banners::where('status', true)->get();
    $coursese = courses::all();
    return view('frontendviews.accreditations.index',compact('banners','coursese'));
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
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string',
            'school_fees' => 'required|numeric',
            'registration_fees' => 'required|numeric',
            'duration' => 'required|string',
            'course_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'school_uniform_fee' => 'required|numeric',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/course_images'); // Store the image and get the path
            $validatedData['image'] = asset(str_replace('public/', 'storage/', $imagePath));
        }

        courses::create($validatedData);

        return redirect()->back()->with('success', 'Course Stored successfully.'); // Redirect to the appropriate page after creating the course
    }





    /**
     * Display the specified resource.
     */
    public function show(courses $courses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Courses $course)
    {
        $departments = department::all();
        return view('dashboards.staff.courses.edit.courseedit', compact('course', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courses $course)
{
    $validatedData = $request->validate([
        'department_id' => 'required|exists:departments,id',
        'name' => 'required|string',
        'school_fees' => 'required|numeric',
        'registration_fees' => 'required|numeric',
        'duration' => 'required|string',
        'course_description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'school_uniform_fee' => 'required|numeric',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('course_images', 'public');
        $validatedData['image'] = asset('storage/' . $imagePath); // Use asset() for URL generation

        // Create a symbolic link to the uploaded image
        $imagePublicPath = str_replace('storage/', '', $imagePath);
        $imageFullPath = storage_path('app/public/' . $imagePublicPath);
        $linkPath = public_path('storage/' . $imagePublicPath);

        if (!file_exists($linkPath)) {
            // Ensure the symbolic link does not exist before creating it
            symlink($imageFullPath, $linkPath);
        }
    }

    $course->update($validatedData);

    return redirect()->back()->with('success', 'Course updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courses $course)
{
    // Delete the course image if it exists
    if ($course->image) {
        Storage::delete('public/' . $course->image);
    }

    // Delete the course
    $course->delete();

    return redirect()->back()->with('success', 'Course deleted successfully.');
}


}
