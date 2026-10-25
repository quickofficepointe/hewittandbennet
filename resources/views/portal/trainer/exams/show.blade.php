@extends('layouts.portal')
@section('pageTitle', $exam->title)

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="text-sm text-slate-600">{{ $exam->unit->code }} - {{ $exam->unit->name }} &middot; {{ $exam->duration_minutes }} min &middot; {{ $exam->questions->sum('marks') }} marks &middot; <x-portal.badge :status="$exam->published ? 'published' : 'draft'" /></div>
    <div class="flex gap-2">
        <x-portal.button variant="secondary" icon="fa-arrow-left" :href="route('portal.trainer.exams.index')">All exams</x-portal.button>
        <form method="POST" action="{{ route('portal.trainer.exams.publish', $exam) }}">@csrf @method('PATCH')
            <x-portal.button :variant="$exam->published ? 'secondary' : 'success'" :icon="$exam->published ? 'fa-eye-slash' : 'fa-paper-plane'">{{ $exam->published ? 'Unpublish' : 'Publish' }}</x-portal.button>
        </form>
        <form method="POST" action="{{ route('portal.trainer.exams.destroy', $exam) }}" onsubmit="return confirm('Delete this exam, its questions and all attempts?')">@csrf @method('DELETE')
            <x-portal.button variant="danger" icon="fa-trash">Delete</x-portal.button>
        </form>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-4">
        @forelse ($exam->questions as $question)
            <x-portal.card>
                <div class="flex justify-between gap-4">
                    <div class="font-medium">Q{{ $loop->iteration }}. {{ $question->question }} <span class="text-xs text-slate-500">({{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }})</span></div>
                    @if ($exam->attempts->isEmpty())
                        <form method="POST" action="{{ route('portal.trainer.exams.questions.destroy', $question) }}">@csrf @method('DELETE')
                            <button class="text-slate-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    @endif
                </div>
                <ol class="mt-3 space-y-1 text-sm list-[upper-alpha] list-inside">
                    @foreach ($question->options as $index => $option)
                        <li class="{{ $index === $question->correct_option ? 'text-green-700 font-medium' : '' }}">{{ $option }} @if ($index === $question->correct_option)<i class="fa-solid fa-check"></i>@endif</li>
                    @endforeach
                </ol>
            </x-portal.card>
        @empty
            <x-portal.card><x-portal.empty icon="fa-circle-question" message="No questions yet. Add the first one." /></x-portal.card>
        @endforelse

        <x-portal.card title="Attempts" :padding="false">
            <x-portal.table :headers="['Student', 'Started', 'Submitted', 'Score', '%']">
                @forelse ($exam->attempts as $attempt)
                    <tr>
                        <td class="px-4 py-2">{{ $attempt->student?->full_name }} <span class="text-xs text-slate-500 font-mono">{{ $attempt->student?->admission_no }}</span></td>
                        <td class="px-4 py-2 text-xs">{{ $attempt->started_at->format('d M H:i') }}</td>
                        <td class="px-4 py-2 text-xs">{{ $attempt->submitted_at?->format('d M H:i') ?? 'In progress' }}</td>
                        <td class="px-4 py-2">{{ $attempt->submitted_at ? (float) $attempt->score.' / '.(float) $attempt->total : '-' }}</td>
                        <td class="px-4 py-2">{{ $attempt->percent !== null ? $attempt->percent.'%' : '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-portal.empty message="No attempts yet." /></td></tr>
                @endforelse
            </x-portal.table>
        </x-portal.card>
    </div>

    <x-portal.card title="Add a question" class="h-fit">
        @if ($exam->attempts->isNotEmpty())
            <p class="text-sm text-slate-500">Students have already attempted this exam, so questions are locked.</p>
        @else
            <form method="POST" action="{{ route('portal.trainer.exams.questions.store', $exam) }}" class="space-y-3">
                @csrf
                <x-portal.textarea name="question" label="Question" required />
                <div class="text-sm font-medium text-slate-700">Options <span class="text-xs font-normal text-slate-500">(select the correct one)</span></div>
                @foreach (range(0, 3) as $i)
                    <div class="flex items-center gap-2">
                        <input type="radio" name="correct_option" value="{{ $i }}" @checked((int) old('correct_option', 0) === $i) class="h-4 w-4">
                        <span class="text-xs font-semibold w-4">{{ chr(65 + $i) }}</span>
                        <input type="text" name="options[{{ $i }}]" value="{{ old('options.'.$i) }}" class="flex-1 rounded border border-slate-300 px-2 py-1 text-sm" @if ($i < 2) required @endif>
                    </div>
                @endforeach
                <x-portal.input name="marks" type="number" label="Marks" value="1" min="1" max="20" required />
                <x-portal.button icon="fa-plus">Add question</x-portal.button>
            </form>
        @endif
    </x-portal.card>
</div>
@endsection
