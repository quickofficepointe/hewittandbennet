<?php

namespace App\Http\Controllers;

use App\Models\campus;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses = Campus::all();
        return view('dashboards.staff.campuses.index', compact('campuses'));
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
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:campuses,name',
        'description' => 'nullable|string',
        'city' => 'required|string',
        'country' => 'required|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
        'banner_image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('banner_image')) {
        $validated['banner_image'] = $request->file('banner_image')->store('campuses', 'public');
    }

    // Generate unique slug
    $validated['slug'] = Str::slug($validated['name']);
    $count = Campus::where('slug', $validated['slug'])->count();
    if ($count > 0) {
        $validated['slug'] = $validated['slug'] . '-' . ($count + 1);
    }

    Campus::create($validated);

    return back()->with('success', 'Campus created!');
}


    /**
     * Display the specified resource.
     */
    public function show(campus $campus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(campus $campus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, Campus $campus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'banner_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($campus->banner_image) {
                Storage::delete($campus->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('campuses', 'public');
        }

        $campus->update($validated);

        return back()->with('success', 'Campus updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(campus $campus)
    {
        //
    }
}