@extends('layouts.portal')
@section('pageTitle', 'Academic Report')

@section('content')
<div class="no-print mb-4"><x-portal.button variant="secondary" type="button" onclick="window.print()" icon="fa-print">Print</x-portal.button></div>

<x-portal.card title="Programmes" class="mb-6" :padding="false" subtitle="Pass rate = share of published assessment marks at 50% or above.">
    <x-portal.table :headers="['Course', 'Department', 'Units', 'Active', 'Graduated', 'Dropped / suspended', 'Attendance', 'Pass rate']" :datatable="true">
        @foreach ($courses as $course)
            @php($att = $attendanceByCourse[$course->id] ?? null)
            @php($pass = $passByCourse[$course->id] ?? null)
            <tr>
                <td class="px-4 py-2 font-medium">{{ $course->name }}</td>
                <td class="px-4 py-2">{{ $course->department?->name }}</td>
                <td class="px-4 py-2">{{ $course->units_count }}</td>
                <td class="px-4 py-2">{{ $course->active_count }}</td>
                <td class="px-4 py-2">{{ $course->graduated_count }}</td>
                <td class="px-4 py-2">{{ $course->dropped_count }}</td>
                <td class="px-4 py-2">{{ $att && $att->total ? round($att->attended / $att->total * 100).'%' : '-' }}</td>
                <td class="px-4 py-2">{{ $pass && $pass->total ? round($pass->passed / $pass->total * 100).'%' : '-' }}</td>
            </tr>
        @endforeach
    </x-portal.table>
</x-portal.card>

<x-portal.card title="Trainer workload" :padding="false">
    <x-portal.table :headers="['Trainer', 'Units', 'Contact hours']">
        @forelse ($trainerLoad as $row)
            <tr>
                <td class="px-4 py-2">{{ $row['trainer']?->name }}</td>
                <td class="px-4 py-2">{{ $row['units'] }}</td>
                <td class="px-4 py-2">{{ $row['hours'] }}</td>
            </tr>
        @empty
            <tr><td colspan="3"><x-portal.empty message="No units have trainers assigned yet." /></td></tr>
        @endforelse
    </x-portal.table>
</x-portal.card>
@endsection
