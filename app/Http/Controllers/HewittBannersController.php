<?php

namespace App\Http\Controllers;

use App\Models\hewitt_banners;
use Illuminate\Http\Request;

class HewittBannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = hewitt_banners::all(); // Fetch all banners from the database
        return view('dashboards.staff.banners.index',compact('banners'));
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
    {// Validate the uploaded file
    $validatedData = $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:6048',
    ]);

    // Save the uploaded file to public/banners
    $imageName = time() . '.' . $request->image->extension();
    $request->image->storeAs('banners', $imageName, 'public');

    // Create a new Banner instance and save it to the database
    $banner = new hewitt_banners();
    $banner->image_name = $imageName;
    $banner->image_path = asset('storage/banners/' . $imageName); // Set the full image path
    $banner->save();

    // Redirect back with a success message
    return back()->with('success', 'Banner uploaded successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(hewitt_banners $hewitt_banners)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    $banner = hewitt_banners::findOrFail($id);
    return view('dashboards.staff.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    $validatedData = $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6048',
        'status' => 'required|in:1,0',
    ]);

    $banner = hewitt_banners::findOrFail($id);

    // Update image if provided
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->storeAs('banners', $imageName, 'public');
        $banner->image_name = $imageName;
        $banner->image_path = asset('storage/banners/' . $imageName);
    }

    // Update status
    $banner->status = $validatedData['status'];

    $banner->save();

    return back()->with('success', 'Banner updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = hewitt_banners::findOrFail($id);
        $banner->delete();

        return back()->with('success', 'Banner deleted successfully.');
    }
}
