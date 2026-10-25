@extends('layouts.portal')
@section('pageTitle', 'Administration Dashboard')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <x-portal.stat label="Active students" :value="number_format($stats['students'])" icon="fa-user-graduate" :href="route('portal.admin.students.index')" />
    <x-portal.stat label="Pending applications" :value="$stats['applications']" icon="fa-inbox" color="amber" :href="route('portal.admin.applications.index', ['status' => 'pending'])" />
    <x-portal.stat label="Courses / Units" :value="$stats['courses'].' / '.$stats['units']" icon="fa-book" color="indigo" :href="route('portal.admin.units.index')"
                   :hint="$stats['unassignedUnits'] ? $stats['unassignedUnits'].' unit(s) without a trainer' : 'All units have trainers'" />
    <x-portal.stat label="Active trainers" :value="$stats['trainers']" icon="fa-chalkboard-user" color="teal" :href="route('portal.admin.users.index', ['role' => \App\Models\User::TRAINER])" />
</div>

@if (! $term)
    <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800 text-sm">
        <i class="fa-solid fa-triangle-exclamation"></i> No current academic term is set. <a href="{{ route('portal.admin.setup.index') }}" class="underline font-medium">Set up terms &amp; intakes</a>.
    </div>
@endif

<div class="grid gap-6 lg:grid-cols-2">
    <x-portal.card title="Latest online applications" :padding="false">
        <x-slot:actions><x-portal.button size="sm" variant="ghost" :href="route('portal.admin.applications.index')">View all</x-portal.button></x-slot:actions>
        <x-portal.table :headers="['Applicant', 'Course', 'Received', 'Status']">
            @forelse ($recentApplications as $application)
                <tr>
                    <td class="px-4 py-3"><div class="font-medium">{{ $application->name }}</div><div class="text-xs text-slate-500">{{ $application->phoneNumber }}</div></td>
                    <td class="px-4 py-3">{{ $application->course?->name }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $application->created_at->diffForHumans() }}</td>
                    <td class="px-4 py-3"><x-portal.badge :status="$application->status ?? 'pending'" /></td>
                </tr>
            @empty
                <tr><td colspan="4"><x-portal.empty message="No applications yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>

    <x-portal.card title="Active students per course">
        @forelse ($byCourse as $course)
            @php($max = max(1, $byCourse->max('students_count')))
            <div class="mb-3">
                <div class="flex justify-between text-sm mb-1"><span class="truncate pr-4">{{ $course->name }}</span><span class="font-medium">{{ $course->students_count }}</span></div>
                <div class="h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full bg-primary" style="width: {{ $course->students_count / $max * 100 }}%"></div></div>
            </div>
        @empty
            <x-portal.empty message="No courses yet." />
        @endforelse
    </x-portal.card>

    <x-portal.card title="Recently admitted students" class="lg:col-span-2" :padding="false">
        <x-slot:actions><x-portal.button size="sm" icon="fa-plus" :href="route('portal.admin.students.create')">Admit student</x-portal.button></x-slot:actions>
        <x-portal.table :headers="['Admission No.', 'Name', 'Course', 'Admitted', 'Status']">
            @forelse ($recentStudents as $student)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 font-mono text-xs"><a class="text-primary hover:underline" href="{{ route('portal.admin.students.show', $student) }}">{{ $student->admission_no }}</a></td>
                    <td class="px-4 py-3">{{ $student->full_name }}</td>
                    <td class="px-4 py-3">{{ $student->course?->name }}</td>
                    <td class="px-4 py-3">{{ $student->admission_date->format('d M Y') }}</td>
                    <td class="px-4 py-3"><x-portal.badge :status="$student->status" /></td>
                </tr>
            @empty
                <tr><td colspan="5"><x-portal.empty message="No students yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>
</div>
@endsection
