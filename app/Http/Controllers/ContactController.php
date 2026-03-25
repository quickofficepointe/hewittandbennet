<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index()
    {
        $messages = Contact::orderBy('created_at', 'desc')->paginate(20);
        $unreadCount = Contact::where('is_read', false)->count();

        return view('dashboards.staff.contact.messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display the specified contact message.
     */
    public function show($id)
    {
        $message = Contact::findOrFail($id);

        // Mark as read if it's unread
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('dashboards.staff.contact.messages.show', compact('message'));
    }

    /**
     * Store a newly created contact message.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Save to database
        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'is_read' => false,
        ]);

        // Send HTML email using inline view
        Mail::send([], [], function ($message) use ($validated) {
            $message->to('info@hewittbennet.co.ke')
                    ->subject('Contact Form: ' . $validated['subject'])
                    ->replyTo($validated['email'], $validated['name'])
                    ->html(
                        '<html>' .
                        '<body>' .
                        '<h2>New Contact Message</h2>' .
                        '<p><strong>Name:</strong> ' . htmlspecialchars($validated['name']) . '</p>' .
                        '<p><strong>Email:</strong> ' . htmlspecialchars($validated['email']) . '</p>' .
                        '<p><strong>Subject:</strong> ' . htmlspecialchars($validated['subject']) . '</p>' .
                        '<p><strong>Message:</strong></p>' .
                        '<p>' . nl2br(htmlspecialchars($validated['body'])) . '</p>' .
                        '</body>' .
                        '</html>'
                    );
        });

        // Redirect back with success message
        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    /**
     * Mark a message as read.
     */
    public function markAsRead($id)
    {
        $message = Contact::findOrFail($id);
        $message->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified contact message.
     */
    public function destroy($id)
    {
        $message = Contact::findOrFail($id);
        $message->delete();

        return redirect()->route('contact.messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
