<?php

namespace App\Http\Controllers;

use App\Models\reviews;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $review = reviews::all(); // Fetch all banners from the database
        return view('dashboards.staff.reviews.index',compact('review'));
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'message' => 'required|string',
            'rate' => 'required|integer|min:1|max:5',
        ]);
        // Set status to 0 (not approved) by default
        $validatedData['status'] = 0;
        $reviews = reviews::create($validatedData);
        return redirect('/')->with('success', 'Review submitted and pending approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(reviews $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reviews $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reviews $reviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reviews = reviews::findOrFail($id);
        $reviews->delete();
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }

    public function approved($id)
    {
        $review = reviews::findOrFail($id);
        $review->status = 1; // Set status to 1 for approved
        $review->save();
        return redirect()->route('reviews.index')->with('success', 'Review approved successfully.');
    }
}
