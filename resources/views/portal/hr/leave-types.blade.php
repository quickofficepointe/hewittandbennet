@extends('layouts.portal')
@section('pageTitle', 'Leave Types')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Add leave type" class="h-fit">
        <form method="POST" action="{{ route('portal.hr.leave-types.store') }}" class="space-y-4">
            @csrf
            <x-portal.input name="name" label="Name" placeholder="e.g. Annual Leave" required />
            <x-portal.input name="days_per_year" type="number" label="Days per year" required />
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_paid" value="1" checked class="rounded"> Paid leave</label>
            <x-portal.button icon="fa-plus">Add</x-portal.button>
        </form>
    </x-portal.card>
    <x-portal.card title="Leave types" class="lg:col-span-2" :padding="false" subtitle="Kenyan Employment Act minimums: 21 days annual, 90 days maternity, 14 days paternity, 7 days sick (full pay).">
        <x-portal.table :headers="['Name', 'Days / year', 'Paid', '']">
            @forelse ($types as $type)
                @php($formId = 'leave-type-'.$type->id)
                <tr>
                    <td class="px-4 py-2"><input form="{{ $formId }}" name="name" value="{{ $type->name }}" class="rounded border border-slate-300 px-2 py-1 w-full"></td>
                    <td class="px-4 py-2"><input form="{{ $formId }}" name="days_per_year" type="number" value="{{ $type->days_per_year }}" class="rounded border border-slate-300 px-2 py-1 w-24"></td>
                    <td class="px-4 py-2"><input form="{{ $formId }}" type="checkbox" name="is_paid" value="1" @checked($type->is_paid) class="rounded"></td>
                    <td class="px-4 py-2 text-right whitespace-nowrap">
                        <form id="{{ $formId }}" method="POST" action="{{ route('portal.hr.leave-types.update', $type) }}" class="inline">
                            @csrf @method('PUT')
                            <button class="text-xs text-primary hover:underline mr-3">Save</button>
                        </form>
                        <form method="POST" action="{{ route('portal.hr.leave-types.destroy', $type) }}" class="inline" onsubmit="return confirm('Delete this leave type?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4"><x-portal.empty message="No leave types yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>
</div>
@endsection
