@extends('layouts.portal')
@section('pageTitle', 'Payslip - '.$payslip->run->period_label)

@section('content')
<div class="no-print mb-4 flex gap-2">
    <x-portal.button type="button" onclick="window.print()" icon="fa-print">Print payslip</x-portal.button>
    <x-portal.button variant="secondary" :href="url()->previous()" icon="fa-arrow-left">Back</x-portal.button>
</div>
<x-portal.card class="max-w-3xl">
    <x-portal.print-header title="Payslip">
        <div class="text-sm text-slate-600">{{ $payslip->run->period_label }}</div>
    </x-portal.print-header>

    <div class="grid grid-cols-2 gap-4 text-sm mb-6">
        <div>
            <div class="text-slate-500">Employee</div>
            <div class="font-semibold">{{ $payslip->employee->full_name }}</div>
            <div>{{ $payslip->employee->employee_no }} &middot; {{ $payslip->employee->designation }}</div>
            <div>{{ $payslip->employee->department?->name }}</div>
        </div>
        <div class="text-right">
            <div>KRA PIN: <span class="font-medium">{{ $payslip->employee->kra_pin ?? '-' }}</span></div>
            <div>NSSF No: <span class="font-medium">{{ $payslip->employee->nssf_no ?? '-' }}</span></div>
            <div>SHIF No: <span class="font-medium">{{ $payslip->employee->shif_no ?? '-' }}</span></div>
            <div>Bank: <span class="font-medium">{{ $payslip->employee->bank_name ?? '-' }} {{ $payslip->employee->bank_account }}</span></div>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-6 text-sm">
        <table class="w-full">
            <tr class="bg-slate-50"><th class="text-left px-3 py-2" colspan="2">Earnings</th></tr>
            <tr><td class="px-3 py-1.5">Basic salary</td><td class="px-3 py-1.5 text-right">{{ money($payslip->basic_salary, false) }}</td></tr>
            <tr><td class="px-3 py-1.5">House allowance</td><td class="px-3 py-1.5 text-right">{{ money($payslip->house_allowance, false) }}</td></tr>
            <tr><td class="px-3 py-1.5">Other allowances</td><td class="px-3 py-1.5 text-right">{{ money($payslip->other_allowances, false) }}</td></tr>
            <tr class="border-t font-semibold"><td class="px-3 py-2">Gross pay</td><td class="px-3 py-2 text-right">{{ money($payslip->gross_pay, false) }}</td></tr>
        </table>
        <table class="w-full">
            <tr class="bg-slate-50"><th class="text-left px-3 py-2" colspan="2">Deductions</th></tr>
            <tr><td class="px-3 py-1.5">PAYE</td><td class="px-3 py-1.5 text-right">{{ money($payslip->paye, false) }}</td></tr>
            <tr><td class="px-3 py-1.5">NSSF</td><td class="px-3 py-1.5 text-right">{{ money($payslip->nssf, false) }}</td></tr>
            <tr><td class="px-3 py-1.5">SHIF</td><td class="px-3 py-1.5 text-right">{{ money($payslip->shif, false) }}</td></tr>
            <tr><td class="px-3 py-1.5">Housing levy</td><td class="px-3 py-1.5 text-right">{{ money($payslip->housing_levy, false) }}</td></tr>
            <tr><td class="px-3 py-1.5">Other deductions</td><td class="px-3 py-1.5 text-right">{{ money($payslip->other_deductions, false) }}</td></tr>
            <tr class="border-t font-semibold"><td class="px-3 py-2">Total deductions</td><td class="px-3 py-2 text-right">{{ money($payslip->total_deductions, false) }}</td></tr>
        </table>
    </div>

    <div class="mt-6 rounded-lg bg-primary text-white px-5 py-4 flex justify-between items-center">
        <span class="font-medium">NET PAY</span>
        <span class="text-2xl font-bold">{{ money($payslip->net_pay) }}</span>
    </div>
    <p class="mt-4 text-xs text-slate-400">Payroll status: {{ ucfirst($payslip->run->status) }}. This is a computer-generated payslip.</p>
</x-portal.card>
@endsection
