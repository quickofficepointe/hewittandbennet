@extends('layouts.portal')
@section('pageTitle', 'My Units')

@section('content')
<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
    @forelse ($units as $unit)
        <a href="{{ route('portal.trainer.units.show', $unit) }}" class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:border-primary/40 hover:shadow transition">
            <div class="text-xs font-mono text-primary">{{ $unit->code }}</div>
            <div class="mt-1 font-semibold text-slate-800">{{ $unit->name }}</div>
            <div class="text-xs text-slate-500 mt-1">{{ $unit->course?->name }} &middot; Term {{ $unit->term_no }}</div>
            <div class="mt-4 grid grid-cols-4 gap-2 text-center text-xs">
                <div><div class="text-lg font-semibold">{{ $unit->students_count }}</div>Students</div>
                <div><div class="text-lg font-semibold">{{ $unit->assessments_count }}</div>Assessments</div>
                <div><div class="text-lg font-semibold">{{ $unit->materials_count }}</div>Materials</div>
                <div><div class="text-lg font-semibold">{{ $unit->exams_count }}</div>Exams</div>
            </div>
        </a>
    @empty
        <x-portal.card class="md:col-span-2 xl:col-span-3"><x-portal.empty icon="fa-layer-group" message="No units have been assigned to you yet." /></x-portal.card>
    @endforelse
</div>
@endsection
