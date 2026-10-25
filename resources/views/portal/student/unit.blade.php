@extends('layouts.portal')
@section('pageTitle', $unit->code.' - '.$unit->name)

@section('content')
<div class="mb-4"><x-portal.button size="sm" variant="secondary" icon="fa-arrow-left" :href="route('portal.student.units')">My units</x-portal.button></div>
<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-6">
        <x-portal.card title="About this unit">
            <div class="text-sm text-slate-600 space-y-1">
                <div><span class="text-slate-500">Trainer:</span> {{ $unit->trainer?->name ?? 'To be assigned' }}</div>
                <div><span class="text-slate-500">Term:</span> {{ $unit->term_no }} @if ($unit->hours) &middot; {{ $unit->hours }} contact hours @endif</div>
                @if ($unit->timetable->isNotEmpty())
                    <div><span class="text-slate-500">Classes:</span>
                        {{ $unit->timetable->map(fn ($t) => $t->day_name.' '.substr($t->start_time, 0, 5).'-'.substr($t->end_time, 0, 5).($t->venue ? ' ('.$t->venue.')' : ''))->implode(', ') }}
                    </div>
                @endif
            </div>
            @if ($unit->description)<p class="mt-4 text-sm">{{ $unit->description }}</p>@endif
            @if ($unit->outcomes)
                <h3 class="mt-5 text-sm font-semibold">Learning outcomes - by the end of this unit you should be able to:</h3>
                <ol class="mt-2 list-decimal list-inside space-y-1 text-sm">
                    @foreach ($unit->outcomes as $outcome)<li>{{ $outcome }}</li>@endforeach
                </ol>
            @endif
        </x-portal.card>

        <x-portal.card title="Learning materials">
            @forelse ($unit->materials as $material)
                <div class="flex items-start gap-3 py-3 {{ ! $loop->last ? 'border-b border-slate-100' : '' }}">
                    <i class="fa-solid {{ $material->file_path ? 'fa-file-arrow-down' : 'fa-link' }} text-primary mt-1"></i>
                    <div>
                        <div class="font-medium">{{ $material->title }}</div>
                        @if ($material->description)<div class="text-sm text-slate-500">{{ $material->description }}</div>@endif
                        <div class="text-xs mt-1 space-x-3">
                            @if ($material->file_path)<a href="{{ asset('storage/'.$material->file_path) }}" target="_blank" class="text-primary hover:underline">Download</a>@endif
                            @if ($material->link)<a href="{{ $material->link }}" target="_blank" rel="noopener" class="text-primary hover:underline">Open link</a>@endif
                            <span class="text-slate-400">{{ $material->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <x-portal.empty icon="fa-folder-open" message="Your trainer has not shared any materials yet." />
            @endforelse
        </x-portal.card>
    </div>

    <x-portal.card title="My performance" class="h-fit">
        <div class="text-center mb-4">
            <div class="text-4xl font-bold text-primary">{{ $mark !== null ? $mark.'%' : '-' }}</div>
            <div class="mt-2"><x-portal.badge :color="$grade[2]">{{ $grade[0] }}</x-portal.badge> <span class="text-sm text-slate-600">{{ $grade[1] }}</span></div>
        </div>
        @forelse ($assessments as $assessment)
            @php($result = $assessment->results->first())
            <div class="flex justify-between text-sm py-2 border-t border-slate-100">
                <div><div class="font-medium">{{ $assessment->title }}</div><div class="text-xs text-slate-500">{{ \App\Models\Assessment::TYPES[$assessment->type] }} &middot; {{ $assessment->weight }}%</div></div>
                <div class="text-right">{{ $result?->score !== null ? (float) $result->score.' / '.(float) $assessment->max_score : 'Not marked' }}
                    @if ($result?->remarks)<div class="text-xs text-slate-500">{{ $result->remarks }}</div>@endif
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500 text-center">No published assessments yet.</p>
        @endforelse
    </x-portal.card>
</div>
@endsection
