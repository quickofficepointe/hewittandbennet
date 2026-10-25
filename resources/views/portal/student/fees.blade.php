@extends('layouts.portal')
@section('pageTitle', 'Fee Statement')

@section('content')
@php($balance = $lines->last()['balance'] ?? 0)
<div class="grid gap-4 sm:grid-cols-3 mb-6 no-print">
    <x-portal.stat label="Total billed" :value="money($lines->sum('debit'))" icon="fa-file-invoice" color="indigo" />
    <x-portal.stat label="Total paid" :value="money($lines->sum('credit'))" icon="fa-money-bill" color="green" />
    <x-portal.stat label="Balance" :value="money($balance)" icon="fa-scale-unbalanced" :color="$balance > 0 ? 'red' : 'green'" :hint="$balance < 0 ? 'You have a credit (overpayment)' : null" />
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card class="lg:col-span-2">
        <x-slot:actions><x-portal.button size="sm" variant="secondary" type="button" onclick="window.print()" icon="fa-print">Print statement</x-portal.button></x-slot:actions>
        @include('portal.partials.statement', ['student' => $student, 'lines' => $lines, 'receiptRoute' => 'portal.student.fees.receipt'])
    </x-portal.card>

    <div class="space-y-6 no-print">
        <x-portal.card title="How to pay">
            <div class="text-sm space-y-2">
                <p><strong>M-Pesa Paybill:</strong> ask the accounts office for the paybill number. Use your admission number <span class="font-mono">{{ $student->admission_no }}</span> as the account number.</p>
                <p><strong>Bank deposit / cash:</strong> pay at the accounts office and collect an official receipt.</p>
                <p class="text-xs text-slate-500">Payments appear here once recorded by the accounts office.</p>
            </div>
        </x-portal.card>
        <x-portal.card title="Fee structure - {{ $student->course?->name }}">
            @forelse ($feeItems as $item)
                <div class="flex justify-between text-sm py-1.5 {{ ! $loop->last ? 'border-b border-slate-100' : '' }}">
                    <span>{{ $item->name }} <span class="text-xs text-slate-500">{{ $item->term_no ? '(Term '.$item->term_no.')' : '(once)' }}</span></span>
                    <span class="font-medium">{{ money($item->amount) }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-500">Fee structure not published yet.</p>
            @endforelse
        </x-portal.card>
    </div>
</div>
@endsection
