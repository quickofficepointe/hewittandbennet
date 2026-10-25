{{-- Shared payroll register. $context: hr | director | accounts --}}
@extends('layouts.portal')
@section('pageTitle', 'Payroll - '.$run->period_label)

@section('content')
@php($editable = $context === 'hr' && $run->status === 'draft')
<div class="no-print flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="text-sm text-slate-600 space-x-2">
        <x-portal.badge :status="$run->status" />
        <span>Prepared by {{ $run->preparer?->name ?? '-' }}</span>
        @if ($run->approver)<span>&middot; Approved by {{ $run->approver->name }} {{ $run->approved_at?->format('d M Y') }}</span>@endif
        @if ($run->payer)<span>&middot; Paid by {{ $run->payer->name }} {{ $run->paid_at?->format('d M Y') }}</span>@endif
    </div>
    <div class="flex flex-wrap gap-2">
        <x-portal.button variant="secondary" type="button" onclick="window.print()" icon="fa-print">Print register</x-portal.button>
        @if ($editable)
            <form method="POST" action="{{ route('portal.hr.payroll.update', $run) }}" onsubmit="return confirm('Rebuild all payslips from current salaries? Other deductions will be cleared.')">
                @csrf @method('PUT')
                <input type="hidden" name="regenerate" value="1">
                <x-portal.button variant="secondary" icon="fa-rotate">Regenerate</x-portal.button>
            </form>
            <form method="POST" action="{{ route('portal.hr.payroll.destroy', $run) }}" onsubmit="return confirm('Delete this draft payroll?')">
                @csrf @method('DELETE')
                <x-portal.button variant="danger" icon="fa-trash">Delete draft</x-portal.button>
            </form>
        @endif
        @if ($context === 'director' && $run->status === 'draft')
            <form method="POST" action="{{ route('portal.director.payroll.approve', $run) }}" onsubmit="return confirm('Approve this payroll for payment?')">
                @csrf @method('PATCH')
                <x-portal.button variant="success" icon="fa-check">Approve payroll</x-portal.button>
            </form>
        @endif
        @if ($context === 'accounts' && $run->status === 'approved')
            <form method="POST" action="{{ route('portal.accounts.payroll.paid', $run) }}" onsubmit="return confirm('Confirm salaries have been paid?')">
                @csrf @method('PATCH')
                <x-portal.button variant="success" icon="fa-money-bill-transfer">Mark as paid</x-portal.button>
            </form>
        @endif
    </div>
</div>

<div class="grid gap-4 sm:grid-cols-3 mb-6">
    <x-portal.stat label="Gross pay" :value="money($run->total_gross)" icon="fa-coins" color="indigo" />
    <x-portal.stat label="Total deductions" :value="money($run->total_deductions)" icon="fa-minus" color="red" />
    <x-portal.stat label="Net pay" :value="money($run->total_net)" icon="fa-wallet" color="green" />
</div>

<x-portal.card :padding="false">
    <div class="hidden print:block p-5"><x-portal.print-header title="Payroll Register"><div class="text-sm">{{ $run->period_label }}</div></x-portal.print-header></div>
    <form method="POST" action="{{ $editable ? route('portal.hr.payroll.update', $run) : '#' }}">
        @csrf @method('PUT')
        <x-portal.table :headers="['Employee', 'Basic', 'Allowances', 'Gross', 'PAYE', 'NSSF', 'SHIF', 'Housing', 'Other ded.', 'Net', '']">
            @foreach ($run->payslips as $payslip)
                <tr>
                    <td class="px-4 py-2"><div class="font-medium whitespace-nowrap">{{ $payslip->employee->full_name }}</div><div class="text-xs text-slate-500">{{ $payslip->employee->employee_no }}</div></td>
                    <td class="px-4 py-2 text-right">{{ money($payslip->basic_salary, false) }}</td>
                    <td class="px-4 py-2 text-right">{{ money($payslip->house_allowance + $payslip->other_allowances, false) }}</td>
                    <td class="px-4 py-2 text-right font-medium">{{ money($payslip->gross_pay, false) }}</td>
                    <td class="px-4 py-2 text-right">{{ money($payslip->paye, false) }}</td>
                    <td class="px-4 py-2 text-right">{{ money($payslip->nssf, false) }}</td>
                    <td class="px-4 py-2 text-right">{{ money($payslip->shif, false) }}</td>
                    <td class="px-4 py-2 text-right">{{ money($payslip->housing_levy, false) }}</td>
                    <td class="px-4 py-2 text-right">
                        @if ($editable)
                            <input type="number" step="0.01" min="0" name="other_deductions[{{ $payslip->id }}]" value="{{ (float) $payslip->other_deductions }}" class="w-24 rounded border border-slate-300 px-2 py-1 text-right">
                        @else
                            {{ money($payslip->other_deductions, false) }}
                        @endif
                    </td>
                    <td class="px-4 py-2 text-right font-semibold">{{ money($payslip->net_pay, false) }}</td>
                    <td class="px-4 py-2 text-right no-print"><a href="{{ route('portal.payslips.show', $payslip) }}" class="text-xs text-primary hover:underline">Payslip</a></td>
                </tr>
            @endforeach
        </x-portal.table>
        @if ($run->payslips->isEmpty())<x-portal.empty message="No employees with a salary were found for this run." />@endif
        @if ($editable && $run->payslips->isNotEmpty())
            <div class="p-5 no-print"><x-portal.button icon="fa-floppy-disk">Save other deductions</x-portal.button>
                <span class="text-xs text-slate-500 ml-2">Use for loans, salary advances and similar. The Director approves the run from their Approvals page.</span>
            </div>
        @endif
    </form>
</x-portal.card>
@endsection
