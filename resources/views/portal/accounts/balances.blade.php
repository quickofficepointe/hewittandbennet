@extends('layouts.portal')
@section('pageTitle', 'Student Balances')

@section('content')
<x-portal.card :padding="false">
    <x-slot:actions>
        <form method="GET" class="flex flex-wrap gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Name or admission no." class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm">
            <select name="course_id" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="">All courses</option>
                @foreach ($courses as $id => $name)<option value="{{ $id }}" @selected(request('course_id') == $id)>{{ $name }}</option>@endforeach
            </select>
            <select name="filter" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                @foreach (['owing' => 'With balance (defaulters)', 'cleared' => 'Cleared / in credit', 'all' => 'Everyone'] as $key => $label)
                    <option value="{{ $key }}" @selected(request('filter', 'owing') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="status" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="active" @selected(request('status', 'active') === 'active')>Active students</option>
                <option value="all" @selected(request('status') === 'all')>All statuses</option>
            </select>
            <input name="min" type="number" value="{{ request('min') }}" placeholder="Min. balance" class="w-32 rounded-lg border border-slate-300 px-3 py-1.5 text-sm">
            <x-portal.button size="sm" variant="secondary" icon="fa-filter">Filter</x-portal.button>
        </form>
    </x-slot:actions>
    <div class="px-5 py-3 text-sm bg-slate-50 border-b border-slate-100">{{ $students->count() }} student(s) &middot; Total outstanding: <strong class="text-red-600">{{ money($students->sum(fn ($s) => max(0, $s->outstanding))) }}</strong></div>
    <x-portal.table :headers="['Admission No.', 'Student', 'Course', 'Phone', 'Billed', 'Paid', 'Balance', '']" :datatable="true">
        @foreach ($students as $student)
            <tr>
                <td class="px-4 py-2 font-mono text-xs">{{ $student->admission_no }}</td>
                <td class="px-4 py-2">{{ $student->full_name }}</td>
                <td class="px-4 py-2">{{ $student->course?->name }}</td>
                <td class="px-4 py-2 whitespace-nowrap">{{ $student->phone }}</td>
                <td class="px-4 py-2 text-right whitespace-nowrap">{{ money($student->billed, false) }}</td>
                <td class="px-4 py-2 text-right whitespace-nowrap">{{ money($student->paid, false) }}</td>
                <td class="px-4 py-2 text-right whitespace-nowrap font-semibold {{ $student->outstanding > 0 ? 'text-red-600' : 'text-green-600' }}">{{ money($student->outstanding, false) }}</td>
                <td class="px-4 py-2 text-right whitespace-nowrap">
                    <a href="{{ route('portal.accounts.balances.statement', $student) }}" class="text-xs text-primary hover:underline mr-2">Statement</a>
                    <a href="{{ route('portal.accounts.payments.create', ['student' => $student->id]) }}" class="text-xs text-green-700 hover:underline">Pay</a>
                </td>
            </tr>
        @endforeach
    </x-portal.table>
    @if ($students->isEmpty())<x-portal.empty message="No students match these filters." />@endif
</x-portal.card>
@endsection
