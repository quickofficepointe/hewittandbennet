@extends('layouts.welcomelayout')

@section('meta-title', 'Available Short Courses - Hewitt Bennet International College')
@section('meta-description', 'Explore our available short courses at Hewitt Bennet International College. Get certified in various fields with flexible durations and guaranteed internship placements.')
@section('meta-keywords', 'Short Courses, Hewitt Bennet, Certified Courses, Professional Training, Internship, Career Development')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/short-courses.jpg')) <!-- Replace with a relevant image -->
@section('meta-date', now()->toIso8601String())

<!-- Open Graph Tags for Social Sharing -->
@section('og:type', 'website')
@section('og:title', 'Available Short Courses - Hewitt Bennet International College')
@section('og:description', 'Explore our available short courses at Hewitt Bennet International College. Get certified in various fields with flexible durations and guaranteed internship placements.')
@section('og:image', asset('assets/img/short-courses.jpg')) <!-- Replace with a relevant image -->
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

<!-- Twitter Card Tags -->
@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Available Short Courses - Hewitt Bennet International College')
@section('twitter:description', 'Explore our available short courses at Hewitt Bennet International College. Get certified in various fields with flexible durations and guaranteed internship placements.')
@section('twitter:image', asset('assets/img/short-courses.jpg')) <!-- Replace with a relevant image -->
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h2 class="text-center text-3xl font-bold mb-8">Available Courses</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach ($shortCourses as $course)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset($course->image) }}" class="w-full h-56 object-cover" alt="{{ $course->name }}">
                <div class="p-6">
                    <h5 class="text-xl font-semibold mb-2">{{ $course->name }}</h5>
                    <p class="text-gray-700 mb-4">Duration: <strong>{{ $course->duration }}</strong></p>
                    <p class="text-gray-600 mb-4">We guarantee student Attachment/Internship to all our students, depending on their relevant areas of study.</p>
                    <a href="#" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg text-lg hover:bg-blue-700 transition duration-300" data-bs-toggle="modal" data-bs-target="#registrationModal">
                        Apply Now <i class="fas fa-hand-pointer ml-2"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
