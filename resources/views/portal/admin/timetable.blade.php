@extends('layouts.portal')
@section('pageTitle', 'Timetable')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Add a lesson" class="h-fit">
        <form method="POST" action="{{ route('portal.admin.timetable.store') }}" class="space-y-4">
            @csrf
            <x-portal.select name="unit_id" label="Unit" :options="$units" placeholder="Select unit..." required />
            <x-portal.select name="day_of_week" label="Day" :options="\App\Models\TimetableEntry::DAYS" required />
            <div class="grid grid-cols-2 gap-3">
                <x-portal.input name="start_time" type="time" label="Start" value="08:00" required />
                <x-portal.input name="end_time" type="time" label="End" value="10:00" required />
            </div>
            <x-portal.input name="venue" label="Venue / room" placeholder="e.g. Lab 2" />
            <x-portal.button icon="fa-plus">Add to timetable</x-portal.button>
            <p class="text-xs text-slate-500">Lessons that double-book a trainer or venue are rejected.</p>
        </form>
    </x-portal.card>

    <x-portal.card title="Weekly timetable" class="lg:col-span-2">
        <x-slot:actions>
            <form method="GET">
                <select name="course_id" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white" onchange="this.form.submit()">
                    <option value="">All courses</option>
                    @foreach ($courses as $id => $name)<option value="{{ $id }}" @selected($courseId == $id)>{{ $name }}</option>@endforeach
                </select>
            </form>
            <x-portal.button size="sm" variant="secondary" type="button" onclick="window.print()" icon="fa-print">Print</x-portal.button>
        </x-slot:actions>
        @include('portal.partials.timetable', ['entries' => $entries, 'deletable' => true])
    </x-portal.card>
</div>
@endsection
