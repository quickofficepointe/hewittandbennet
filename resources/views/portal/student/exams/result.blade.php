@extends('layouts.portal')
@section('pageTitle', 'Result - '.$exam->title)

@section('content')
<div class="mb-6 flex items-center justify-between flex-wrap gap-3">
    <x-portal.button variant="secondary" icon="fa-arrow-left" :href="route('portal.student.exams.index')">All exams</x-portal.button>
    <div class="text-right">
        <div class="text-3xl font-bold text-primary">{{ (float) $attempt->score }} / {{ (float) $attempt->total }}</div>
        <div class="text-sm text-slate-500">{{ $attempt->percent }}% &middot; submitted {{ $attempt->submitted_at->format('d M Y H:i') }}</div>
    </div>
</div>
<div class="space-y-4">
    @foreach ($exam->questions as $question)
        @php($chosen = $attempt->answers[$question->id] ?? null)
        <x-portal.card>
            <div class="font-medium mb-3">
                {{ $loop->iteration }}. {{ $question->question }}
                @if ($chosen === $question->correct_option)
                    <x-portal.badge color="green">+{{ $question->marks }}</x-portal.badge>
                @else
                    <x-portal.badge color="red">0</x-portal.badge>
                @endif
            </div>
            <div class="space-y-1 text-sm">
                @foreach ($question->options as $index => $option)
                    <div class="rounded px-3 py-1.5 {{ $index === $question->correct_option ? 'bg-green-50 text-green-800 font-medium' : ($index === $chosen ? 'bg-red-50 text-red-700' : '') }}">
                        {{ chr(65 + $index) }}. {{ $option }}
                        @if ($index === $question->correct_option)<i class="fa-solid fa-check"></i>@elseif ($index === $chosen)<i class="fa-solid fa-xmark"></i>@endif
                    </div>
                @endforeach
            </div>
        </x-portal.card>
    @endforeach
</div>
@endsection
