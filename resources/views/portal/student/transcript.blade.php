@extends('layouts.portal')
@section('pageTitle', 'Provisional Transcript')

@section('content')
<div class="no-print mb-4 flex gap-2">
    <x-portal.button type="button" onclick="window.print()" icon="fa-print">Print</x-portal.button>
    <x-portal.button variant="secondary" icon="fa-arrow-left" :href="route('portal.student.results')">Back</x-portal.button>
</div>
<x-portal.card class="max-w-4xl">
    <x-portal.print-header title="Provisional Transcript">
        <div class="text-xs text-slate-500">Printed {{ now()->format('d M Y') }}</div>
    </x-portal.print-header>
    <div class="grid grid-cols-2 gap-2 text-sm mb-6">
        <div><span class="text-slate-500">Name:</span> <strong>{{ $student->full_name }}</strong></div>
        <div><span class="text-slate-500">Admission No.:</span> <strong>{{ $student->admission_no }}</strong></div>
        <div><span class="text-slate-500">Course:</span> {{ $student->course?->name }}</div>
        <div><span class="text-slate-500">Intake:</span> {{ $student->intake?->name ?? '-' }}</div>
    </div>
    @foreach ($terms as $term => $rows)
        <h3 class="font-semibold text-sm mb-2">Term {{ $term }}</h3>
        <table class="w-full text-sm mb-6 border border-slate-200">
            <tr class="bg-slate-50 text-left"><th class="px-3 py-2">Code</th><th class="px-3 py-2">Unit</th><th class="px-3 py-2">Mark</th><th class="px-3 py-2">Grade</th><th class="px-3 py-2">Competency</th></tr>
            @foreach ($rows as $row)
                <tr class="border-t border-slate-200">
                    <td class="px-3 py-1.5 font-mono text-xs">{{ $row['unit']->code }}</td>
                    <td class="px-3 py-1.5">{{ $row['unit']->name }}</td>
                    <td class="px-3 py-1.5">{{ $row['mark'] !== null ? $row['mark'].'%' : '-' }}</td>
                    <td class="px-3 py-1.5">{{ $row['grade'][0] }}</td>
                    <td class="px-3 py-1.5">{{ $row['grade'][1] }}</td>
                </tr>
            @endforeach
        </table>
    @endforeach
    <p class="text-xs text-slate-500">KEY: Distinction 80-100, Credit 65-79, Pass 50-64, Fail below 50. This provisional transcript is not valid without the college stamp and the Registrar's signature.</p>
    <div class="mt-12 grid grid-cols-2 gap-8 text-sm">
        <div class="border-t border-slate-400 pt-2">Registrar</div>
        <div class="border-t border-slate-400 pt-2">College stamp &amp; date</div>
    </div>
</x-portal.card>
@endsection
