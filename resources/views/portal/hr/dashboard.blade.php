@extends('layouts.portal')
@section('pageTitle', 'Human Resource Dashboard')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <x-portal.stat label="Employees" :value="$stats['employees']" icon="fa-id-badge" :href="route('portal.hr.employees.index')" />
    <x-portal.stat label="On leave today" :value="$stats['onLeaveToday']" icon="fa-umbrella-beach" color="teal" />
    <x-portal.stat label="Pending leave requests" :value="$stats['pendingLeave']" icon="fa-hourglass-half" color="amber" :href="route('portal.hr.leave.index')" />
    <x-portal.stat label="Monthly gross payroll" :value="money($stats['monthlyPayroll'])" icon="fa-money-check-dollar" color="indigo" :href="route('portal.hr.payroll.index')" />
</div>

@if ($noLogin)
    <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-blue-800 text-sm">
        <i class="fa-solid fa-circle-info"></i> {{ $noLogin }} employee(s) do not have a portal login yet, so they cannot apply for leave or view payslips. Open their record to create one.
    </div>
@endif

<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Leave awaiting your decision" class="lg:col-span-2" :padding="false">
        <x-slot:actions><x-portal.button size="sm" variant="ghost" :href="route('portal.hr.leave.index')">Review all</x-portal.button></x-slot:actions>
        <x-portal.table :headers="['Employee', 'Type', 'Dates', 'Days', 'Applied']">
            @forelse ($pending as $request)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $request->employee?->full_name }}</td>
                    <td class="px-4 py-3">{{ $request->type->name }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $request->start_date->format('d M') }} - {{ $request->end_date->format('d M') }}</td>
                    <td class="px-4 py-3">{{ $request->days }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $request->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td colspan="5"><x-portal.empty icon="fa-check" message="No pending leave requests." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>

    <div class="space-y-6">
        <x-portal.card title="Latest payroll">
            @if ($latestRun)
                <div class="flex justify-between items-center">
                    <div><div class="font-semibold">{{ $latestRun->period_label }}</div><div class="text-sm text-slate-500">Net {{ money($latestRun->total_net) }}</div></div>
                    <x-portal.badge :status="$latestRun->status" />
                </div>
                <div class="mt-3"><x-portal.button size="sm" variant="secondary" :href="route('portal.hr.payroll.show', $latestRun)">Open</x-portal.button></div>
            @else
                <x-portal.empty message="No payroll run yet." />
            @endif
        </x-portal.card>
        <x-portal.card title="Recruitment">
            <div class="flex justify-between text-sm"><span>New job applications</span><span class="font-semibold">{{ $stats['newApplications'] }}</span></div>
            <div class="mt-3"><x-portal.button size="sm" variant="secondary" :href="route('portal.hr.applications.index', ['status' => 'new'])">Review</x-portal.button></div>
        </x-portal.card>
    </div>

    <x-portal.card title="Staff by department">
        @foreach ($byDepartment as $name => $count)
            <div class="flex justify-between text-sm py-1.5 {{ ! $loop->last ? 'border-b border-slate-100' : '' }}"><span>{{ $name }}</span><span class="font-medium">{{ $count }}</span></div>
        @endforeach
        @if ($byDepartment->isEmpty())<x-portal.empty message="No employees yet." />@endif
    </x-portal.card>
    <x-portal.card title="Staff by employment type">
        @foreach (\App\Models\Employee::TYPES as $key => $label)
            <div class="flex justify-between text-sm py-1.5 border-b border-slate-100 last:border-0"><span>{{ $label }}</span><span class="font-medium">{{ $byType[$key] ?? 0 }}</span></div>
        @endforeach
    </x-portal.card>
</div>
@endsection
