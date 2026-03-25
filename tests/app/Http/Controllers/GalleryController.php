<?php

namespace App\Http\Controllers;

use App\Models\gallery;
use App\Models\hewitt_banners;
use App\Models\courses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleryItems = gallery::all();
        $coursese = courses::all();
        return view('frontendviews.Gallery.gallery', compact('galleryItems', 'coursese'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $galleries = Gallery::all();  // Fetch all galleries
        return view('dashboards.staff.gallery.index', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|mimes:jpg,jpeg,png,gif,mp4|max:10240',
        ]);

        $hash = md5($request->title . $request->description);

        // Prevent duplicates within last 30 seconds
        $recent = Gallery::whereRaw('MD5(CONCAT(title, description)) = ?', [$hash])
            ->where('created_at', '>=', now()->subSeconds(30))
            ->first();

        if ($recent) {
            // prevent duplicate submission success
            Log::info('Duplicate gallery submission detected: ' . $request->title);
            return redirect()->route('gallery.index')->with('success', 'Gallery item added successfully.');
        }

        $filePath = $request->file('file')->store('gallery', 'public');
        $fileType = in_array($request->file('file')->extension(), ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : 'video';

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_type' => $fileType,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Gallery item added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|mimes:jpg,jpeg,png,gif,mp4|max:10240',  // Validate image or video file
        ]);

        // Update the gallery item
        $gallery->title = $request->title;
        $gallery->description = $request->description;

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::delete('public/' . $gallery->file_path);

            // Store the new file
            $filePath = $request->file('file')->store('gallery', 'public');
            $fileType = in_array($request->file('file')->extension(), ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : 'video';
            $gallery->file_path = $filePath;
            $gallery->file_type = $fileType;
        }

        $gallery->save();

        return redirect()->route('gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    // Optional: Delete a gallery item
    public function destroy(Gallery $gallery)
    {
        // Delete the file from storage
        Storage::delete('public/' . $gallery->file_path);

        // Delete the gallery item from the database
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
}
