@extends('layouts.portal')
@section('pageTitle', 'Expense Approvals')

@section('content')
<x-portal.card :padding="false" :subtitle="'Pending total: '.money($pendingTotal)">
    <x-slot:actions>
        <div class="flex gap-1 text-sm">
            @foreach (['pending', 'approved', 'rejected', 'all'] as $option)
                <a href="{{ route('portal.director.expenses', ['status' => $option]) }}" class="px-3 py-1.5 rounded-lg {{ $status === $option ? 'bg-primary text-white' : 'hover:bg-slate-100' }}">{{ ucfirst($option) }}</a>
            @endforeach
        </div>
    </x-slot:actions>
    <x-portal.table :headers="['Date', 'Category', 'Description', 'Paid to', 'Recorded by', 'Amount', 'Decision']">
        @forelse ($expenses as $expense)
            <tr>
                <td class="px-4 py-3 whitespace-nowrap">{{ $expense->expense_date->format('d M Y') }}</td>
                <td class="px-4 py-3">{{ $expense->category?->name }}</td>
                <td class="px-4 py-3">{{ $expense->description }}<div class="text-xs text-slate-500">{{ \App\Models\Payment::METHODS[$expense->method] }} {{ $expense->reference }}</div></td>
                <td class="px-4 py-3">{{ $expense->payee ?? '-' }}</td>
                <td class="px-4 py-3">{{ $expense->recorder?->name }}</td>
                <td class="px-4 py-3 font-semibold whitespace-nowrap">{{ money($expense->amount) }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    @if ($expense->status === 'pending')
                        <form method="POST" action="{{ route('portal.director.expenses.decide', $expense) }}" class="flex gap-1">
                            @csrf @method('PATCH')
                            <x-portal.button size="sm" variant="success" name="decision" value="approved">Approve</x-portal.button>
                            <x-portal.button size="sm" variant="danger" name="decision" value="rejected">Reject</x-portal.button>
                        </form>
                    @else
                        <x-portal.badge :status="$expense->status" /> <span class="text-xs text-slate-500">{{ $expense->approved_at?->format('d M') }}</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7"><x-portal.empty icon="fa-file-signature" message="Nothing here." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $expenses->links() }}</div>
</x-portal.card>
@endsection
