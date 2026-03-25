<?php

namespace App\Http\Controllers;

use App\Models\team;
use Illuminate\Http\Request;

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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        'description' => 'nullable|string',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('team_images', 'public');
    }

    $team = Team::create($validated);

    return response()->json([
        'message' => 'Team created successfully!',
        'team' => $team,
    ], 201);
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
            'name' => 'sometimes|string|max:255',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $team->update($validated);

        return response()->json([
            'message' => 'Team updated successfully!',
            'team' => $team,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json([
            'message' => 'Team deleted successfully!',
        ]);
    }
}
