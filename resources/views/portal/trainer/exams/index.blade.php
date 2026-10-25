@extends('layouts.portal')
@section('pageTitle', 'Online Exams')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="New online exam" class="h-fit">
        @if ($units->isEmpty())
            <x-portal.empty message="You need an assigned unit to create exams." />
        @else
            <form method="POST" action="{{ route('portal.trainer.exams.store') }}" class="space-y-4">
                @csrf
                <x-portal.select name="unit_id" label="Unit" :options="$units->mapWithKeys(fn ($u) => [$u->id => $u->code.' - '.$u->name])" required />
                <x-portal.input name="title" label="Title" required />
                <x-portal.textarea name="instructions" label="Instructions" rows="2" />
                <x-portal.input name="duration_minutes" type="number" label="Duration (minutes)" value="30" required />
                <x-portal.input name="opens_at" type="datetime-local" label="Opens (optional)" />
                <x-portal.input name="closes_at" type="datetime-local" label="Closes (optional)" />
                <x-portal.button icon="fa-plus">Create exam</x-portal.button>
            </form>
        @endif
    </x-portal.card>

    <x-portal.card title="My exams" class="lg:col-span-2" :padding="false">
        <x-portal.table :headers="['Exam', 'Unit', 'Questions', 'Attempts', 'Window', 'Status', '']">
            @forelse ($exams as $exam)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-medium">{{ $exam->title }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $exam->unit->code }}</td>
                    <td class="px-4 py-3">{{ $exam->questions_count }}</td>
                    <td class="px-4 py-3">{{ $exam->attempts_count }}</td>
                    <td class="px-4 py-3 text-xs whitespace-nowrap">{{ $exam->opens_at?->format('d M H:i') ?? 'Any time' }} - {{ $exam->closes_at?->format('d M H:i') ?? 'no close' }}</td>
                    <td class="px-4 py-3"><x-portal.badge :status="$exam->published ? 'published' : 'draft'" /></td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('portal.trainer.exams.show', $exam) }}" class="text-xs text-primary hover:underline">Manage</a></td>
                </tr>
            @empty
                <tr><td colspan="7"><x-portal.empty icon="fa-laptop-file" message="No online exams yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>
</div>
@endsection
