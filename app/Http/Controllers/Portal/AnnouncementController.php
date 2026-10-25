<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $canManage = $user->hasRole('admin', 'director');

        $announcements = $canManage
            ? Announcement::with('author')->orderByDesc('is_pinned')->latest()->paginate(15)
            : Announcement::with('author')->visibleTo($user)->paginate(15);

        return view('portal.announcements', compact('announcements', 'canManage'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|in:'.implode(',', array_keys(Announcement::AUDIENCES)),
            'is_pinned' => 'nullable|boolean',
        ]);

        Announcement::create($data + ['posted_by' => $request->user()->id, 'is_pinned' => $request->boolean('is_pinned')]);

        return back()->with('success', 'Announcement published.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return back()->with('success', 'Announcement removed.');
    }
}
