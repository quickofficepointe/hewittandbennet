@extends('layouts.portal')
@section('pageTitle', $unit->code.' - '.$unit->name)

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="text-sm text-slate-500">{{ $unit->course?->name }} &middot; Term {{ $unit->term_no }} &middot; {{ $students->count() }} students</div>
    <div class="flex gap-2">
        <x-portal.button icon="fa-clipboard-user" :href="route('portal.trainer.units.attendance', $unit)">Take attendance</x-portal.button>
        <x-portal.button variant="secondary" icon="fa-laptop-file" :href="route('portal.trainer.exams.index')">Online exams</x-portal.button>
    </div>
</div>

<div x-data="{ tab: '{{ request('tab', 'students') }}' }">
    <div class="flex gap-1 border-b border-slate-200 mb-6 text-sm overflow-x-auto">
        @foreach (['students' => 'Class list', 'assessments' => 'Assessments', 'materials' => 'Materials', 'outcomes' => 'Learning outcomes'] as $key => $label)
            <button @click="tab = '{{ $key }}'" :class="tab === '{{ $key }}' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700'" class="px-4 py-2 border-b-2 font-medium whitespace-nowrap">{{ $label }}</button>
        @endforeach
    </div>

    <div x-show="tab === 'students'">
        <x-portal.card :padding="false">
            <x-portal.table :headers="['#', 'Admission No.', 'Name', 'Phone', 'Attendance', 'Current mark', 'Grade']">
                @forelse ($students as $student)
                    @php($rate = $attendanceRates[$student->id] ?? null)
                    @php($grade = \App\Models\AssessmentResult::grade($marks[$student->id]))
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-mono text-xs">{{ $student->admission_no }}</td>
                        <td class="px-4 py-2">{{ $student->full_name }}</td>
                        <td class="px-4 py-2">{{ $student->phone }}</td>
                        <td class="px-4 py-2">{{ $rate ? round($rate->attended / $rate->total * 100).'%' : '-' }}</td>
                        <td class="px-4 py-2">{{ $marks[$student->id] !== null ? $marks[$student->id].'%' : '-' }}</td>
                        <td class="px-4 py-2"><x-portal.badge :color="$grade[2]">{{ $grade[0] }}</x-portal.badge></td>
                    </tr>
                @empty
                    <tr><td colspan="7"><x-portal.empty message="No active students are in this unit's term yet." /></td></tr>
                @endforelse
            </x-portal.table>
        </x-portal.card>
    </div>

    <div x-show="tab === 'assessments'" x-cloak class="grid gap-6 lg:grid-cols-3">
        <x-portal.card title="New assessment" class="h-fit">
            <form method="POST" action="{{ route('portal.trainer.units.assessments.store', $unit) }}" class="space-y-4">
                @csrf
                <x-portal.input name="title" label="Title" placeholder="e.g. CAT 1" required />
                <x-portal.select name="type" label="Type" :options="$types" required />
                <div class="grid grid-cols-2 gap-3">
                    <x-portal.input name="max_score" type="number" step="0.5" label="Out of" value="100" required />
                    <x-portal.input name="weight" type="number" label="Weight %" value="30" required />
                </div>
                <x-portal.input name="date" type="date" label="Date" :value="today()->format('Y-m-d')" />
                <x-portal.button icon="fa-plus">Create & enter marks</x-portal.button>
                <p class="text-xs text-slate-500">The final mark is the weighted average of published assessments. 50% and above is Competent.</p>
            </form>
        </x-portal.card>
        <x-portal.card title="Assessments" class="lg:col-span-2" :padding="false">
            <x-portal.table :headers="['Title', 'Type', 'Out of', 'Weight', 'Marked', 'Status', '']">
                @forelse ($unit->assessments as $assessment)
                    <tr>
                        <td class="px-4 py-2 font-medium">{{ $assessment->title }}</td>
                        <td class="px-4 py-2">{{ $types[$assessment->type] }}</td>
                        <td class="px-4 py-2">{{ (float) $assessment->max_score }}</td>
                        <td class="px-4 py-2">{{ $assessment->weight }}%</td>
                        <td class="px-4 py-2">{{ $assessment->results_count }}/{{ $students->count() }}</td>
                        <td class="px-4 py-2"><x-portal.badge :status="$assessment->published ? 'published' : 'draft'" /></td>
                        <td class="px-4 py-2 text-right"><a href="{{ route('portal.trainer.units.assessments.show', $assessment) }}" class="text-xs text-primary hover:underline">Enter marks</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7"><x-portal.empty message="No assessments yet." /></td></tr>
                @endforelse
            </x-portal.table>
        </x-portal.card>
    </div>

    <div x-show="tab === 'materials'" x-cloak class="grid gap-6 lg:grid-cols-3">
        <x-portal.card title="Share material" class="h-fit">
            <form method="POST" action="{{ route('portal.trainer.units.materials.store', $unit) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <x-portal.input name="title" label="Title" required />
                <x-portal.textarea name="description" label="Description" rows="2" />
                <x-portal.input name="file" type="file" label="File (PDF, Word, PowerPoint, image, video - max 20MB)" />
                <x-portal.input name="link" type="url" label="...or a link" placeholder="https://" />
                <x-portal.button icon="fa-upload">Share</x-portal.button>
            </form>
        </x-portal.card>
        <x-portal.card title="Materials" class="lg:col-span-2">
            @forelse ($unit->materials as $material)
                <div class="flex items-start justify-between gap-4 py-3 {{ ! $loop->last ? 'border-b border-slate-100' : '' }}">
                    <div>
                        <div class="font-medium">{{ $material->title }}</div>
                        @if ($material->description)<div class="text-sm text-slate-500">{{ $material->description }}</div>@endif
                        <div class="text-xs mt-1 space-x-3">
                            @if ($material->file_path)<a href="{{ asset('storage/'.$material->file_path) }}" target="_blank" class="text-primary hover:underline"><i class="fa-solid fa-file"></i> File</a>@endif
                            @if ($material->link)<a href="{{ $material->link }}" target="_blank" rel="noopener" class="text-primary hover:underline"><i class="fa-solid fa-link"></i> Link</a>@endif
                            <span class="text-slate-400">{{ $material->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('portal.trainer.units.materials.destroy', $material) }}" onsubmit="return confirm('Remove this material?')">
                        @csrf @method('DELETE')
                        <button class="text-slate-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            @empty
                <x-portal.empty icon="fa-folder-open" message="No materials shared yet." />
            @endforelse
        </x-portal.card>
    </div>

    <div x-show="tab === 'outcomes'" x-cloak>
        <x-portal.card title="Intended learning outcomes" subtitle="Set by the administrator on the unit record.">
            @if ($unit->outcomes)
                <ol class="list-decimal list-inside space-y-2 text-sm">
                    @foreach ($unit->outcomes as $outcome)<li>{{ $outcome }}</li>@endforeach
                </ol>
            @else
                <x-portal.empty message="No learning outcomes recorded for this unit yet." />
            @endif
            @if ($unit->description)<p class="mt-4 text-sm text-slate-600">{{ $unit->description }}</p>@endif
        </x-portal.card>
    </div>
</div>
@endsection
