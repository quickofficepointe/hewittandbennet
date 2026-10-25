@extends('layouts.portal')
@section('pageTitle', 'Job Vacancies')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Advertise a vacancy" class="h-fit" subtitle="Open vacancies are listed on the website's careers page.">
        <form method="POST" action="{{ route('portal.hr.vacancies.store') }}" class="space-y-4">
            @csrf
            <x-portal.input name="title" label="Job title" required />
            <x-portal.select name="department_id" label="Department" :options="$departments" placeholder="Any / general" />
            <div class="grid grid-cols-2 gap-3">
                <x-portal.input name="location" label="Location" placeholder="e.g. Thika" />
                <x-portal.select name="employment_type" label="Type" :options="\App\Models\Employee::TYPES" required />
            </div>
            <x-portal.textarea name="description" label="Job description" rows="4" required />
            <x-portal.textarea name="requirements" label="Requirements" rows="3" />
            <x-portal.input name="closing_date" type="date" label="Closing date" />
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_open" value="1" checked class="rounded"> Accepting applications</label>
            <x-portal.button icon="fa-bullhorn">Publish vacancy</x-portal.button>
        </form>
    </x-portal.card>

    <div class="lg:col-span-2 space-y-4">
        @forelse ($vacancies as $vacancy)
            <x-portal.card x-data="{ edit: false }">
                <div class="flex justify-between gap-4">
                    <div>
                        <div class="font-semibold">{{ $vacancy->title }}</div>
                        <div class="text-xs text-slate-500">{{ $vacancy->department?->name ?? 'General' }} &middot; {{ \App\Models\Employee::TYPES[$vacancy->employment_type] }} @if ($vacancy->location) &middot; {{ $vacancy->location }} @endif &middot; closes {{ $vacancy->closing_date?->format('d M Y') ?? 'when filled' }}</div>
                    </div>
                    <div class="flex items-start gap-3 text-xs whitespace-nowrap">
                        <x-portal.badge :status="$vacancy->is_open ? 'open' : 'closed'" />
                        <a href="{{ route('portal.hr.applications.index', ['vacancy_id' => $vacancy->id]) }}" class="text-primary hover:underline">{{ $vacancy->applications_count }} applicant(s)</a>
                        <button @click="edit = !edit" class="text-primary hover:underline">Edit</button>
                        <form method="POST" action="{{ route('portal.hr.vacancies.destroy', $vacancy) }}" onsubmit="return confirm('Delete this vacancy?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline">Delete</button></form>
                    </div>
                </div>
                <div x-show="!edit" class="mt-3 text-sm text-slate-600 whitespace-pre-line">{{ \Illuminate\Support\Str::limit($vacancy->description, 300) }}</div>
                <form x-show="edit" x-cloak method="POST" action="{{ route('portal.hr.vacancies.update', $vacancy) }}" class="mt-4 grid gap-3 sm:grid-cols-2">
                    @csrf @method('PUT')
                    <x-portal.input name="title" label="Title" :value="$vacancy->title" :id="'title'.$vacancy->id" required />
                    <x-portal.select name="department_id" label="Department" :options="$departments" :value="$vacancy->department_id" placeholder="Any / general" />
                    <x-portal.input name="location" label="Location" :value="$vacancy->location" :id="'location'.$vacancy->id" />
                    <x-portal.select name="employment_type" label="Type" :options="\App\Models\Employee::TYPES" :value="$vacancy->employment_type" />
                    <div class="sm:col-span-2"><x-portal.textarea name="description" label="Description" :value="$vacancy->description" required /></div>
                    <div class="sm:col-span-2"><x-portal.textarea name="requirements" label="Requirements" :value="$vacancy->requirements" /></div>
                    <x-portal.input name="closing_date" type="date" label="Closing date" :value="$vacancy->closing_date?->format('Y-m-d')" :id="'closing'.$vacancy->id" />
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_open" value="1" @checked($vacancy->is_open) class="rounded"> Accepting applications</label>
                    <div><x-portal.button size="sm" icon="fa-floppy-disk">Save</x-portal.button></div>
                </form>
            </x-portal.card>
        @empty
            <x-portal.card><x-portal.empty icon="fa-briefcase" message="No vacancies advertised yet." /></x-portal.card>
        @endforelse
    </div>
</div>
@endsection
