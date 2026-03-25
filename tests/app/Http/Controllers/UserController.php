<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index(){

        $users=User::all();

        return view('dashboards.Director.users.index',compact('users'));

    }
    public function edit($userId)
    {
        $users = User::findOrFail($userId);
        return view('dashboards.Director.users.edit', compact('users'));
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required', 'string', 'max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:1,0,2,3', // Replace 'admin', 'editor', 'author' with your roles
            'phone' => 'nullable|string|max:20',
        ]);

        // Update user data
        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),

        ]);

        return redirect()->route('director.dashboard')->with('success', 'User has been updated successfully.');
    }
    public function destroy(User $user)
    {
        // Ensure that the currently authenticated user is allowed to delete users


        // Delete the user
        $user->delete();

        return redirect()->route('director.dashboard')->with('success', 'User has been deleted successfully.');
    }
}
