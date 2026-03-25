@extends('layouts.welcomelayout')

@section('meta-title', $course->name . ' - Hewitt Bennet International College')
@section('meta-description', Str::limit($course->course_description, 160))
@section('meta-keywords', $course->name . ', ' . ($course->department->name ?? 'Professional') . ', Courses, Education, Degrees, Certificates, Hewitt Bennet, College')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('storage/' . $course->image))
@section('meta-date', $course->updated_at->toIso8601String())

@section('og:type', 'website')
@section('og:title', $course->name . ' - Hewitt Bennet International College')
@section('og:description', Str::limit($course->course_description, 160))
@section('og:image', asset('storage/' . $course->image))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', $course->updated_at->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', $course->name . ' - Hewitt Bennet International College')
@section('twitter:description', Str::limit($course->course_description, 160))
@section('twitter:image', asset('storage/' . $course->image))
@section('twitter:site', '@HewittBennetIntl')

@section('content')

<!-- Course Detail Section --><section class="py-16 bg-gradient-to-br from-blue-50 to-indigo-100"> <div class="container mx-auto px-4"> <!-- Breadcrumb --> <div class="mb-6 text-sm text-gray-600"> <a href="{{ route('welcome') }}" class="hover:text-primary">Home</a> > <a href="{{ route('courses.all') }}" class="hover:text-primary">Courses</a> > <span class="text-primary font-medium">{{ $course->name }}</span> </div>
text
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h5 class="text-lg font-semibold text-primary uppercase tracking-wider">{{ $course->department->name ?? 'Professional Program' }}</h5>
        <h1 class="text-4xl md:text-5xl font-bold text-primary mt-2 mb-4">{{ $course->name }}</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">{{ $course->duration }}</p>
    </div>

    <div class="grid md:grid-cols-2 gap-10 items-start">
        <!-- Course Image -->
        <div class="relative">
            <img src="{{ asset('storage/' . $course->image) }}"
                 class="w-full rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300"
                 alt="{{ $course->name }}">
            @if($course->is_featured)
            <span class="absolute top-4 left-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Featured Program</span>
            @endif
        </div>

        <!-- Course Details -->
        <div class="space-y-6">
            <div>
                <h2 class="text-2xl font-semibold text-primary mb-4">Course Description</h2>
                <p class="text-gray-700 leading-relaxed">{{ $course->course_description }}</p>
            </div>

            <!-- Fees Structure -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h3 class="text-xl font-bold text-primary mb-4">Fees Structure</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-700 font-medium">Registration Fees:</span>
                        <span class="text-primary font-semibold">KES {{ number_format($course->registration_fees) }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-700 font-medium">School Fees:</span>
                        <span class="text-primary font-semibold">KES {{ number_format($course->school_fees) }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-700 font-medium">Uniform Fee:</span>
                        <span class="text-primary font-semibold">KES {{ number_format($course->school_uniform_fee) }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-gray-900 font-bold">Total Estimated Cost:</span>
                        <span class="text-primary font-bold text-lg">KES {{ number_format($course->registration_fees + $course->school_fees + $course->school_uniform_fee) }}</span>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center md:text-left">
                <a href="#enroll"
                   class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition-colors duration-300 shadow-md hover:shadow-lg">
                   <i class="fas fa-user-graduate mr-2"></i>Apply Now
                </a>
                <p class="text-sm text-gray-600 mt-2">Limited seats available. Apply today to secure your spot!</p>
            </div>
        </div>
    </div>

    <!-- Additional Information Section -->
    @if($course->short_description || $course->requirements)
    <div class="mt-16 bg-white rounded-xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-primary mb-6">Program Details</h2>
        <div class="grid md:grid-cols-2 gap-8">
            @if($course->short_description)
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Key Features</h3>
                <p class="text-gray-600">{{ $course->short_description }}</p>
            </div>
            @endif

            @if($course->requirements)
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Admission Requirements</h3>
                <p class="text-gray-600">{{ $course->requirements }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Related Courses -->
    @if($relatedCourses->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-primary mb-8 text-center">Related Courses</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedCourses as $relatedCourse)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                <img src="{{ asset('storage/' . $relatedCourse->image) }}"
                     alt="{{ $relatedCourse->name }}"
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-lg text-primary mb-2">{{ $relatedCourse->name }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($relatedCourse->short_description, 80) }}</p>
                    <a href="{{ route('course.single', $relatedCourse->slug) }}"
                       class="text-primary font-medium hover:text-blue-800 text-sm">
                        View Details →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
</section><!-- Enrollment Section --><section id="enroll" class="py-16 bg-primary text-white"> <div class="container mx-auto px-4 text-center"> <h2 class="text-3xl font-bold mb-4">Ready to Start Your Journey?</h2> <p class="text-blue-100 mb-8 max-w-2xl mx-auto">Join hundreds of successful students who have transformed their careers with our programs.</p> <a href="{{ route('application.form') }}" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors duration-300 inline-block"> Apply for Admission </a> </div> </section><style> .breadcrumb a:hover { color: #1E3A8A; text-decoration: underline; } </style>
@endsection
