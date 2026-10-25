@extends('layouts.portal')
@section('pageTitle', 'Online Exams')

@section('content')
<x-portal.card :padding="false">
    <x-portal.table :headers="['Exam', 'Unit', 'Duration', 'Window', 'Result', '']">
        @forelse ($exams as $exam)
            @php($attempt = $attempts[$exam->id] ?? null)
            <tr>
                <td class="px-4 py-3 font-medium">{{ $exam->title }}<div class="text-xs text-slate-500">{{ $exam->questions_count }} questions</div></td>
                <td class="px-4 py-3">{{ $exam->unit->code }} - {{ $exam->unit->name }}</td>
                <td class="px-4 py-3">{{ $exam->duration_minutes }} min</td>
                <td class="px-4 py-3 text-xs whitespace-nowrap">{{ $exam->opens_at?->format('d M H:i') ?? 'Now' }} - {{ $exam->closes_at?->format('d M H:i') ?? 'Open' }}</td>
                <td class="px-4 py-3">{{ $attempt?->submitted_at ? (float) $attempt->score.' / '.(float) $attempt->total.' ('.$attempt->percent.'%)' : '-' }}</td>
                <td class="px-4 py-3 text-right">
                    @if ($attempt?->submitted_at)
                        <a href="{{ route('portal.student.exams.take', $exam) }}" class="text-xs text-primary hover:underline">Review</a>
                    @elseif ($exam->isOpen())
                        <x-portal.button size="sm" variant="success" :href="route('portal.student.exams.take', $exam)" onclick="return confirm('The timer starts as soon as you open the exam. Continue?')">{{ $attempt ? 'Resume' : 'Start' }}</x-portal.button>
                    @else
                        <x-portal.badge status="closed">{{ $exam->opens_at?->isFuture() ? 'Not open yet' : 'Closed' }}</x-portal.badge>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6"><x-portal.empty icon="fa-laptop-file" message="No online exams have been published for your units." /></td></tr>
        @endforelse
    </x-portal.table>
</x-portal.card>
@endsection
