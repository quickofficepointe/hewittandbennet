<?php

namespace App\Http\Controllers\Portal\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->integer('role')))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($q) => $q
                ->where('name', 'like', "%{$request->q}%")
                ->orWhere('email', 'like', "%{$request->q}%")
                ->orWhere('username', 'like', "%{$request->q}%")))
            ->orderBy('name')
            ->paginate(25)->withQueryString();

        return view('portal.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('portal.admin.users.form', ['user' => new User(['role' => User::TRAINER, 'is_active' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        User::create($data + ['email_verified_at' => now()]);

        return redirect()->route('portal.admin.users.index')->with('success', 'User account created.');
    }

    public function edit(User $user)
    {
        return view('portal.admin.users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validated($request, $user);
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $this->guardSelf($user, $data);
        $user->update($data);

        return redirect()->route('portal.admin.users.index')->with('success', 'User account updated.');
    }

    public function toggle(User $user)
    {
        abort_if($user->id === auth()->id(), 422, 'You cannot deactivate your own account.');
        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', $user->is_active ? 'Account activated.' : 'Account deactivated.');
    }

    public function destroy(User $user)
    {
        abort_if($user->id === auth()->id(), 422, 'You cannot delete your own account.');
        $user->delete();

        return back()->with('success', 'User deleted.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($user?->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user?->id)],
            'phone' => 'nullable|string|max:30',
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', Password::min(8)],
            'is_active' => 'nullable|boolean',
        ]);

        // Only a director may create or promote another director.
        if ((int) $data['role'] === User::DIRECTOR && auth()->user()->role !== User::DIRECTOR) {
            abort(403, 'Only a director can assign the director role.');
        }

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function guardSelf(User $user, array $data): void
    {
        if ($user->id === auth()->id() && ((int) $data['role'] !== $user->role || ! $data['is_active'])) {
            abort(422, 'You cannot change your own role or deactivate yourself.');
        }
    }
}
