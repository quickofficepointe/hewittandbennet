@extends('layouts.app')

@section('title', 'All Courses')

@section('content')
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-4">All Courses</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Explore our diverse programs designed to launch your career with industry-relevant skills.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($courses as $course)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group flex flex-col h-full">
                <!-- Course Image -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Featured</span>
                </div>

                <!-- Course Content -->
                <div class="p-6 flex-grow">
                    <div class="mb-3">
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">
                            {{ $course->department->name ?? 'Professional' }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                        {{ $course->name }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $course->short_description ?? Str::limit($course->course_description, 120) }}
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex flex-wrap gap-3 text-xs">
                            <div class="flex items-center text-blue-600">
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
                        <a href="{{ route('course.single', $course->slug) }}" class="flex-1 text-center bg-white border border-blue-600 text-blue-600 py-2 px-4 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                            Learn More
                        </a>
                        <a href="#enroll-modal" class="flex-1 text-center bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors apply-btn" data-course="{{ $course->id }}">
                            Apply
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Apply Now Modal (Single Step) -->
<div id="enroll-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-auto overflow-y-auto max-h-[90vh] relative">
        <!-- Close Button -->
        <button id="modal-close" class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>
        <form id="enrollment-form" class="p-8 space-y-6" action="{{ route('courseregistration.store') }}" method="POST">
            @csrf
            <h2 class="text-2xl font-bold text-blue-900 mb-6">Course Application Form</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="phoneNumber" id="phoneNumber" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700">Select Course</label>
                    <select name="course" id="course_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Select Course --</option>
                        @foreach($coursese as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="campus_id" class="block text-sm font-medium text-gray-700">Select Campus</label>
                    <select name="campus_id" id="campus_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Select Campus --</option>
                        @foreach($campuses as $campus)
                        <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="startMonth" class="block text-sm font-medium text-gray-700">Start Month</label>
                    <select name="startMonth" id="startMonth" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Select Month --</option>
                        @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                        <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="startYear" class="block text-sm font-medium text-gray-700">Start Year</label>
                    <select name="startYear" id="startYear" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Select Year --</option>
                        @for($year = date('Y'); $year <= date('Y') + 5; $year++) <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="modeOfLearning" class="block text-sm font-medium text-gray-700">Mode of Learning</label>
                    <select name="modeOfLearning" id="modeOfLearning" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Select Mode --</option>
                        <option value="On-Campus">On-Campus</option>
                        <option value="Online">Online</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <button type="button" id="cancel-btn" class="mr-4 bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition">Cancel</button>
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">Submit Application</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal logic
    const enrollButtons = document.querySelectorAll('.apply-btn');
    const enrollModal = document.getElementById('enroll-modal');
    const modalCloseBtn = document.getElementById('modal-close');
    const enrollmentForm = document.getElementById('enrollment-form');
    const cancelBtn = document.getElementById('cancel-btn');

    enrollButtons.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            enrollModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    });

    modalCloseBtn.addEventListener('click', closeEnrollModal);
    cancelBtn.addEventListener('click', closeEnrollModal);
    enrollModal.addEventListener('click', e => {
        if (e.target === enrollModal) closeEnrollModal();
    });

    function closeEnrollModal() {
        enrollModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        enrollmentForm.reset();
    }

    enrollmentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Success!'
            , text: 'Your application has been submitted successfully.'
            , icon: 'success'
            , confirmButtonText: 'OK'
            , customClass: {
                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded'
            }
            , buttonsStyling: false
        }).then(() => {
            this.submit();
            closeEnrollModal();
        });
    });

</script>
@endsection
