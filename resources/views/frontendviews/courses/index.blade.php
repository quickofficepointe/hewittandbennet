@extends('layouts.welcomelayout')

@section('meta-title', 'Courses - Hewitt Bennet International College')
@section('meta-description', 'Explore our comprehensive catalog of industry-relevant courses and programs at Hewitt Bennet International College.')
@section('meta-keywords', 'Courses, Programs, Education, Degrees, Certificates, Hewitt Bennet, College, Training')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/courses-cover.jpg'))
@section('meta-date', now()->toIso8601String())

@section('og:type', 'website')
@section('og:title', 'Courses - Hewitt Bennet International College')
@section('og:description', 'Explore our comprehensive catalog of industry-relevant courses and programs at Hewitt Bennet International College.')
@section('og:image', asset('assets/img/courses-cover.jpg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Courses - Hewitt Bennet International College')
@section('twitter:description', 'Explore our comprehensive catalog of industry-relevant courses and programs at Hewitt Bennet International College.')
@section('twitter:image', asset('assets/img/courses-cover.jpg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')

<!-- Courses Section --><section class="py-16 bg-gradient-to-br from-blue-50 to-indigo-100"> <div class="container mx-auto px-4"> <!-- Page Header --> <div class="text-center mb-12"> <h5 class="text-lg font-semibold text-primary uppercase tracking-wider">Our Programs</h5> <h1 class="text-4xl md:text-5xl font-bold text-primary mt-2 mb-4">Academic Courses Catalog</h1> <p class="text-gray-600 max-w-2xl mx-auto">Explore our comprehensive catalog of industry-relevant courses and programs designed to prepare you for success in your career.</p> </div>
     <!-- Filter Buttons -->
    <div class="flex flex-wrap justify-center gap-3 mb-10">
        <button class="filter-btn active px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="all">
            All Courses
        </button>
        @foreach($departments as $department)
        <button class="filter-btn px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="{{ Str::slug($department->name) }}">
            {{ $department->name }}
        </button>
        @endforeach
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($coursese as $course)
        <div class="course-item bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group flex flex-col h-full" data-department="{{ Str::slug($course->department->name ?? 'general') }}">
            <!-- Course Image -->
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                @if($course->is_featured)
                <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Featured</span>
                @endif
            </div>

            <!-- Course Content -->
            <div class="p-6 flex-grow">
                <!-- Course Name & Department -->
                <div class="mb-3">
                    <span class="text-xs font-semibold text-primary uppercase tracking-wider">
                        {{ $course->department->name ?? 'Professional' }}
                    </span>
                </div>

                <!-- Course Title -->
                <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                    {{ $course->name }}
                </h3>

                <!-- Short Description -->
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                    {{ $course->short_description ?? Str::limit($course->course_description, 120) }}
                </p>

                <!-- Key Features -->
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex flex-wrap gap-3 text-xs">
                        <div class="flex items-center text-primary">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Accredited
                        </div>
                        <div class="flex items-center text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            Global
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 pb-6 mt-auto">
                <div class="flex gap-3">
                    <a href="{{ route('course.single', $course->slug) }}"
                       class="flex-1 text-center bg-white border border-primary text-primary py-2 px-4 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                        Learn More
                    </a>
                    <a href="#enroll-modal"
                       class="flex-1 text-center bg-primary text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors apply-btn"
                       data-course="{{ $course->id }}">
                        Apply
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if(count($coursese) === 0)
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center rounded-full bg-blue-100 p-4 mb-4">
                <i class="fas fa-book-open text-3xl text-primary"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No courses available yet</h3>
            <p class="text-gray-500">Check back later for our course offerings.</p>
        </div>
    @endif
</div>
</section><!-- Custom Courses Script --><script> document.addEventListener('DOMContentLoaded', function() { // Filter functionality const filterButtons = document.querySelectorAll('.filter-btn'); const courseItems = document.querySelectorAll('.course-item'); filterButtons.forEach(button => { button.addEventListener('click', () => { // Update active state filterButtons.forEach(btn => btn.classList.remove('active', 'bg-primary', 'text-white')); button.classList.add('active', 'bg-primary', 'text-white'); // Filter items const filterValue = button.getAttribute('data-filter'); courseItems.forEach(item => { if (filterValue === 'all' || item.getAttribute('data-department') === filterValue) { item.classList.remove('hidden'); } else { item.classList.add('hidden'); } }); }); }); }); </script><style> .course-item { transition: transform 0.3s ease; } .course-item:hover { transform: translateY(-5px); } .filter-btn.active { background-color: #1E3A8A; color: white; } .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; } </style>
@endsection
