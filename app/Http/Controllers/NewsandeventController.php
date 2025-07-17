<?php

namespace App\Http\Controllers;

use App\Models\newsandevent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsandeventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all news and events, ordered by creation date (most recent first)
        $newsEvents = newsandevent::orderBy('created_at', 'desc')->get();

        // Pass the retrieved data to the view
        return view('dashboards.staff.newsandevent.index', compact('newsEvents'));
    }

    public function newsfront()
    {
        $newsEvents = newsandevent::orderBy('created_at', 'desc')->get();
        return view('frontendviews.newsandevents.index', compact('newsEvents'));
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
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image validation
        ]);

        // Handle the cover image upload if provided
        $coverImagePath = null;
       if ($request->hasFile('cover_image')) {
           $coverImagePath = $request->file('cover_image')->store('newsandevent_images', 'public');
       }


        // Generate the slug from the title
        $slug = Str::slug($request->input('title'));

        // Check if the generated slug already exists
        if (Newsandevent::where('slug', $slug)->exists()) {
            return redirect()->route('newsandevent.index')->with('error', 'Slug already exists.');
        }

        // Create the NewsAndEvent record
        Newsandevent::create([
            'title' => $request->input('title'),
            'slug' => $slug, // Use the generated slug
            'content' => $request->input('content'),
            'cover_image' => $coverImagePath, // Handle the cover image upload
            'user_id' => auth()->id(), // Store the ID of the authenticated user
        ]);

        // Redirect with success message
        return redirect()->route('newsandevent.index')->with('success', 'News and Event created successfully!');
    }




    /**
     * Display the specified resource.
     */
    public function show($slug)
{
    $event = newsandevent::where('slug', $slug)->firstOrFail();
    // Fetch the latest 5 news events excluding the current one
    $latestNews = newsandevent::where('id', '!=', $event->id)->orderBy('created_at', 'desc')->take(5)->get();
    return view('frontendviews.newsandevents.single', compact('event', 'latestNews'));
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(newsandevent $newsandevent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image validation
        ]);

        // Find the existing news and event
        $newsEvent = Newsandevent::findOrFail($id);



        // Handle the cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete the old cover image if exists
            if ($newsEvent->cover_image) {
                Storage::disk('public')->delete($newsEvent->cover_image);
            }
            $coverImagePath = $request->file('cover_image')->store('newsandevent_images', 'public');
        } else {
            $coverImagePath = $newsEvent->cover_image; // Keep the old image if not updated
        }
        // Handle the cover image upload if provided


        // Check if the title has changed to regenerate the slug
        $slug = Str::slug($request->input('title'));

        // Check if the generated slug already exists for another event
        if (Newsandevent::where('slug', $slug)->where('id', '!=', $newsEvent->id)->exists()) {
            return redirect()->route('newsandevent.index')->with('error', 'Slug already exists.');
        }

        // Update the news and event record
        $newsEvent->update([
            'title' => $request->input('title'),
            'slug' => $slug, // Use the generated slug
            'content' => $request->input('content'),
            'cover_image' => $coverImagePath, // Handle the cover image update
            'user_id' => auth()->id(), // Update the user ID to the currently authenticated user
        ]);

        // Redirect with success message
        return redirect()->route('newsandevent.index')->with('success', 'News and Event updated successfully!');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Newsandevent $newsandevent)
{
    // Delete the cover image if it exists
    if ($newsandevent->cover_image) {
        Storage::delete($newsandevent->cover_image);
    }

    // Delete the news/event record
    $newsandevent->delete();

    // Redirect with success message
    return redirect()->route('newsandevent.index')->with('success', 'News and Event deleted successfully!');
}

}