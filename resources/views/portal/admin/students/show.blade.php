@extends('layouts.portal')
@section('pageTitle', $student->full_name)

@section('content')
<div class="flex flex-wrap gap-2 mb-6">
    <x-portal.button icon="fa-pen" :href="route('portal.admin.students.edit', $student)">Edit</x-portal.button>
    @unless ($student->user_id)
        <form method="POST" action="{{ route('portal.admin.students.account', $student) }}">@csrf<x-portal.button variant="success" icon="fa-key">Create portal login</x-portal.button></form>
    @endunless
    @if (auth()->user()->hasRole('accountant', 'director'))
        <x-portal.button variant="secondary" icon="fa-receipt" :href="route('portal.accounts.balances.statement', $student)">Fee statement</x-portal.button>
    @endif
    <form method="POST" action="{{ route('portal.admin.students.destroy', $student) }}" onsubmit="return confirm('Archive this student and disable their portal access?')">
        @csrf @method('DELETE')
        <x-portal.button variant="danger" icon="fa-box-archive">Archive</x-portal.button>
    </form>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card>
        <div class="text-center">
            @if ($student->photo)
                <img src="{{ asset('storage/'.$student->photo) }}" class="h-28 w-28 rounded-full object-cover mx-auto" alt="">
            @else
                <div class="h-28 w-28 rounded-full bg-primary text-white flex items-center justify-center text-3xl font-semibold mx-auto">{{ mb_substr($student->first_name, 0, 1) }}{{ mb_substr($student->last_name, 0, 1) }}</div>
            @endif
            <div class="mt-3 font-semibold text-lg">{{ $student->full_name }}</div>
            <div class="font-mono text-sm text-slate-500">{{ $student->admission_no }}</div>
            <div class="mt-2"><x-portal.badge :status="$student->status" /></div>
        </div>
        <dl class="mt-6 text-sm divide-y divide-slate-100">
            @foreach ([
                'Course' => $student->course?->name,
                'Department' => $student->course?->department?->name,
                'Intake' => $student->intake?->name,
                'Campus' => $student->campus?->name,
                'Mode' => $student->mode_of_study,
                'Current term' => 'Term '.$student->current_term,
                'Admitted' => $student->admission_date->format('d M Y'),
                'Phone' => $student->phone,
                'Email' => $student->email,
                'ID No.' => $student->id_number,
                'Date of birth' => $student->date_of_birth?->format('d M Y'),
                'Gender' => ucfirst((string) $student->gender),
                'Guardian' => trim($student->guardian_name.' '.($student->guardian_relationship ? "({$student->guardian_relationship})" : '')),
                'Guardian phone' => $student->guardian_phone,
                'Portal login' => $student->user?->username ?? 'Not created',
            ] as $label => $value)
                <div class="flex justify-between gap-4 py-2"><dt class="text-slate-500">{{ $label }}</dt><dd class="font-medium text-right">{{ $value ?: '-' }}</dd></div>
            @endforeach
        </dl>
    </x-portal.card>

    <div class="lg:col-span-2 space-y-6">
        <div class="grid gap-4 sm:grid-cols-3">
            <x-portal.stat label="Total billed" :value="money($student->invoices->sum('amount'))" icon="fa-file-invoice" color="indigo" />
            <x-portal.stat label="Total paid" :value="money($student->payments->sum('amount'))" icon="fa-money-bill" color="green" />
            @php($balance = $student->invoices->sum('amount') - $student->payments->sum('amount'))
            <x-portal.stat label="Balance" :value="money($balance)" icon="fa-scale-unbalanced" :color="$balance > 0 ? 'red' : 'green'" />
        </div>

        @php($totalAttendance = $attendance->sum())
        <x-portal.card title="Attendance summary">
            @if ($totalAttendance)
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 text-center">
                    <div><div class="text-2xl font-semibold text-primary">{{ round((($attendance['present'] ?? 0) + ($attendance['late'] ?? 0)) / $totalAttendance * 100) }}%</div><div class="text-xs text-slate-500">Attendance rate</div></div>
                    @foreach (\App\Models\Attendance::STATUSES as $status)
                        <div><div class="text-2xl font-semibold">{{ $attendance[$status] ?? 0 }}</div><div class="text-xs text-slate-500">{{ ucfirst($status) }}</div></div>
                    @endforeach
                </div>
            @else
                <x-portal.empty message="No attendance recorded yet." />
            @endif
        </x-portal.card>

        <x-portal.card title="Units & results" :padding="false">
            <x-portal.table :headers="['Code', 'Unit', 'Term', 'Trainer', 'Mark', 'Grade']">
                @forelse ($units as $unit)
                    @php([$grade, $competency, $color] = \App\Models\AssessmentResult::grade($marks[$unit->id]))
                    <tr>
                        <td class="px-4 py-3 font-mono text-xs">{{ $unit->code }}</td>
                        <td class="px-4 py-3">{{ $unit->name }}</td>
                        <td class="px-4 py-3">{{ $unit->term_no }}</td>
                        <td class="px-4 py-3">{{ $unit->trainer?->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $marks[$unit->id] !== null ? $marks[$unit->id].'%' : '-' }}</td>
                        <td class="px-4 py-3"><x-portal.badge :color="$color">{{ $grade }}</x-portal.badge></td>
                    </tr>
                @empty
                    <tr><td colspan="6"><x-portal.empty message="No units set up for this course yet." /></td></tr>
                @endforelse
            </x-portal.table>
        </x-portal.card>
    </div>
</div>
@endsection
