@extends('layouts.portal')
@section('pageTitle', 'Fee Structures')

@section('content')
<div class="grid gap-6 lg:grid-cols-4">
    <x-portal.card title="Courses" class="h-fit" :padding="false">
        <div class="divide-y divide-slate-100 text-sm">
            @foreach ($courses as $course)
                <a href="{{ route('portal.accounts.fees.index', ['course_id' => $course->id]) }}" class="flex justify-between px-4 py-2.5 {{ $selected?->id === $course->id ? 'bg-primary-50 text-primary font-medium' : 'hover:bg-slate-50' }}">
                    <span class="truncate pr-2">{{ $course->name }}</span><span class="text-xs text-slate-500">{{ $course->feeItems->count() }}</span>
                </a>
            @endforeach
        </div>
    </x-portal.card>

    @if ($selected)
        <div class="lg:col-span-3 space-y-6">
            <x-portal.card :title="$selected->name" :subtitle="$selected->total_terms.' term(s). Total programme cost: '.money($selected->feeItems->sum('amount'))" :padding="false">
                <x-portal.table :headers="['Item', 'Applies to', 'Amount', '']">
                    @forelse ($selected->feeItems as $item)
                        <tr>
                            <td class="px-4 py-2 font-medium">{{ $item->name }}</td>
                            <td class="px-4 py-2">{{ $item->term_no ? 'Term '.$item->term_no : 'Once (on admission)' }}</td>
                            <td class="px-4 py-2">{{ money($item->amount) }}</td>
                            <td class="px-4 py-2 text-right">
                                <form method="POST" action="{{ route('portal.accounts.fees.destroy', $item) }}" onsubmit="return confirm('Remove this fee item?')">@csrf @method('DELETE')<button class="text-slate-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4"><x-portal.empty message="No fee items yet for this course." /></td></tr>
                    @endforelse
                </x-portal.table>
                @if ($selected->school_fees || $selected->registration_fees)
                    <div class="px-5 py-3 text-xs text-slate-500 border-t border-slate-100">
                        Website lists: school fees {{ money($selected->school_fees) }}, registration {{ money($selected->registration_fees) }}, uniform {{ money($selected->school_uniform_fee) }}.
                    </div>
                @endif
            </x-portal.card>

            <x-portal.card title="Add fee item">
                <form method="POST" action="{{ route('portal.accounts.fees.store') }}" class="grid gap-3 sm:grid-cols-4 items-end">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $selected->id }}">
                    <x-portal.input name="name" label="Item" placeholder="e.g. Tuition" required />
                    <x-portal.input name="term_no" type="number" min="1" max="12" label="Term (blank = once-off)" />
                    <x-portal.input name="amount" type="number" step="0.01" min="0" label="Amount (KES)" required />
                    <x-portal.button icon="fa-plus">Add</x-portal.button>
                </form>
            </x-portal.card>
        </div>
    @else
        <x-portal.card class="lg:col-span-3"><x-portal.empty message="Add courses first (Administration &rarr; Courses)." /></x-portal.card>
    @endif
</div>
@endsection
