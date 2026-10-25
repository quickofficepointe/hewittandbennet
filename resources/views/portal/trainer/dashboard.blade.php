@extends('layouts.portal')
@section('pageTitle', 'Trainer Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold">Welcome, {{ auth()->user()->name }}</h2>
    <p class="text-sm text-slate-500">{{ now()->format('l, d F Y') }}</p>
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <x-portal.stat label="My units" :value="$units->count()" icon="fa-layer-group" :href="route('portal.trainer.units.index')" />
    <x-portal.stat label="Students taught" :value="$units->sum('students_count')" icon="fa-user-graduate" color="indigo" />
    <x-portal.stat label="Lessons today" :value="$today->count()" icon="fa-calendar-day" color="teal" :href="route('portal.trainer.timetable')" />
    <x-portal.stat label="Unpublished assessments" :value="$unpublished->count()" icon="fa-hourglass-half" color="amber" />
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Today's lessons" class="lg:col-span-2">
        @forelse ($today as $lesson)
            <div class="flex items-center justify-between gap-4 py-3 {{ ! $loop->last ? 'border-b border-slate-100' : '' }}">
                <div class="flex items-center gap-4">
                    <div class="text-sm font-mono bg-primary-50 text-primary rounded px-2 py-1">{{ substr($lesson->start_time, 0, 5) }} - {{ substr($lesson->end_time, 0, 5) }}</div>
                    <div>
                        <div class="font-medium">{{ $lesson->unit->code }} - {{ $lesson->unit->name }}</div>
                        <div class="text-xs text-slate-500">{{ $lesson->unit->course?->name }} @if ($lesson->venue) &middot; {{ $lesson->venue }} @endif</div>
                    </div>
                </div>
                <x-portal.button size="sm" icon="fa-clipboard-user" :href="route('portal.trainer.units.attendance', $lesson->unit)">Take register</x-portal.button>
            </div>
        @empty
            <x-portal.empty icon="fa-mug-hot" message="No lessons scheduled for today." />
        @endforelse
    </x-portal.card>

    <x-portal.card title="Announcements">
        @forelse ($announcements as $announcement)
            <div class="py-2 {{ ! $loop->last ? 'border-b border-slate-100' : '' }}">
                <div class="font-medium text-sm">{{ $announcement->title }}</div>
                <div class="text-xs text-slate-500">{{ $announcement->created_at->diffForHumans() }}</div>
            </div>
        @empty
            <x-portal.empty icon="fa-bullhorn" message="No announcements." />
        @endforelse
    </x-portal.card>

    <x-portal.card title="My units" class="lg:col-span-2" :padding="false">
        <x-portal.table :headers="['Code', 'Unit', 'Course', 'Term', 'Students', '']">
            @forelse ($units as $unit)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-mono text-xs">{{ $unit->code }}</td>
                    <td class="px-4 py-3 font-medium">{{ $unit->name }}</td>
                    <td class="px-4 py-3">{{ $unit->course?->name }}</td>
                    <td class="px-4 py-3">{{ $unit->term_no }}</td>
                    <td class="px-4 py-3">{{ $unit->students_count }}</td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('portal.trainer.units.show', $unit) }}" class="text-xs text-primary hover:underline">Open</a></td>
                </tr>
            @empty
                <tr><td colspan="6"><x-portal.empty message="No units have been assigned to you yet. Ask the administrator." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>

    <x-portal.card title="Awaiting publication">
        @forelse ($unpublished as $assessment)
            <a href="{{ route('portal.trainer.units.assessments.show', $assessment) }}" class="block py-2 hover:text-primary {{ ! $loop->last ? 'border-b border-slate-100' : '' }}">
                <div class="font-medium text-sm">{{ $assessment->title }}</div>
                <div class="text-xs text-slate-500">{{ $assessment->unit->code }} &middot; {{ \App\Models\Assessment::TYPES[$assessment->type] }}</div>
            </a>
        @empty
            <x-portal.empty icon="fa-check" message="All assessments are published." />
        @endforelse
    </x-portal.card>
</div>
@endsection
