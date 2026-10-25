@extends('layouts.portal')
@section('pageTitle', 'Statement - '.$student->full_name)

@section('content')
<div class="no-print mb-4 flex flex-wrap gap-2">
    <x-portal.button type="button" onclick="window.print()" icon="fa-print">Print statement</x-portal.button>
    <x-portal.button variant="success" icon="fa-cash-register" :href="route('portal.accounts.payments.create', ['student' => $student->id])">Receive payment</x-portal.button>
    <x-portal.button variant="secondary" icon="fa-arrow-left" :href="route('portal.accounts.balances')">Balances</x-portal.button>
</div>
<x-portal.card>
    @include('portal.partials.statement', ['student' => $student, 'lines' => $lines, 'receiptRoute' => 'portal.accounts.payments.receipt'])
</x-portal.card>
@endsection
