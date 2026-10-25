@extends('layouts.portal')
@section('pageTitle', 'Receipt '.$payment->receipt_no)

@section('content')
<div class="no-print mb-4 flex gap-2">
    <x-portal.button type="button" onclick="window.print()" icon="fa-print">Print receipt</x-portal.button>
    <x-portal.button variant="secondary" :href="url()->previous()" icon="fa-arrow-left">Back</x-portal.button>
</div>
<x-portal.card class="max-w-2xl">
    <x-portal.print-header title="Official Receipt">
        <div class="font-mono text-sm">{{ $payment->receipt_no }}</div>
    </x-portal.print-header>
    <dl class="grid grid-cols-2 gap-y-3 text-sm">
        <dt class="text-slate-500">Date</dt><dd class="font-medium">{{ $payment->paid_on->format('d M Y') }}</dd>
        <dt class="text-slate-500">Received from</dt><dd class="font-medium">{{ $payment->student->full_name }}</dd>
        <dt class="text-slate-500">Admission No.</dt><dd class="font-medium font-mono">{{ $payment->student->admission_no }}</dd>
        <dt class="text-slate-500">Course</dt><dd class="font-medium">{{ $payment->student->course?->name }}</dd>
        <dt class="text-slate-500">Payment method</dt><dd class="font-medium">{{ \App\Models\Payment::METHODS[$payment->method] ?? $payment->method }}</dd>
        <dt class="text-slate-500">Transaction ref.</dt><dd class="font-medium font-mono">{{ $payment->reference ?? '-' }}</dd>
        @if ($payment->notes)<dt class="text-slate-500">Being payment for</dt><dd class="font-medium">{{ $payment->notes }}</dd>@endif
    </dl>
    <div class="mt-6 rounded-lg bg-primary text-white px-5 py-4 flex justify-between items-center">
        <span class="font-medium">AMOUNT RECEIVED</span>
        <span class="text-2xl font-bold">{{ money($payment->amount) }}</span>
    </div>
    <div class="mt-4 text-sm">Balance after this payment: <strong>{{ money($payment->student->balance) }}</strong> (as at {{ now()->format('d M Y') }})</div>
    <div class="mt-10 grid grid-cols-2 gap-8 text-sm">
        <div class="border-t border-slate-400 pt-2">Served by: {{ $payment->receiver?->name ?? '-' }}</div>
        <div class="border-t border-slate-400 pt-2">Signature &amp; stamp</div>
    </div>
</x-portal.card>
@endsection
