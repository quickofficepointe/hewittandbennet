<?php

namespace App\Http\Controllers;

use App\Models\tiktokvid;
use Illuminate\Http\Request;

class TiktokvidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = tiktokvid::latest()->get();
        return view('dashboards.staff.socialmedia.index', compact('videos'));
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
        $videoUrl = $request->input('video_url');
        // Prevent duplicate video URLs
        if (\App\Models\tiktokvid::where('video_url', $videoUrl)->exists()) {
            return redirect()->route('tiktok-videos.index')->with('success', 'TikTok video saved successfully');
        }

        \App\Models\tiktokvid::create([
            'video_url' => $videoUrl
        ]);

        return redirect()->route('tiktok-videos.index')->with('success', 'TikTok video saved successfully');
    }

    public function update(Request $request, TikTokVid $tiktokVid)
    {
        $tiktokVid->update([
            'video_url' => $request->input('video_url')
        ]);

        return redirect()->route('tiktok-videos.index')->with('success', 'Video URL updated');

    }

    public function destroy(TikTokVid $tiktokVid)
    {
        // Delete the video record
        if ($tiktokVid->video_url) {
            // Optionally, you can delete the video file if stored locally
            // Storage::disk('public')->delete($tiktokVid->video_url);
        }
        $tiktokVid->delete();

        return redirect()->route('tiktok-videos.index')->with('success', 'Video deleted successfully');
    }
    /**
     * Remove the specified resource from storage.
     */

}
