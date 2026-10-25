@extends('layouts.portal')
@section('pageTitle', $unit->exists ? 'Edit Unit' : 'New Unit')

@section('content')
<x-portal.card class="max-w-4xl" :title="$unit->exists ? $unit->code.' - '.$unit->name : 'Add a unit / module'">
    <form method="POST" action="{{ $unit->exists ? route('portal.admin.units.update', $unit) : route('portal.admin.units.store') }}" class="grid gap-4 sm:grid-cols-2">
        @csrf
        @if ($unit->exists) @method('PUT') @endif
        <x-portal.select name="course_id" label="Course" :options="$courses" :value="$unit->course_id" placeholder="Select course..." required />
        <x-portal.select name="trainer_id" label="Trainer" :options="$trainers" :value="$unit->trainer_id" placeholder="Not assigned yet" />
        <x-portal.input name="code" label="Unit code" :value="$unit->code" placeholder="e.g. HBIC/CG/101" required />
        <x-portal.input name="name" label="Unit name" :value="$unit->name" required />
        <x-portal.input name="term_no" type="number" min="1" max="12" label="Taught in term" :value="$unit->term_no" required />
        <x-portal.input name="hours" type="number" min="0" label="Contact hours" :value="$unit->hours" />
        <div class="sm:col-span-2"><x-portal.textarea name="description" label="Description" :value="$unit->description" /></div>
        <div class="sm:col-span-2">
            <x-portal.textarea name="learning_outcomes" label="Learning outcomes (ILOs)" rows="6" :value="$unit->learning_outcomes"
                               help="One outcome per line, e.g. 'Demonstrate safe patient handling techniques'. Students see these on their unit page." />
        </div>
        <div class="sm:col-span-2 flex gap-2">
            <x-portal.button icon="fa-floppy-disk">Save unit</x-portal.button>
            <x-portal.button variant="secondary" :href="route('portal.admin.units.index')">Cancel</x-portal.button>
        </div>
    </form>
</x-portal.card>
@endsection
