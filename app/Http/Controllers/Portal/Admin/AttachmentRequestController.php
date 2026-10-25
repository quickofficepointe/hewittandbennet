<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\attachment;
use Illuminate\Support\Facades\Storage;

/** Industrial attachment requests submitted through the public careers page. */
class AttachmentRequestController extends Controller
{
    public function index()
    {
        $attachments = attachment::latest()->paginate(25);

        return view('portal.admin.attachments', compact('attachments'));
    }

    public function document(attachment $attachment)
    {
        // Older uploads were stored as "public/..." on the local disk.
        $path = $attachment->document_path;
        abort_unless($path && Storage::exists($path), 404, 'Document not found.');

        return Storage::download($path);
    }
}
