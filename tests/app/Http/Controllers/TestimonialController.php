<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $testimonials = Testimonial::latest()->get();
        return view('dashboards.staff.testimonials.index', compact('testimonials'));
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
        Log::info('Validating testimonial data', ['user_id' => auth()->id()]);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'testimony' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Prevent duplicate testimonial by name and testimony
        $exists = Testimonial::where('name', $validatedData['name'])
            ->where('testimony', $validatedData['testimony'])
            ->exists();

        if ($exists) {
            return redirect()->route('testimonials.index')->with('success', 'Testimonial added successfully.'); //->back()->withInput()->withErrors(['duplicate' => 'A testimonial with the same name and testimony already exists.']);
        }

        // Custom file size validation for avatar
        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->withInput()->withErrors(['avatar' => 'Avatar image must not be greater than 2MB.']);
            }
        }

        Log::info('Storing a new testimonial', ['user_id' => auth()->id()]);

        $testimonial = new Testimonial();
        $testimonial->name = $validatedData['name'];
        $testimonial->testimony = $validatedData['testimony'];

        Log::info('Saving testimonial image', ['user_id' => auth()->id()]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('testimonials', 'public');
            $testimonial->avatar = $avatarPath;
        }

        Log::info('Saving testimonial', ['user_id' => auth()->id()]);

        $testimonial->save();
        return redirect()->route('testimonials.index')->with('success', 'Testimonial added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return response()->json($testimonial);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return response()->json($testimonial);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'testimony' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Custom file size validation for avatar
        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->withInput()->withErrors(['avatar' => 'Avatar image must not be greater than 2MB.']);
            }
        }

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->name = $validatedData['name'];
        $testimonial->testimony = $validatedData['testimony'];

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('testimonials', 'public');
            $testimonial->avatar = $avatarPath;
        }

        $testimonial->save();
        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Log the deletion attempt
        Log::info('Attempting to delete testimonial', ['id' => auth()->id(), 'testimonial_id' => $id]);

        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            Log::warning('Testimonial not found for deletion', ['id' => auth()->id(), 'testimonial_id' => $id]);
            return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted successfully.'); //->with('error', 'Testimonial not found.');
        }

        Log::info('Deleting testimonial image', ['id' => auth()->id(), 'testimonial_id' => $id]);

        if ($testimonial->avatar) {
            Storage::disk('public')->delete($testimonial->avatar);
        }

        Log::info('Deleting testimonial', ['id' => auth()->id(), 'testimonial_id' => $id]);

        $testimonial->delete();
        Log::info('Testimonial deleted successfully', ['id' => auth()->id(), 'testimonial_id' => $id]);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
