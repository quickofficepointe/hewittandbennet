@extends('layouts.portal')
@section('pageTitle', $employee->exists ? 'Edit Employee' : 'Add Employee')

@section('content')
<form method="POST" action="{{ $employee->exists ? route('portal.hr.employees.update', $employee) : route('portal.hr.employees.store') }}" class="space-y-6">
    @csrf
    @if ($employee->exists) @method('PUT') @endif

    <x-portal.card title="Personal details">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <x-portal.input name="first_name" label="First name" :value="$employee->first_name" required />
            <x-portal.input name="last_name" label="Last name" :value="$employee->last_name" required />
            <x-portal.select name="gender" label="Gender" :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']" :value="$employee->gender" placeholder="Select..." />
            <x-portal.input name="id_number" label="National ID / Passport" :value="$employee->id_number" />
            <x-portal.input name="date_of_birth" type="date" label="Date of birth" :value="$employee->date_of_birth?->format('Y-m-d')" />
            <x-portal.input name="phone" label="Phone" :value="$employee->phone" />
            <x-portal.input name="email" type="email" label="Email" :value="$employee->email" />
            <x-portal.input name="next_of_kin" label="Next of kin" :value="$employee->next_of_kin" />
            <x-portal.input name="next_of_kin_phone" label="Next of kin phone" :value="$employee->next_of_kin_phone" />
        </div>
    </x-portal.card>

    <x-portal.card title="Employment">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <x-portal.input name="employee_no" label="Employee number" :value="$employee->employee_no" help="Leave blank to generate automatically." />
            <x-portal.input name="designation" label="Designation / job title" :value="$employee->designation" placeholder="e.g. Nursing Trainer" required />
            <x-portal.select name="department_id" label="Department" :options="$departments" :value="$employee->department_id" placeholder="Select..." />
            <x-portal.select name="campus_id" label="Campus" :options="$campuses" :value="$employee->campus_id" placeholder="Select..." />
            <x-portal.select name="employment_type" label="Employment type" :options="\App\Models\Employee::TYPES" :value="$employee->employment_type" required />
            <x-portal.input name="date_hired" type="date" label="Date hired" :value="$employee->date_hired?->format('Y-m-d')" required />
            <x-portal.select name="status" label="Status" :options="collect(\App\Models\Employee::STATUSES)->mapWithKeys(fn ($s) => [$s => ucwords(str_replace('_', ' ', $s))])" :value="$employee->status" required />
            @unless ($employee->exists)
                <x-portal.select name="portal_role" label="Create portal login as" :options="$roles" placeholder="Do not create a login" />
            @endunless
        </div>
    </x-portal.card>

    <x-portal.card title="Pay & statutory details" subtitle="Monthly amounts in KES. PAYE, NSSF, SHIF and Housing Levy are calculated automatically at payroll.">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <x-portal.input name="basic_salary" type="number" step="0.01" label="Basic salary" :value="$employee->basic_salary" required />
            <x-portal.input name="house_allowance" type="number" step="0.01" label="House allowance" :value="$employee->house_allowance" />
            <x-portal.input name="other_allowances" type="number" step="0.01" label="Other allowances" :value="$employee->other_allowances" />
            <x-portal.input name="kra_pin" label="KRA PIN" :value="$employee->kra_pin" />
            <x-portal.input name="nssf_no" label="NSSF number" :value="$employee->nssf_no" />
            <x-portal.input name="shif_no" label="SHIF number" :value="$employee->shif_no" />
            <x-portal.input name="bank_name" label="Bank" :value="$employee->bank_name" />
            <x-portal.input name="bank_account" label="Account number" :value="$employee->bank_account" />
        </div>
    </x-portal.card>

    <div class="flex gap-2">
        <x-portal.button icon="fa-floppy-disk">Save employee</x-portal.button>
        <x-portal.button variant="secondary" :href="$employee->exists ? route('portal.hr.employees.show', $employee) : route('portal.hr.employees.index')">Cancel</x-portal.button>
    </div>
</form>
@endsection
