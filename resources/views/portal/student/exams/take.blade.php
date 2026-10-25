@extends('layouts.portal')
@section('pageTitle', $exam->title)

@section('content')
<form method="POST" action="{{ route('portal.student.exams.submit', $exam) }}" id="exam-form"
      x-data="{ left: {{ $secondsLeft }}, get clock() { const m = Math.floor(this.left / 60), s = this.left % 60; return m + ':' + String(s).padStart(2, '0'); } }"
      x-init="const t = setInterval(() => { if (left > 0) { left--; } else { clearInterval(t); $el.submit(); } }, 1000)">
    @csrf
    <div class="sticky top-16 z-10 mb-6 flex items-center justify-between rounded-lg bg-white border border-slate-200 shadow-sm px-5 py-3">
        <div class="text-sm"><span class="font-medium">{{ $exam->unit->code }}</span> &middot; {{ $exam->questions->count() }} questions &middot; {{ $exam->questions->sum('marks') }} marks</div>
        <div class="font-mono text-lg" :class="left < 60 ? 'text-red-600 font-bold' : 'text-primary'"><i class="fa-regular fa-clock"></i> <span x-text="clock"></span></div>
    </div>

    @if ($exam->instructions)
        <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-900 whitespace-pre-line">{{ $exam->instructions }}</div>
    @endif

    <div class="space-y-4">
        @foreach ($exam->questions as $question)
            <x-portal.card>
                <div class="font-medium mb-3">{{ $loop->iteration }}. {{ $question->question }} <span class="text-xs text-slate-500">({{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }})</span></div>
                <div class="space-y-2">
                    @foreach ($question->options as $index => $option)
                        <label class="flex items-center gap-3 rounded-lg border border-slate-200 px-3 py-2 hover:bg-slate-50 cursor-pointer text-sm">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $index }}" class="h-4 w-4">
                            <span class="font-semibold">{{ chr(65 + $index) }}.</span> {{ $option }}
                        </label>
                    @endforeach
                </div>
            </x-portal.card>
        @endforeach
    </div>

    <div class="mt-6"><x-portal.button icon="fa-paper-plane" onclick="return confirm('Submit your answers? You cannot change them afterwards.')">Submit exam</x-portal.button></div>
</form>
@endsection
