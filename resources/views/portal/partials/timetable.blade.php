{{-- $entries: TimetableEntry collection grouped by day_of_week --}}
@if ($entries->isEmpty())
    <x-portal.empty icon="fa-calendar-days" message="No lessons scheduled yet." />
@else
    <div class="space-y-5">
        @foreach (\App\Models\TimetableEntry::DAYS as $day => $dayName)
            @continue(! isset($entries[$day]))
            <div>
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">{{ $dayName }}</div>
                <div class="grid gap-2 sm:grid-cols-2">
                    @foreach ($entries[$day] as $entry)
                        <div class="flex items-start gap-3 rounded-lg border border-slate-200 p-3">
                            <div class="text-xs font-mono bg-primary-50 text-primary rounded px-2 py-1 whitespace-nowrap">{{ substr($entry->start_time, 0, 5) }}<br>{{ substr($entry->end_time, 0, 5) }}</div>
                            <div class="flex-1 min-w-0 text-sm">
                                <div class="font-medium truncate">{{ $entry->unit->code }} - {{ $entry->unit->name }}</div>
                                <div class="text-xs text-slate-500">
                                    {{ $entry->unit->course?->name }}
                                    @if ($entry->unit->trainer) &middot; {{ $entry->unit->trainer->name }}@endif
                                    @if ($entry->venue) &middot; <i class="fa-solid fa-location-dot"></i> {{ $entry->venue }}@endif
                                </div>
                            </div>
                            @if ($deletable ?? false)
                                <form method="POST" action="{{ route('portal.admin.timetable.destroy', $entry) }}" class="no-print" onsubmit="return confirm('Remove this lesson?')">
                                    @csrf @method('DELETE')
                                    <button class="text-slate-400 hover:text-red-600" title="Remove"><i class="fa-solid fa-xmark"></i></button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endif
