@extends('layouts.portal')
@section('pageTitle', $user->exists ? 'Edit User' : 'New User')

@section('content')
<x-portal.card class="max-w-3xl" :title="$user->exists ? $user->name : 'Create a portal account'"
               subtitle="Students get accounts from the Students page; employees from HR. Use this page for any other account or to change roles.">
    <form method="POST" action="{{ $user->exists ? route('portal.admin.users.update', $user) : route('portal.admin.users.store') }}" class="grid gap-4 sm:grid-cols-2">
        @csrf
        @if ($user->exists) @method('PUT') @endif
        <x-portal.input name="name" label="Full name" :value="$user->name" required />
        <x-portal.input name="username" label="Username" :value="$user->username" required />
        <x-portal.input name="email" type="email" label="Email" :value="$user->email" required />
        <x-portal.input name="phone" label="Phone" :value="$user->phone" />
        @php($roles = auth()->user()->role === \App\Models\User::DIRECTOR ? \App\Models\User::ROLE_LABELS : \Illuminate\Support\Arr::except(\App\Models\User::ROLE_LABELS, [\App\Models\User::DIRECTOR]))
        <x-portal.select name="role" label="Role" :options="$roles" :value="$user->role" required />
        <div class="flex items-end pb-2">
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" class="rounded" @checked(old('is_active', $user->is_active))> Account is active</label>
        </div>
        <x-portal.input name="password" type="password" :label="$user->exists ? 'New password (leave blank to keep)' : 'Password'" :required="! $user->exists" />
        <x-portal.input name="password_confirmation" type="password" label="Confirm password" :required="! $user->exists" />
        <div class="sm:col-span-2 flex gap-2">
            <x-portal.button icon="fa-floppy-disk">Save</x-portal.button>
            <x-portal.button variant="secondary" :href="route('portal.admin.users.index')">Cancel</x-portal.button>
        </div>
    </form>
</x-portal.card>
@endsection
