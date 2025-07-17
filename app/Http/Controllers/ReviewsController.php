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
            'rate' => 'required|integer|min:1|max:5', // Adjust the validation rules for your rating scale


        ]);
        // Create a new testimonial using the validated data
        $reviews = reviews::create($validatedData);



        return redirect()->route('testimonials.index'); // Redirect to the testimonials listing page
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
    public function destroy(reviews $reviews)
    {
        //
    }
}
