@extends('layouts.portal')
@section('pageTitle', 'Student Dashboard')

@section('content')
<div class="rounded-xl bg-gradient-to-r from-primary to-primary-light text-white p-6 mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <div class="text-sm text-blue-100">Welcome back,</div>
        <div class="text-2xl font-semibold">{{ $student->full_name }}</div>
        <div class="text-sm text-blue-100 mt-1">{{ $student->admission_no }} &middot; {{ $student->course?->name }} &middot; Term {{ $student->current_term }}@if ($student->intake) &middot; {{ $student->intake->name }} intake @endif</div>
    </div>
    <x-portal.badge :status="$student->status" class="text-sm" />
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <x-portal.stat label="Units this term" :value="$units->count()" icon="fa-layer-group" :href="route('portal.student.units')" />
    <x-portal.stat label="Attendance" :value="$attendanceRate !== null ? $attendanceRate.'%' : '-'" icon="fa-clipboard-user" :color="$attendanceRate !== null && $attendanceRate < 75 ? 'red' : 'teal'" :href="route('portal.student.attendance')" hint="75% minimum required" />
    <x-portal.stat label="Fee balance" :value="money($balance)" icon="fa-receipt" :color="$balance > 0 ? 'red' : 'green'" :href="route('portal.student.fees')" />
    <x-portal.stat label="Open exams" :value="$openExams->count()" icon="fa-laptop-file" color="amber" :href="route('portal.student.exams.index')" />
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Today's classes" class="lg:col-span-2">
        @forelse ($today as $lesson)
            <div class="flex items-center gap-4 py-3 {{ ! $loop->last ? 'border-b border-slate-100' : '' }}">
                <div class="text-sm font-mono bg-primary-50 text-primary rounded px-2 py-1">{{ substr($lesson->start_time, 0, 5) }} - {{ substr($lesson->end_time, 0, 5) }}</div>
                <div>
                    <div class="font-medium">{{ $lesson->unit->code }} - {{ $lesson->unit->name }}</div>
                    <div class="text-xs text-slate-500">{{ $lesson->unit->trainer?->name }} @if ($lesson->venue) &middot; {{ $lesson->venue }} @endif</div>
                </div>
            </div>
        @empty
            <x-portal.empty icon="fa-mug-hot" message="No classes scheduled for today." />
        @endforelse
    </x-portal.card>

    <x-portal.card title="Announcements">
        <x-slot:actions><x-portal.button size="sm" variant="ghost" :href="route('portal.announcements.index')">All</x-portal.button></x-slot:actions>
        @forelse ($announcements as $announcement)
            <div class="py-2 {{ ! $loop->last ? 'border-b border-slate-100' : '' }}">
                <div class="font-medium text-sm">@if ($announcement->is_pinned)<i class="fa-solid fa-thumbtack text-secondary"></i> @endif{{ $announcement->title }}</div>
                <div class="text-xs text-slate-500 line-clamp-2">{{ \Illuminate\Support\Str::limit($announcement->body, 100) }}</div>
            </div>
        @empty
            <x-portal.empty icon="fa-bullhorn" message="No announcements." />
        @endforelse
    </x-portal.card>

    @if ($openExams->isNotEmpty())
        <x-portal.card title="Exams you can take now" class="lg:col-span-3">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($openExams as $exam)
                    <a href="{{ route('portal.student.exams.take', $exam) }}" onclick="return confirm('The timer starts as soon as you open the exam. Continue?')" class="rounded-lg border border-amber-200 bg-amber-50 p-4 hover:border-amber-400">
                        <div class="font-medium">{{ $exam->title }}</div>
                        <div class="text-xs text-slate-600">{{ $exam->unit->code }} &middot; {{ $exam->duration_minutes }} minutes</div>
                    </a>
                @endforeach
            </div>
        </x-portal.card>
    @endif
</div>
@endsection
