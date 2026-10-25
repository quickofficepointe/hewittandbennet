@extends('layouts.portal')
@section('pageTitle', 'Units / Modules')

@section('content')
<x-portal.card :padding="false" subtitle="Each unit belongs to a course term and is taught by one trainer. Learning outcomes drive what trainers assess.">
    <x-slot:actions>
        <form method="GET" class="flex flex-wrap gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Code or name" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm">
            <select name="course_id" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white" onchange="this.form.submit()">
                <option value="">All courses</option>
                @foreach ($courses as $id => $name)<option value="{{ $id }}" @selected(request('course_id') == $id)>{{ $name }}</option>@endforeach
            </select>
        </form>
        <x-portal.button size="sm" icon="fa-plus" :href="route('portal.admin.units.create', ['course_id' => request('course_id')])">New unit</x-portal.button>
    </x-slot:actions>

    <x-portal.table :headers="['Code', 'Unit', 'Course', 'Term', 'Hours', 'Outcomes', 'Trainer', '']">
        @forelse ($units as $unit)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-mono text-xs">{{ $unit->code }}</td>
                <td class="px-4 py-3 font-medium">{{ $unit->name }}</td>
                <td class="px-4 py-3">{{ $unit->course?->name }}</td>
                <td class="px-4 py-3">{{ $unit->term_no }}</td>
                <td class="px-4 py-3">{{ $unit->hours ?: '-' }}</td>
                <td class="px-4 py-3">{{ count($unit->outcomes) }}</td>
                <td class="px-4 py-3">{!! $unit->trainer ? e($unit->trainer->name) : '<span class="text-amber-600 text-xs font-medium">Unassigned</span>' !!}</td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <a href="{{ route('portal.admin.units.edit', $unit) }}" class="text-xs text-primary hover:underline mr-3">Edit</a>
                    <form method="POST" action="{{ route('portal.admin.units.destroy', $unit) }}" class="inline" onsubmit="return confirm('Delete this unit?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8"><x-portal.empty icon="fa-layer-group" message="No units yet. Add the units/modules taught in each course." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $units->links() }}</div>
</x-portal.card>
@endsection
