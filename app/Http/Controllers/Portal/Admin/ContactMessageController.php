<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

/** Enquiries submitted through the public contact form. */
class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(25);

        return view('portal.admin.contact-messages', compact('messages'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->markRead(! $message->is_read);

        return back()->with('success', $message->is_read ? 'Marked as handled.' : 'Marked as new.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with('success', 'Message deleted.');
    }
}
