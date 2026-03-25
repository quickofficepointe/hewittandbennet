<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:campuses,slug',
            'description' => 'nullable|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'banner_image' => 'nullable|image|max:2048',
        ]);

        // Auto-generate slug from name if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        // Check for existing campus with the same slug within the last 30 seconds
        $existing = Campus::where('slug', $validated['slug'])
            ->where('created_at', '>=', now()->subSeconds(30))
            ->first();

        if ($existing) {
            // prevent duplicate submission success
            Log::info('Duplicate campus submission detected: ' . $validated['name']);
            return redirect()->route('campuses.index')->with('success', 'Campus created.');
        }


        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('campuses', 'public');
        }

        Campus::create($validated);

        return back()->with('success', 'Campus created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campus $campus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campus $campus)
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
    public function destroy(Campus $campus)
    {
        // Delete associated banner image if exists
        if ($campus->banner_image) {
            Storage::disk('public')->delete($campus->banner_image);
        }

        $campus->delete();

        return redirect()->route('campuses.index')->with('success', 'Campus deleted successfully!');
    }
}
