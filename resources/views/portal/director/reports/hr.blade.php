@extends('layouts.portal')
@section('pageTitle', 'HR Report')

@section('content')
<div class="no-print mb-4"><x-portal.button variant="secondary" type="button" onclick="window.print()" icon="fa-print">Print</x-portal.button></div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <x-portal.stat label="Headcount" :value="$headcount" icon="fa-people-group" />
    <x-portal.stat label="Monthly gross wage bill" :value="money($monthlyCost)" icon="fa-money-check-dollar" color="indigo" />
    <x-portal.stat label="On leave today" :value="$onLeave->count()" icon="fa-umbrella-beach" color="teal" />
    <x-portal.stat label="Leave days taken {{ now()->year }}" :value="$leaveDaysYear" icon="fa-calendar-minus" color="amber" />
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <x-portal.card title="By department" :padding="false">
        <x-portal.table :headers="['Department', 'Staff', 'Monthly gross']">
            @forelse ($byDepartment as $name => $row)
                <tr><td class="px-4 py-2">{{ $name }}</td><td class="px-4 py-2">{{ $row['count'] }}</td><td class="px-4 py-2">{{ money($row['cost']) }}</td></tr>
            @empty
                <tr><td colspan="3"><x-portal.empty message="No employees yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>

    <x-portal.card title="Payroll history" :padding="false">
        <x-portal.table :headers="['Period', 'Gross', 'Net', 'Status']">
            @forelse ($payrollRuns as $run)
                <tr><td class="px-4 py-2">{{ $run->period_label }}</td><td class="px-4 py-2">{{ money($run->total_gross) }}</td><td class="px-4 py-2">{{ money($run->total_net) }}</td><td class="px-4 py-2"><x-portal.badge :status="$run->status" /></td></tr>
            @empty
                <tr><td colspan="4"><x-portal.empty message="No payroll yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>

    <x-portal.card title="Currently on leave">
        @forelse ($onLeave as $leave)
            <div class="flex justify-between text-sm py-1.5 border-b border-slate-100 last:border-0">
                <span>{{ $leave->employee?->full_name }} <span class="text-slate-500">({{ $leave->type->name }})</span></span>
                <span>back {{ $leave->end_date->copy()->addDay()->format('d M') }}</span>
            </div>
        @empty
            <x-portal.empty message="Nobody is on leave today." />
        @endforelse
    </x-portal.card>

    <x-portal.card title="Employment mix & recent hires">
        @foreach (\App\Models\Employee::TYPES as $key => $label)
            <div class="flex justify-between text-sm py-1"><span>{{ $label }}</span><span class="font-medium">{{ $byType[$key] ?? 0 }}</span></div>
        @endforeach
        <div class="mt-4 pt-3 border-t border-slate-200 text-xs font-semibold uppercase text-slate-500 mb-2">Recent hires</div>
        @foreach ($recentHires as $employee)
            <div class="flex justify-between text-sm py-1"><span>{{ $employee->full_name }} <span class="text-slate-500">- {{ $employee->designation }}</span></span><span>{{ $employee->date_hired->format('M Y') }}</span></div>
        @endforeach
    </x-portal.card>
</div>
@endsection
