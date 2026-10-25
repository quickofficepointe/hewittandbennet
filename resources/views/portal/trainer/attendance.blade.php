@extends('layouts.portal')
@section('pageTitle', 'Attendance - '.$unit->code)

@section('content')
<div class="grid gap-6 lg:grid-cols-4">
    <x-portal.card title="Register date" class="h-fit">
        <form method="GET" class="space-y-3">
            <x-portal.input name="date" type="date" :value="$date->format('Y-m-d')" max="{{ today()->format('Y-m-d') }}" onchange="this.form.submit()" />
        </form>
        @if ($recentDates->isNotEmpty())
            <div class="mt-5 text-xs font-semibold uppercase text-slate-500 mb-2">Recent registers</div>
            <div class="space-y-1">
                @foreach ($recentDates as $recent)
                    @php($recent = \Illuminate\Support\Carbon::parse($recent))
                    <a href="{{ route('portal.trainer.units.attendance', [$unit, 'date' => $recent->format('Y-m-d')]) }}"
                       class="block text-sm px-2 py-1 rounded {{ $recent->isSameDay($date) ? 'bg-primary-50 text-primary font-medium' : 'hover:bg-slate-50' }}">{{ $recent->format('D, d M Y') }}</a>
                @endforeach
            </div>
        @endif
        <div class="mt-5"><x-portal.button size="sm" variant="secondary" icon="fa-arrow-left" :href="route('portal.trainer.units.show', $unit)">Back to unit</x-portal.button></div>
    </x-portal.card>

    <x-portal.card class="lg:col-span-3" :title="$unit->name" :subtitle="$date->format('l, d F Y').($existing->isNotEmpty() ? ' - register already taken, you can update it' : '')" :padding="false">
        @if ($students->isEmpty())
            <x-portal.empty message="No active students in this unit's term." />
        @else
            <form method="POST" action="{{ route('portal.trainer.units.attendance.store', $unit) }}" x-data>
                @csrf
                <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
                <div class="px-5 py-3 flex flex-wrap gap-2 text-xs border-b border-slate-100">
                    <span class="text-slate-500 self-center">Mark all:</span>
                    @foreach (\App\Models\Attendance::STATUSES as $status)
                        <button type="button" class="px-2 py-1 rounded border border-slate-300 hover:bg-slate-50" @click="$root.querySelectorAll('input[value={{ $status }}]').forEach(i => i.checked = true)">{{ ucfirst($status) }}</button>
                    @endforeach
                </div>
                <x-portal.table :headers="['#', 'Admission No.', 'Student', 'Present', 'Late', 'Absent', 'Excused']">
                    @foreach ($students as $student)
                        @php($current = $existing[$student->id] ?? 'present')
                        <tr>
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 font-mono text-xs">{{ $student->admission_no }}</td>
                            <td class="px-4 py-2">{{ $student->full_name }}</td>
                            @foreach (['present', 'late', 'absent', 'excused'] as $status)
                                <td class="px-4 py-2"><input type="radio" name="status[{{ $student->id }}]" value="{{ $status }}" @checked($current === $status) class="h-4 w-4"></td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-portal.table>
                <div class="p-5"><x-portal.button icon="fa-floppy-disk">Save register</x-portal.button></div>
            </form>
        @endif
    </x-portal.card>
</div>
@endsection
