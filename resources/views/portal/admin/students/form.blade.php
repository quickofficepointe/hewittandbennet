@extends('layouts.portal')
@section('pageTitle', $student->exists ? 'Edit Student' : 'Admit Student')

@section('content')
@if ($application)
    <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-blue-800 text-sm">
        <i class="fa-solid fa-inbox"></i> Admitting online applicant <strong>{{ $application->name }}</strong> (applied {{ $application->created_at->format('d M Y') }} for {{ $application->startMonth }} {{ $application->startYear }}).
    </div>
@endif

<form method="POST" enctype="multipart/form-data"
      action="{{ $student->exists ? route('portal.admin.students.update', $student) : route('portal.admin.students.store') }}" class="space-y-6">
    @csrf
    @if ($student->exists) @method('PUT') @endif
    @if ($application)<input type="hidden" name="application_id" value="{{ $application->id }}">@endif

    <x-portal.card title="Personal details">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <x-portal.input name="first_name" label="First name" :value="$student->first_name" required />
            <x-portal.input name="last_name" label="Last name" :value="$student->last_name" required />
            <x-portal.select name="gender" label="Gender" :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']" :value="$student->gender" placeholder="Select..." />
            <x-portal.input name="id_number" label="ID / Passport / Birth cert. no." :value="$student->id_number" />
            <x-portal.input name="date_of_birth" type="date" label="Date of birth" :value="$student->date_of_birth?->format('Y-m-d')" />
            <x-portal.input name="photo" type="file" label="Passport photo" accept="image/*" />
            <x-portal.input name="phone" label="Phone" :value="$student->phone" />
            <x-portal.input name="email" type="email" label="Email" :value="$student->email" />
            <x-portal.input name="address" label="Residence / address" :value="$student->address" />
        </div>
    </x-portal.card>

    <x-portal.card title="Guardian / next of kin">
        <div class="grid gap-4 sm:grid-cols-3">
            <x-portal.input name="guardian_name" label="Name" :value="$student->guardian_name" />
            <x-portal.input name="guardian_phone" label="Phone" :value="$student->guardian_phone" />
            <x-portal.input name="guardian_relationship" label="Relationship" :value="$student->guardian_relationship" />
        </div>
    </x-portal.card>

    <x-portal.card title="Academic details">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <x-portal.input name="admission_no" label="Admission number" :value="$student->admission_no" help="Leave blank to generate automatically (HBIC/{{ date('Y') }}/0001)." />
            <x-portal.select name="course_id" label="Course" :options="$courses" :value="$student->course_id" placeholder="Select course..." required />
            <x-portal.select name="intake_id" label="Intake" :options="$intakes" :value="$student->intake_id" placeholder="Select intake..." />
            <x-portal.select name="campus_id" label="Campus" :options="$campuses" :value="$student->campus_id" placeholder="Select campus..." />
            <x-portal.select name="mode_of_study" label="Mode of study" :options="['Full time' => 'Full time', 'Part time' => 'Part time', 'Evening' => 'Evening', 'Weekend' => 'Weekend', 'Online' => 'Online']" :value="$student->mode_of_study" required />
            <x-portal.input name="current_term" type="number" min="1" max="12" label="Current term" :value="$student->current_term" required />
            <x-portal.input name="admission_date" type="date" label="Admission date" :value="$student->admission_date?->format('Y-m-d')" required />
            <x-portal.select name="status" label="Status" :options="array_combine(\App\Models\Student::STATUSES, array_map('ucfirst', \App\Models\Student::STATUSES))" :value="$student->status" required />
        </div>
        @unless ($student->exists)
            <label class="mt-5 flex items-center gap-2 text-sm"><input type="checkbox" name="create_account" value="1" checked class="rounded"> Create a student portal login (username = admission number)</label>
        @endunless
    </x-portal.card>

    <div class="flex gap-2">
        <x-portal.button icon="fa-floppy-disk">{{ $student->exists ? 'Save changes' : 'Admit student' }}</x-portal.button>
        <x-portal.button variant="secondary" :href="$student->exists ? route('portal.admin.students.show', $student) : route('portal.admin.students.index')">Cancel</x-portal.button>
    </div>
</form>
@endsection
