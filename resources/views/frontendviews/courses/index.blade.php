@extends('layouts.welcomelayout')

@section('meta-title', 'Courses & Fees | Hewitt & Bennet International College')
@section('meta-description', 'Explore accredited TVETA, NITA and CDACC courses at Hewitt & Bennet International College – healthcare, caregiving, hospitality, aviation and German language.')
@section('meta-keywords', 'Courses, Programs, TVETA, NITA, CDACC, Caregiving, EMT, Medical Imaging, Cabin Crew, German, Hewitt Bennet')

@php
    use Illuminate\Support\Str;
    // Tuition is blank for some courses; then only the registration fee is known.
    $feeLabel = fn ($course) => (float) $course->school_fees > 0
        ? 'KES '.number_format((float) $course->registration_fees + (float) $course->school_fees + (float) $course->school_uniform_fee)
        : ((float) $course->registration_fees > 0 ? 'Registration KES '.number_format((float) $course->registration_fees) : 'Contact us');
@endphp

@section('content')
<section class="bg-hbNavy text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14">
        <nav class="text-sm text-white/60 mb-3" aria-label="Breadcrumb"><a href="{{ url('/') }}" class="hover:text-white">Home</a> <span class="mx-2">/</span> <span class="text-white">Courses</span></nav>
        <h1 class="font-serif text-3xl md:text-4xl font-black">Our Courses</h1>
        <p class="mt-3 text-white/80 max-w-2xl">Accredited, practical programs for in-demand careers – in Kenya and internationally.</p>
    </div>
</section>

<section class="py-10 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
            <form method="GET" action="{{ route('courses.all') }}" class="px-6 py-4 border-b flex flex-wrap gap-3" role="search">
                <label class="sr-only" for="course-search">Search courses</label>
                <input id="course-search" type="search" name="search" value="{{ request('search') }}" placeholder="Search courses…"
                       class="flex-1 min-w-[200px] border border-gray-300 px-4 py-2.5 rounded-md text-sm focus:ring-2 focus:ring-hbRed focus:border-transparent">
                <label class="sr-only" for="course-department">Department</label>
                <select id="course-department" name="department" class="border border-gray-300 px-4 py-2.5 rounded-md text-sm focus:ring-2 focus:ring-hbRed focus:border-transparent">
                    <option value="">All Departments</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(request('department') == $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-hbNavy text-white px-6 py-2.5 rounded-md text-sm font-bold hover:bg-brand-700 transition"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
                @if (request()->hasAny(['search', 'department']))
                    <a href="{{ route('courses.all') }}" class="px-4 py-2.5 rounded-md text-sm font-bold text-gray-600 hover:bg-gray-100 transition">Reset</a>
                @endif
            </form>

            <p class="px-6 py-3 text-sm text-gray-600 border-b">Showing <strong>{{ $coursese->count() }}</strong> {{ Str::plural('course', $coursese->count()) }}</p>

            <div class="md:hidden divide-y">
                @foreach ($coursese as $course)
                    <div class="p-5">
                        <a href="{{ route('course.single', $course->slug) }}" class="font-bold text-hbNavy hover:text-hbRed">{{ $course->name }}</a>
                        <p class="text-xs text-gray-500 mt-1">{{ $course->duration ?: '—' }} · {{ $course->department->name ?? 'General' }}</p>
                        <p class="text-sm font-semibold mt-2">{{ $feeLabel($course) }}</p>
                        <div class="flex gap-2 mt-3">
                            <a href="{{ route('course.single', $course->slug) }}" class="flex-1 text-center border border-hbNavy text-hbNavy px-3 py-2 rounded-md text-xs font-bold">Learn More</a>
                            <button type="button" onclick="openEnrollModal({{ $course->id }})" class="flex-1 bg-hbRed text-white px-3 py-2 rounded-md text-xs font-bold">Apply</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-hbNavy text-white text-xs uppercase text-left">
                            <th class="px-4 py-4 font-bold">Course</th>
                            <th class="px-4 py-4 font-bold">Duration</th>
                            <th class="px-4 py-4 font-bold">Level / Exam Body</th>
                            <th class="px-4 py-4 font-bold">Fees</th>
                            <th class="px-4 py-4 font-bold">Department</th>
                            <th class="px-4 py-4"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($coursese as $course)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4">
                                    <a href="{{ route('course.single', $course->slug) }}" class="font-bold text-hbNavy hover:text-hbRed">{{ $course->name }}</a>
                                    <p class="text-xs text-gray-500 mt-1 max-w-md">{{ Str::limit(strip_tags($course->course_description), 90) }}</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $course->duration ?: '—' }}</td>
                                <td class="px-4 py-4">{{ collect([$course->level, $course->examining_body])->filter()->implode(' · ') ?: '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap font-semibold">{{ $feeLabel($course) }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ $course->department->name ?? '—' }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('course.single', $course->slug) }}" class="border border-hbNavy text-hbNavy px-3 py-2 rounded-md text-xs font-bold hover:bg-hbNavy hover:text-white transition whitespace-nowrap">Learn More</a>
                                        <button type="button" onclick="openEnrollModal({{ $course->id }})" class="bg-hbRed text-white px-4 py-2 rounded-md text-xs font-bold hover:bg-red-700 transition">Apply</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-gray-500">
                                    <i class="fa-solid fa-book-open text-4xl text-gray-300 block mb-4"></i>
                                    No courses match your search. <a href="{{ route('courses.all') }}" class="text-hbNavy font-semibold underline">Show all courses</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <p class="px-6 py-5 bg-gray-50 border-t text-sm text-gray-600"><i class="fa-solid fa-circle-info text-hbRed mr-2"></i>Fees are subject to change. See the <a href="{{ route('courses.fees') }}" class="font-semibold text-hbNavy underline">fees structure</a> or contact us for current figures.</p>
        </div>
    </div>
</section>

@include('frontendviews.partials.enroll-modal')
@endsection
