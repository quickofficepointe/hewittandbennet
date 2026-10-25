<?php

namespace App\Http\Controllers;

use App\Models\reviews;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        $review = reviews::latest()->get();

        return view('dashboards.staff.reviews.index', compact('review'));
    }

    /** Public review form: reviews stay hidden until an administrator approves them. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'rate' => 'required|integer|min:1|max:5',
        ]);

        reviews::create($validated + ['status' => false]);

        return back()->with('success', 'Thank you! Your review will appear once approved.');
    }

    public function approve(reviews $review)
    {
        $review->update(['status' => true]);

        return back()->with('success', 'Review approved.');
    }

    public function destroy(reviews $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
