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
        $video = TikTokVid::create([
            'video_url' => $request->input('video_url')
        ]);

        return response()->json([
            'message' => 'TikTok video saved successfully',
            'id' => $video->id
        ], 201);
    }

    public function update(Request $request, TikTokVid $tiktokVid)
    {
        $tiktokVid->update([
            'video_url' => $request->input('video_url')
        ]);

        return response()->json([
            'message' => 'Video URL updated'
        ]);
    }

    public function destroy(TikTokVid $tiktokVid)
    {
        $tiktokVid->delete();
        return response()->json(['message' => 'Video deleted']);
    }
    /**
     * Remove the specified resource from storage.
     */

}
