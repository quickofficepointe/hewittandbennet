@extends('layouts.portal')
@section('pageTitle', 'My Units')

@section('content')
@forelse ($units as $term => $termUnits)
    <div class="mb-8">
        <h2 class="font-semibold text-slate-700 mb-3">Term {{ $term }} @if ($term == $student->current_term)<x-portal.badge color="green">Current</x-portal.badge>@endif</h2>
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($termUnits as $unit)
                <a href="{{ route('portal.student.units.show', $unit) }}" class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:border-primary/40 hover:shadow transition">
                    <div class="text-xs font-mono text-primary">{{ $unit->code }}</div>
                    <div class="mt-1 font-semibold text-slate-800">{{ $unit->name }}</div>
                    <div class="text-xs text-slate-500 mt-2"><i class="fa-solid fa-chalkboard-user"></i> {{ $unit->trainer?->name ?? 'Trainer to be assigned' }}</div>
                    <div class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-folder"></i> {{ $unit->materials_count }} learning material(s) &middot; {{ count($unit->outcomes) }} outcome(s)</div>
                </a>
            @endforeach
        </div>
    </div>
@empty
    <x-portal.card><x-portal.empty icon="fa-layer-group" message="No units have been set up for your course yet." /></x-portal.card>
@endforelse
@endsection
