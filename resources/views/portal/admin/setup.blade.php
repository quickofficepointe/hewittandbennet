@extends('layouts.portal')
@section('pageTitle', 'Terms & Intakes')

@section('content')
<div class="grid gap-6 lg:grid-cols-2">
    <x-portal.card title="Academic terms" subtitle="The current term is used for new assessments and invoices.">
        <form method="POST" action="{{ route('portal.admin.setup.terms.store') }}" class="grid gap-3 sm:grid-cols-2 mb-6">
            @csrf
            <div class="sm:col-span-2"><x-portal.input name="name" label="Term name" placeholder="e.g. Jan - Apr 2026" required /></div>
            <x-portal.input name="start_date" type="date" label="Starts" required />
            <x-portal.input name="end_date" type="date" label="Ends" required />
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_current" value="1" class="rounded"> Make this the current term</label>
            <div class="text-right"><x-portal.button size="sm" icon="fa-plus">Add term</x-portal.button></div>
        </form>
        <x-portal.table :headers="['Term', 'Dates', '', '']">
            @forelse ($terms as $term)
                <tr>
                    <td class="px-4 py-2 font-medium">{{ $term->name }}</td>
                    <td class="px-4 py-2 text-xs whitespace-nowrap">{{ $term->start_date->format('d M Y') }} - {{ $term->end_date->format('d M Y') }}</td>
                    <td class="px-4 py-2">
                        @if ($term->is_current)
                            <x-portal.badge color="green">Current</x-portal.badge>
                        @else
                            <form method="POST" action="{{ route('portal.admin.setup.terms.current', $term) }}">@csrf @method('PATCH')<button class="text-xs text-primary hover:underline">Make current</button></form>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-right">
                        <form method="POST" action="{{ route('portal.admin.setup.terms.destroy', $term) }}" onsubmit="return confirm('Delete this term?')">@csrf @method('DELETE')<button class="text-slate-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4"><x-portal.empty message="No terms yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>

    <x-portal.card title="Intakes" subtitle="Cohorts of students admitted together.">
        <form method="POST" action="{{ route('portal.admin.setup.intakes.store') }}" class="grid gap-3 sm:grid-cols-3 mb-6 items-end">
            @csrf
            <x-portal.input name="name" label="Intake" placeholder="e.g. May 2026" required />
            <x-portal.input name="start_date" type="date" label="Starts" required />
            <x-portal.button size="sm" icon="fa-plus">Add intake</x-portal.button>
        </form>
        <x-portal.table :headers="['Intake', 'Starts', 'Students', 'Status', '']">
            @forelse ($intakes as $intake)
                <tr>
                    <td class="px-4 py-2 font-medium">{{ $intake->name }}</td>
                    <td class="px-4 py-2">{{ $intake->start_date->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $intake->students_count }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('portal.admin.setup.intakes.toggle', $intake) }}">@csrf @method('PATCH')
                            <button title="Click to {{ $intake->is_open ? 'close' : 'open' }}"><x-portal.badge :status="$intake->is_open ? 'open' : 'closed'" /></button>
                        </form>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <form method="POST" action="{{ route('portal.admin.setup.intakes.destroy', $intake) }}" onsubmit="return confirm('Delete this intake?')">@csrf @method('DELETE')<button class="text-slate-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><x-portal.empty message="No intakes yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>

    <x-portal.card title="End of term: promote students" class="lg:col-span-2"
                   subtitle="Moves every active student in the course (and intake, if chosen) to the next term. Students already in the course's final term are marked as graduated.">
        <form method="POST" action="{{ route('portal.admin.setup.promote') }}" class="grid gap-3 sm:grid-cols-3 items-end" onsubmit="return confirm('Promote these students to the next term?')">
            @csrf
            <x-portal.select name="course_id" label="Course" :options="$courses->mapWithKeys(fn ($c) => [$c->id => $c->name.' ('.$c->total_terms.' terms)'])" placeholder="Select course..." required />
            <x-portal.select name="intake_id" label="Intake (optional)" :options="$intakes->pluck('name', 'id')" placeholder="All intakes" />
            <x-portal.button variant="success" icon="fa-forward">Promote</x-portal.button>
        </form>
    </x-portal.card>
</div>
@endsection
