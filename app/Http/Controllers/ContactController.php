<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function show()
    {
        return view('frontendviews.contact.index');
    }

    public function store(Request $request)
    {
        // Bots fill the hidden "website" field; pretend success so they move on.
        if ($request->filled('website')) {
            return back()->with('success', 'Thank you! Your message has been received.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'subject' => ['required', Rule::in(ContactMessage::SUBJECTS)],
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($data);

        return back()->with('success', 'Thank you! Your message has been received. Our team will get back to you within one working day.');
    }
}
