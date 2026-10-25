@extends('layouts.portal')
@section('pageTitle', 'Payroll')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Generate monthly payroll" class="h-fit" subtitle="Creates a draft payslip for every active employee from their current salary.">
        <form method="POST" action="{{ route('portal.hr.payroll.store') }}" class="space-y-4">
            @csrf
            <x-portal.input name="period" type="month" label="Pay period" :value="now()->format('Y-m')" required />
            <p class="text-xs text-slate-500">{{ $activeEmployees }} active employee(s). Workflow: HR prepares a draft, the Director approves it, then Accounts marks it paid.</p>
            <x-portal.button icon="fa-gears">Generate draft</x-portal.button>
        </form>
    </x-portal.card>

    <x-portal.card title="Payroll runs" class="lg:col-span-2" :padding="false">
        <x-portal.table :headers="['Period', 'Employees', 'Gross', 'Deductions', 'Net', 'Status', '']">
            @forelse ($runs as $run)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-medium">{{ $run->period_label }}</td>
                    <td class="px-4 py-3">{{ $run->payslips_count }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ money($run->total_gross) }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-red-600">{{ money($run->total_deductions) }}</td>
                    <td class="px-4 py-3 whitespace-nowrap font-semibold">{{ money($run->total_net) }}</td>
                    <td class="px-4 py-3"><x-portal.badge :status="$run->status" /></td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('portal.hr.payroll.show', $run) }}" class="text-xs text-primary hover:underline">Open</a></td>
                </tr>
            @empty
                <tr><td colspan="7"><x-portal.empty icon="fa-money-check-dollar" message="No payroll has been run yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>
</div>
@endsection
