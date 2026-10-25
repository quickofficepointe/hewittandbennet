@extends('layouts.portal')
@section('pageTitle', 'My Profile')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card class="lg:col-span-1">
        <div class="text-center">
            @if ($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" class="h-24 w-24 rounded-full object-cover mx-auto" alt="">
            @else
                <div class="h-24 w-24 rounded-full bg-primary text-white flex items-center justify-center text-3xl font-semibold mx-auto">{{ $user->initials }}</div>
            @endif
            <div class="mt-3 font-semibold text-lg">{{ $user->name }}</div>
            <div class="text-sm text-slate-500">{{ $user->role_label }}</div>
        </div>
        <dl class="mt-6 text-sm divide-y divide-slate-100">
            <div class="flex justify-between py-2"><dt class="text-slate-500">Username</dt><dd class="font-medium">{{ $user->username }}</dd></div>
            @if ($user->student)
                <div class="flex justify-between py-2"><dt class="text-slate-500">Admission No.</dt><dd class="font-medium">{{ $user->student->admission_no }}</dd></div>
                <div class="flex justify-between py-2 gap-4"><dt class="text-slate-500">Course</dt><dd class="font-medium text-right">{{ $user->student->course?->name }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-500">Intake</dt><dd class="font-medium">{{ $user->student->intake?->name ?? '-' }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-500">Current term</dt><dd class="font-medium">Term {{ $user->student->current_term }}</dd></div>
            @endif
            @if ($user->employee)
                <div class="flex justify-between py-2"><dt class="text-slate-500">Employee No.</dt><dd class="font-medium">{{ $user->employee->employee_no }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-slate-500">Designation</dt><dd class="font-medium">{{ $user->employee->designation }}</dd></div>
                <div class="flex justify-between py-2 gap-4"><dt class="text-slate-500">Department</dt><dd class="font-medium text-right">{{ $user->employee->department?->name ?? '-' }}</dd></div>
            @endif
            <div class="flex justify-between py-2"><dt class="text-slate-500">Last login</dt><dd class="font-medium">{{ $user->last_login_at?->diffForHumans() ?? '-' }}</dd></div>
        </dl>
    </x-portal.card>

    <div class="lg:col-span-2 space-y-6">
        <x-portal.card title="Contact details">
            <form method="POST" action="{{ route('portal.profile.update') }}" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
                @csrf @method('PUT')
                <x-portal.input name="name" label="Full name" :value="$user->name" required />
                <x-portal.input name="email" type="email" label="Email" :value="$user->email" required />
                <x-portal.input name="phone" label="Phone" :value="$user->phone" />
                <x-portal.input name="avatar" type="file" label="Profile photo" accept="image/*" />
                <div class="sm:col-span-2"><x-portal.button icon="fa-floppy-disk">Save changes</x-portal.button></div>
            </form>
        </x-portal.card>

        <x-portal.card title="Change password">
            <form method="POST" action="{{ route('portal.profile.password') }}" class="grid gap-4 sm:grid-cols-3">
                @csrf @method('PUT')
                <x-portal.input name="current_password" type="password" label="Current password" required />
                <x-portal.input name="password" type="password" label="New password" required />
                <x-portal.input name="password_confirmation" type="password" label="Confirm new password" required />
                <div class="sm:col-span-3"><x-portal.button icon="fa-key">Update password</x-portal.button></div>
            </form>
        </x-portal.card>
    </div>
</div>
@endsection
