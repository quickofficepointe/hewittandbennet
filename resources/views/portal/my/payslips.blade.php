@extends('layouts.portal')
@section('pageTitle', 'My Payslips')

@section('content')
<x-portal.card title="Payslips" subtitle="Payslips appear here once the Director approves the month's payroll." :padding="false">
    @if (! $employee)
        <x-portal.empty icon="fa-id-badge" message="You do not have an employee record yet. Please contact HR." />
    @else
        <x-portal.table :headers="['Period', 'Gross pay', 'Deductions', 'Net pay', 'Status', '']">
            @forelse ($payslips as $payslip)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $payslip->run->period_label }}</td>
                    <td class="px-4 py-3">{{ money($payslip->gross_pay) }}</td>
                    <td class="px-4 py-3 text-red-600">{{ money($payslip->total_deductions) }}</td>
                    <td class="px-4 py-3 font-semibold">{{ money($payslip->net_pay) }}</td>
                    <td class="px-4 py-3"><x-portal.badge :status="$payslip->run->status" /></td>
                    <td class="px-4 py-3 text-right"><x-portal.button size="sm" variant="secondary" icon="fa-print" :href="route('portal.payslips.show', $payslip)">View</x-portal.button></td>
                </tr>
            @empty
                <tr><td colspan="6"><x-portal.empty message="No payslips yet." /></td></tr>
            @endforelse
        </x-portal.table>
    @endif
</x-portal.card>
@endsection
