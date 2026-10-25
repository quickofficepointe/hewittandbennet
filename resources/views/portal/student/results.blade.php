@extends('layouts.portal')
@section('pageTitle', 'Results')

@section('content')
<div class="mb-4 flex justify-between items-center flex-wrap gap-3">
    <p class="text-sm text-slate-500">Grading: Distinction 80+, Credit 65-79, Pass 50-64 (Competent); below 50 is Not Yet Competent. Only published marks are shown.</p>
    <x-portal.button icon="fa-print" :href="route('portal.student.results.transcript')">Print provisional transcript</x-portal.button>
</div>

@forelse ($terms as $term => $rows)
    <x-portal.card :title="'Term '.$term" class="mb-6" :padding="false">
        <x-portal.table :headers="['Code', 'Unit', 'Mark', 'Grade', 'Competency']">
            @foreach ($rows as $row)
                <tr>
                    <td class="px-4 py-3 font-mono text-xs">{{ $row['unit']->code }}</td>
                    <td class="px-4 py-3"><a class="hover:text-primary" href="{{ route('portal.student.units.show', $row['unit']) }}">{{ $row['unit']->name }}</a></td>
                    <td class="px-4 py-3">{{ $row['mark'] !== null ? $row['mark'].'%' : '-' }}</td>
                    <td class="px-4 py-3"><x-portal.badge :color="$row['grade'][2]">{{ $row['grade'][0] }}</x-portal.badge></td>
                    <td class="px-4 py-3">{{ $row['grade'][1] }}</td>
                </tr>
            @endforeach
        </x-portal.table>
    </x-portal.card>
@empty
    <x-portal.card><x-portal.empty icon="fa-award" message="No results yet." /></x-portal.card>
@endforelse
@endsection
