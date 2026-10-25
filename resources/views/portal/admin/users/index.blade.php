@extends('layouts.portal')
@section('pageTitle', 'User Accounts')

@section('content')
<x-portal.card :padding="false">
    <x-slot:actions>
        <form method="GET" class="flex flex-wrap gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Search name, email, username" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm">
            <select name="role" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white" onchange="this.form.submit()">
                <option value="">All roles</option>
                @foreach (\App\Models\User::ROLE_LABELS as $value => $label)
                    <option value="{{ $value }}" @selected(request('role') !== null && (string) request('role') === (string) $value)>{{ $label }}</option>
                @endforeach
            </select>
            <x-portal.button size="sm" variant="secondary" icon="fa-magnifying-glass">Search</x-portal.button>
        </form>
        <x-portal.button size="sm" icon="fa-user-plus" :href="route('portal.admin.users.create')">New user</x-portal.button>
    </x-slot:actions>

    <x-portal.table :headers="['Name', 'Username', 'Email', 'Role', 'Last login', 'Status', '']">
        @forelse ($users as $user)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                <td class="px-4 py-3 font-mono text-xs">{{ $user->username }}</td>
                <td class="px-4 py-3">{{ $user->email }}</td>
                <td class="px-4 py-3"><x-portal.badge color="blue">{{ $user->role_label }}</x-portal.badge></td>
                <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ $user->last_login_at?->diffForHumans() ?? 'Never' }}</td>
                <td class="px-4 py-3"><x-portal.badge :status="$user->is_active ? 'active' : 'suspended'">{{ $user->is_active ? 'Active' : 'Inactive' }}</x-portal.badge></td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <a href="{{ route('portal.admin.users.edit', $user) }}" class="text-primary hover:underline text-xs mr-3">Edit</a>
                    @if ($user->id !== auth()->id())
                        <form method="POST" action="{{ route('portal.admin.users.toggle', $user) }}" class="inline">
                            @csrf @method('PATCH')
                            <button class="text-xs {{ $user->is_active ? 'text-amber-600' : 'text-green-600' }} hover:underline">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7"><x-portal.empty message="No users found." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $users->links() }}</div>
</x-portal.card>
@endsection
