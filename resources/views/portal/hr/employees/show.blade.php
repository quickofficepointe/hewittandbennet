@extends('layouts.portal')
@section('pageTitle', $employee->full_name)

@section('content')
<div class="flex flex-wrap gap-2 mb-6">
    <x-portal.button icon="fa-pen" :href="route('portal.hr.employees.edit', $employee)">Edit</x-portal.button>
    @unless ($employee->user_id)
        <form method="POST" action="{{ route('portal.hr.employees.account', $employee) }}" class="flex gap-2">
            @csrf
            <select name="portal_role" class="rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white" required>
                @foreach (\Illuminate\Support\Arr::only(\App\Models\User::ROLE_LABELS, [\App\Models\User::TRAINER, \App\Models\User::ADMIN, \App\Models\User::HR, \App\Models\User::ACCOUNTANT]) as $role => $label)
                    <option value="{{ $role }}">{{ $label }}</option>
                @endforeach
            </select>
            <x-portal.button variant="success" icon="fa-key">Create portal login</x-portal.button>
        </form>
    @endunless
    <form method="POST" action="{{ route('portal.hr.employees.destroy', $employee) }}" onsubmit="return confirm('Mark this employee as exited and archive the record?')">
        @csrf @method('DELETE')
        <x-portal.button variant="danger" icon="fa-box-archive">Exit &amp; archive</x-portal.button>
    </form>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card>
        <div class="text-center">
            <div class="h-24 w-24 rounded-full bg-primary text-white flex items-center justify-center text-3xl font-semibold mx-auto">{{ mb_substr($employee->first_name, 0, 1) }}{{ mb_substr($employee->last_name, 0, 1) }}</div>
            <div class="mt-3 font-semibold text-lg">{{ $employee->full_name }}</div>
            <div class="text-sm text-slate-500">{{ $employee->designation }}</div>
            <div class="mt-2"><x-portal.badge :status="$employee->status" /></div>
        </div>
        <dl class="mt-6 text-sm divide-y divide-slate-100">
            @foreach ([
                'Employee No.' => $employee->employee_no,
                'Department' => $employee->department?->name,
                'Campus' => $employee->campus?->name,
                'Type' => \App\Models\Employee::TYPES[$employee->employment_type],
                'Hired' => $employee->date_hired->format('d M Y').' ('.$employee->date_hired->diffForHumans(null, true).')',
                'Phone' => $employee->phone,
                'Email' => $employee->email,
                'ID No.' => $employee->id_number,
                'KRA PIN' => $employee->kra_pin,
                'NSSF / SHIF' => trim($employee->nssf_no.' / '.$employee->shif_no, ' /'),
                'Bank' => trim($employee->bank_name.' '.$employee->bank_account),
                'Next of kin' => trim($employee->next_of_kin.' '.$employee->next_of_kin_phone),
                'Portal login' => $employee->user ? $employee->user->username.' ('.$employee->user->role_label.')' : 'Not created',
            ] as $label => $value)
                <div class="flex justify-between gap-4 py-2"><dt class="text-slate-500">{{ $label }}</dt><dd class="font-medium text-right">{{ $value ?: '-' }}</dd></div>
            @endforeach
        </dl>
    </x-portal.card>

    <div class="lg:col-span-2 space-y-6">
        @php($deductions = \App\Support\KenyaPayroll::calculate($employee->gross_pay))
        <x-portal.card title="Monthly pay (estimate)">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div><div class="text-slate-500">Gross</div><div class="font-semibold text-lg">{{ money($employee->gross_pay) }}</div></div>
                <div><div class="text-slate-500">PAYE</div><div class="font-semibold">{{ money($deductions['paye']) }}</div></div>
                <div><div class="text-slate-500">NSSF + SHIF + Levy</div><div class="font-semibold">{{ money($deductions['nssf'] + $deductions['shif'] + $deductions['housing_levy']) }}</div></div>
                <div><div class="text-slate-500">Net</div><div class="font-semibold text-lg text-green-700">{{ money($employee->gross_pay - $deductions['total']) }}</div></div>
            </div>
        </x-portal.card>

        <x-portal.card title="Leave balances ({{ now()->year }})">
            <div class="grid gap-3 sm:grid-cols-3">
                @foreach ($balances as $balance)
                    <div class="rounded-lg border border-slate-200 p-3 text-sm">
                        <div class="text-slate-500">{{ $balance['type']->name }}</div>
                        <div class="font-semibold">{{ $balance['remaining'] }} / {{ $balance['type']->days_per_year }} days left</div>
                    </div>
                @endforeach
            </div>
        </x-portal.card>

        <x-portal.card title="Leave history" :padding="false">
            <x-portal.table :headers="['Type', 'Dates', 'Days', 'Status']">
                @forelse ($employee->leaveRequests->sortByDesc('start_date') as $request)
                    <tr>
                        <td class="px-4 py-2">{{ $request->type->name }}</td>
                        <td class="px-4 py-2">{{ $request->start_date->format('d M Y') }} - {{ $request->end_date->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $request->days }}</td>
                        <td class="px-4 py-2"><x-portal.badge :status="$request->status" /></td>
                    </tr>
                @empty
                    <tr><td colspan="4"><x-portal.empty message="No leave taken." /></td></tr>
                @endforelse
            </x-portal.table>
        </x-portal.card>

        <x-portal.card title="Recent payslips" :padding="false">
            <x-portal.table :headers="['Period', 'Gross', 'Net', 'Status', '']">
                @forelse ($payslips as $payslip)
                    <tr>
                        <td class="px-4 py-2">{{ $payslip->run->period_label }}</td>
                        <td class="px-4 py-2">{{ money($payslip->gross_pay) }}</td>
                        <td class="px-4 py-2">{{ money($payslip->net_pay) }}</td>
                        <td class="px-4 py-2"><x-portal.badge :status="$payslip->run->status" /></td>
                        <td class="px-4 py-2 text-right"><a href="{{ route('portal.payslips.show', $payslip) }}" class="text-xs text-primary hover:underline">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-portal.empty message="No payslips yet." /></td></tr>
                @endforelse
            </x-portal.table>
        </x-portal.card>
    </div>
</div>
@endsection
