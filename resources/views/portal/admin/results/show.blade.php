@extends('layouts.portal')
@section('pageTitle', 'Broadsheet - '.$unit->code)

@section('content')
<div class="no-print mb-4 flex gap-2">
    <x-portal.button type="button" onclick="window.print()" icon="fa-print">Print</x-portal.button>
    <x-portal.button variant="secondary" :href="route('portal.admin.results.index', ['course_id' => $unit->course_id])" icon="fa-arrow-left">Back</x-portal.button>
</div>
<x-portal.card>
    <x-portal.print-header title="Unit Broadsheet">
        <div class="text-sm">{{ $unit->code }} - {{ $unit->name }}</div>
        <div class="text-xs text-slate-500">{{ $unit->course?->name }} &middot; Term {{ $unit->term_no }} &middot; Trainer: {{ $unit->trainer?->name ?? '-' }}</div>
    </x-portal.print-header>
    <p class="text-xs text-slate-500 mb-4">Weighted from {{ $unit->assessments->where('published', true)->count() }} published assessment(s). Unpublished marks are excluded.</p>
    <x-portal.table :headers="['#', 'Admission No.', 'Student', 'Final mark', 'Grade', 'Competency']" :datatable="true">
        @foreach ($rows as $row)
            <tr>
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 font-mono text-xs">{{ $row['student']->admission_no }}</td>
                <td class="px-4 py-2">{{ $row['student']->full_name }}</td>
                <td class="px-4 py-2">{{ $row['mark'] !== null ? $row['mark'].'%' : '-' }}</td>
                <td class="px-4 py-2"><x-portal.badge :color="$row['grade'][2]">{{ $row['grade'][0] }}</x-portal.badge></td>
                <td class="px-4 py-2">{{ $row['grade'][1] }}</td>
            </tr>
        @endforeach
    </x-portal.table>
    @if ($rows->isEmpty())<x-portal.empty message="No active students are taking this unit this term." />@endif
</x-portal.card>
@endsection
