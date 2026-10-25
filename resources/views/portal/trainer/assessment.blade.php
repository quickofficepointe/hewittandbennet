@extends('layouts.portal')
@section('pageTitle', $assessment->title.' - '.$assessment->unit->code)

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="text-sm text-slate-600">
        {{ \App\Models\Assessment::TYPES[$assessment->type] }} &middot; out of {{ (float) $assessment->max_score }} &middot; weight {{ $assessment->weight }}%
        &middot; <x-portal.badge :status="$assessment->published ? 'published' : 'draft'" />
    </div>
    <div class="flex gap-2">
        <x-portal.button variant="secondary" icon="fa-arrow-left" :href="route('portal.trainer.units.show', [$assessment->unit, 'tab' => 'assessments'])">Back</x-portal.button>
        <form method="POST" action="{{ route('portal.trainer.units.assessments.publish', $assessment) }}">
            @csrf @method('PATCH')
            <x-portal.button :variant="$assessment->published ? 'secondary' : 'success'" :icon="$assessment->published ? 'fa-eye-slash' : 'fa-eye'">{{ $assessment->published ? 'Unpublish' : 'Publish' }}</x-portal.button>
        </form>
        <form method="POST" action="{{ route('portal.trainer.units.assessments.destroy', $assessment) }}" onsubmit="return confirm('Delete this assessment and all its marks?')">
            @csrf @method('DELETE')
            <x-portal.button variant="danger" icon="fa-trash">Delete</x-portal.button>
        </form>
    </div>
</div>

<x-portal.card :padding="false" title="Marks entry" subtitle="Leave a score blank if the student has not been assessed yet.">
    @if ($students->isEmpty())
        <x-portal.empty message="No active students in this unit's term." />
    @else
        <form method="POST" action="{{ route('portal.trainer.units.assessments.marks', $assessment) }}">
            @csrf @method('PUT')
            <x-portal.table :headers="['#', 'Admission No.', 'Student', 'Score / '.(float) $assessment->max_score, '%', 'Remarks']">
                @foreach ($students as $student)
                    @php($result = $results[$student->id] ?? null)
                    <tr x-data="{ score: '{{ old('scores.'.$student->id, $result?->score !== null ? (float) $result->score : '') }}' }">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-mono text-xs">{{ $student->admission_no }}</td>
                        <td class="px-4 py-2">{{ $student->full_name }}</td>
                        <td class="px-4 py-2"><input type="number" step="0.5" min="0" max="{{ $assessment->max_score }}" name="scores[{{ $student->id }}]" x-model="score" class="w-24 rounded border border-slate-300 px-2 py-1"></td>
                        <td class="px-4 py-2 text-slate-500" x-text="score === '' ? '-' : (score / {{ (float) $assessment->max_score }} * 100).toFixed(1) + '%'"></td>
                        <td class="px-4 py-2"><input type="text" name="remarks[{{ $student->id }}]" value="{{ old('remarks.'.$student->id, $result?->remarks) }}" class="w-full rounded border border-slate-300 px-2 py-1" placeholder="Optional"></td>
                    </tr>
                @endforeach
            </x-portal.table>
            <div class="p-5 flex gap-2">
                <x-portal.button icon="fa-floppy-disk">Save marks</x-portal.button>
                @unless ($assessment->published)
                    <x-portal.button variant="success" name="publish" value="1" icon="fa-paper-plane">Save &amp; publish</x-portal.button>
                @endunless
            </div>
        </form>
    @endif
</x-portal.card>
@endsection
