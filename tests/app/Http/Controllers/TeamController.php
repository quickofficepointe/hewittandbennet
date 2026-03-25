<?php

namespace App\Http\Controllers;

use App\Models\team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all();
        return view('dashboards.staff.team.index', compact('teams'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($request->file('image')->getSize() > 2 * 1024 * 1024) { // 2MB in bytes
                return back()->withErrors(['image' => 'The image may not be greater than 2MB.'])->withInput();
            }
            $validated['image'] = $request->file('image')->store('team_images', 'public');
        }

        // prevent duplicate data within 30 seconds
        $recentlyCreated = Team::where('name', $validated['name'])
            ->where('created_at', '>=', now()->subSeconds(30))
            ->exists();
        if ($recentlyCreated) {
            // prevent duplicate creation
            return redirect()->route('teams.index')->with('success', 'Team created successfully!');
        }

        $team = Team::create($validated);

        return redirect()->route('teams.index')->with('success', 'Team created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($request->file('image')->getSize() > 2 * 1024 * 1024) { // 2MB in bytes
                return back()->withErrors(['image' => 'The image may not be greater than 2MB.'])->withInput();
            }
            $validated['image'] = $request->file('image')->store('team_images', 'public');
        }

        $team->update($validated);

        return redirect()->route('teams.index')->with('success', 'Team updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        // Delete associated image if exists
        if ($team->image) {
            Storage::disk('public')->delete($team->image);
        }
        
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully!');
    }
}
