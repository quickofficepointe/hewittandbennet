<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();

        return view('dashboards.staff.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        Testimonial::create($this->validated($request));

        return back()->with('success', 'Testimonial added.');
    }

    public function update(Request $request, testimonial $testimonial)
    {
        $testimonial->update($this->validated($request));

        return back()->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted.');
    }

    /** The CMS form posts name/image/description; map them onto the testimonial columns. */
    private function validated(Request $request): array
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $data = [
            'name' => $request->name,
            'testimony' => $request->description,
            'position' => $request->position,
            'company' => $request->company,
            'rating' => $request->rating,
        ];

        if ($request->hasFile('image')) {
            $data['avatar'] = $request->file('image')->store('testimonials', 'public');
        }

        return $data;
    }
}
