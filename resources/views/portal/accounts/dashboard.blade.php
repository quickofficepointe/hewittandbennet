@extends('layouts.portal')
@section('pageTitle', 'Accounts Dashboard')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <x-portal.stat label="Collected today" :value="money($stats['today'])" icon="fa-cash-register" color="green" :href="route('portal.accounts.payments.index', ['from' => today()->format('Y-m-d')])" />
    <x-portal.stat label="Collected this month" :value="money($stats['month'])" icon="fa-calendar" color="teal" />
    <x-portal.stat label="Outstanding fees" :value="money($stats['outstanding'])" icon="fa-scale-unbalanced" color="red" :href="route('portal.accounts.balances')" />
    <x-portal.stat label="Expenses this month" :value="money($stats['expensesMonth'])" icon="fa-money-bill-transfer" color="amber" :href="route('portal.accounts.expenses.index')"
                   :hint="$stats['pendingExpenses'] ? $stats['pendingExpenses'].' awaiting Director approval' : null" />
</div>

<div class="flex flex-wrap gap-2 mb-6">
    <x-portal.button icon="fa-cash-register" :href="route('portal.accounts.payments.create')">Receive payment</x-portal.button>
    <x-portal.button variant="secondary" icon="fa-file-invoice" :href="route('portal.accounts.invoices.index')">Bill students</x-portal.button>
    <x-portal.button variant="secondary" icon="fa-money-bill-transfer" :href="route('portal.accounts.expenses.index')">Record expense</x-portal.button>
</div>

@foreach ($payrollToPay as $run)
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800 text-sm flex justify-between items-center">
        <span><i class="fa-solid fa-circle-check"></i> Payroll for <strong>{{ $run->period_label }}</strong> ({{ money($run->total_net) }} net) has been approved and is ready for payment.</span>
        <a href="{{ route('portal.accounts.payroll.show', $run) }}" class="font-medium underline">Open</a>
    </div>
@endforeach

<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Income vs expenditure {{ now()->year }}" class="lg:col-span-2">
        <canvas id="monthly" height="110"></canvas>
    </x-portal.card>

    <x-portal.card title="This month by method">
        @forelse (\App\Models\Payment::METHODS as $key => $label)
            @continue(! isset($byMethod[$key]))
            <div class="flex justify-between text-sm py-2 border-b border-slate-100 last:border-0"><span>{{ $label }}</span><span class="font-medium">{{ money($byMethod[$key]) }}</span></div>
        @empty
        @endforelse
        @if ($byMethod->isEmpty())<x-portal.empty message="No payments this month." />@endif
        <div class="mt-4 pt-4 border-t border-slate-200 text-sm">
            <div class="flex justify-between"><span class="text-slate-500">Billed {{ now()->year }}</span><span class="font-medium">{{ money($stats['billedYear']) }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Collected {{ now()->year }}</span><span class="font-medium">{{ money($stats['collectedYear']) }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Collection rate</span><span class="font-medium">{{ $stats['billedYear'] > 0 ? round($stats['collectedYear'] / $stats['billedYear'] * 100) : 0 }}%</span></div>
        </div>
    </x-portal.card>

    <x-portal.card title="Latest payments" class="lg:col-span-3" :padding="false">
        <x-portal.table :headers="['Receipt', 'Date', 'Student', 'Method', 'Reference', 'Amount']">
            @forelse ($recentPayments as $payment)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-mono text-xs"><a class="text-primary hover:underline" href="{{ route('portal.accounts.payments.receipt', $payment) }}">{{ $payment->receipt_no }}</a></td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $payment->paid_on->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $payment->student?->full_name }} <span class="text-xs text-slate-500">{{ $payment->student?->admission_no }}</span></td>
                    <td class="px-4 py-3">{{ \App\Models\Payment::METHODS[$payment->method] }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $payment->reference ?? '-' }}</td>
                    <td class="px-4 py-3 font-medium whitespace-nowrap">{{ money($payment->amount) }}</td>
                </tr>
            @empty
                <tr><td colspan="6"><x-portal.empty message="No payments recorded yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>
</div>
@endsection

@push('scripts')
@include('portal.partials.finance-chart', ['canvas' => 'monthly', 'monthly' => $monthly])
@endpush
