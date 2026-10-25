@extends('layouts.portal')
@section('pageTitle', 'Results Overview')

@section('content')
<x-portal.card :padding="false" subtitle="Open a unit to see the broadsheet of weighted marks and competency for every student.">
    <x-slot:actions>
        <form method="GET">
            <select name="course_id" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white" onchange="this.form.submit()">
                <option value="">All courses</option>
                @foreach ($courses as $id => $name)<option value="{{ $id }}" @selected(request('course_id') == $id)>{{ $name }}</option>@endforeach
            </select>
        </form>
    </x-slot:actions>
    <x-portal.table :headers="['Code', 'Unit', 'Course', 'Term', 'Trainer', 'Assessments (published)', '']">
        @forelse ($units as $unit)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-mono text-xs">{{ $unit->code }}</td>
                <td class="px-4 py-3">{{ $unit->name }}</td>
                <td class="px-4 py-3">{{ $unit->course?->name }}</td>
                <td class="px-4 py-3">{{ $unit->term_no }}</td>
                <td class="px-4 py-3">{{ $unit->trainer?->name ?? '-' }}</td>
                <td class="px-4 py-3">{{ $unit->assessments_count }} ({{ $unit->published_count }})</td>
                <td class="px-4 py-3 text-right"><a class="text-xs text-primary hover:underline" href="{{ route('portal.admin.results.show', $unit) }}">Broadsheet</a></td>
            </tr>
        @empty
            <tr><td colspan="7"><x-portal.empty message="No units yet." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $units->links() }}</div>
</x-portal.card>
@endsection
