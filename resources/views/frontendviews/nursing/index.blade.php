@extends('layouts.welcomelayout')

@section('meta-title', 'Available Nursing Assistance Courses - Hewitt Bennet International College')
@section('meta-description', 'Explore our nursing courses at Hewitt Bennet International College. Get certified in nursing and healthcare with professional training and guaranteed internship placements.')
@section('meta-keywords', 'Nursing Courses, Nursing Training, Caregiving, Health Certification, Hewitt Bennet, Professional Nursing')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/nursing-courses.jpg'))
@section('meta-date', now()->toIso8601String())

<!-- Open Graph Tags for Social Sharing -->
@section('og:type', 'website')
@section('og:title', 'Available Nursing Courses - Hewitt Bennet International College')
@section('og:description', 'Explore our nursing courses at Hewitt Bennet International College. Get certified in nursing and healthcare with professional training and guaranteed internship placements.')
@section('og:image', asset('assets/img/nursing-courses.jpg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

<!-- Twitter Card Tags -->
@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Available Nursing Courses - Hewitt Bennet International College')
@section('twitter:description', 'Explore our nursing courses at Hewitt Bennet International College. Get certified in nursing and healthcare with professional training and guaranteed internship placements.')
@section('twitter:image', asset('assets/img/nursing-courses.jpg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-semibold text-center mb-8 text-gray-800">Available Nursing Courses</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($nursingCourses as $course)
            <div class="max-w-xs rounded-lg overflow-hidden shadow-lg bg-white hover:shadow-2xl transition-all">
                <img src="{{ asset($course->image) }}" class="w-full h-48 object-cover" alt="{{ $course->name }}">

                <div class="p-4">
                    <h5 class="text-xl font-semibold text-gray-800">{{ $course->name }}</h5>
                    <p class="text-gray-600 mt-2">Duration: <span class="font-bold text-gray-900">{{ $course->duration }}</span></p>
                    <p class="text-gray-600 mt-2">Registration Fee: <span class="font-bold text-gray-900">{{ number_format($course->school_fees) }}</span></p>
                    <p class="text-gray-600 mt-2">We guarantee student Attachment/Internship to all our students, depending on their relevant areas of study.</p>

                    <div class="mt-4">
                        <a href="#" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-all" data-bs-toggle="modal" data-bs-target="#registrationModal">
                            Apply Now <i class="fas fa-hand-pointer"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
