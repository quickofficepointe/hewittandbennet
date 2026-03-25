<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hewitt And Bennet International College</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Favicon  -->
    <link rel="apple-touch-icon" sizes="180x180" href="Assets/images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Assets/images/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="Assets/images/favicon_io/site.webmanifest">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        #chatbot-container {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            transform: translateY(20px);
            /* Start slightly off-screen */
            opacity: 0;
            pointer-events: none;
            /* Prevent interaction when hidden */
        }

        #chatbot-container.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            /* Allow interaction when active */
        }

        /* Styles for chat messages */
        .message {
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 80%;
            margin-bottom: 8px;
            word-wrap: break-word;
        }

        .message.user {
            color: #1E40AF;
            margin-left: auto;
            text-align: right;
        }

        .message.bot {
            background-color: #F3F4F6;
            color: #4B5563;
            margin-right: auto;
            text-align: left;
        }

        /* SweetAlert2 custom button styling */
        .swal2-confirm.bg-blue-600 {
            background-color: #2563EB !important;
            /* Tailwind blue-600 */
        }

        .swal2-confirm.bg-blue-600:hover {
            background-color: #1D4ED8 !important;
            /* Tailwind blue-700 */
        }

        html {
            scroll-behavior: smooth;
        }

    </style>

</head>
<body class="bg-white text-blue-900">

    <!-- Header && Navigation Section -->
    <header class="relative z-10 bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo and Brand -->
            <div class="flex items-center space-x-3">
                <img src="{{asset ('assets/img/logo_nobg.png') }}" alt="Hewitt and Bennet Logo" class="h-12 sm:h-14">
                <span class="text-xl sm:text-2xl font-bold text-blue-900 leading-tight">
                    Hewitt And Bennet<br class="hidden sm:block" />International College
                </span>
            </div>

            <!-- Desktop Navigation -->
            <ul class="hidden md:flex space-x-6">
                <li><a href="/" class="text-lg text-blue-900 hover:text-red-600">Home</a></li>
                <li><a href="/#about" class="text-lg text-blue-900 hover:text-red-600">About Us</a></li>
                <li><a href="{{ route('courses.all') }}" class="text-lg text-blue-900 hover:text-red-600">Courses</a></li>
                <li><a href="/#admissions" class="text-lg text-blue-900 hover:text-red-600">Admissions</a></li>
                <li><a href="/#campus" class="text-lg text-blue-900 hover:text-red-600">Campus</a></li>
                <li><a href="{{ route('news.event') }}" class="text-lg text-blue-900 hover:text-red-600">News</a></li>
                <li><a href="/#contact" class="text-lg text-blue-900 hover:text-red-600">Contact Us</a></li>
            </ul>

            <!-- Desktop Buttons -->
            <div class="hidden md:flex space-x-4">
                <a href="/#admissions" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-lg">Enroll Now</a>
                <a href="{{ route('courses.all') }}" class="border border-blue-900 text-blue-900 px-4 py-2 rounded-md hover:bg-blue-100 text-lg">View Courses</a>
            </div>

            <!-- Mobile Toggle -->
            <button id="mobile-menu-toggle" class="md:hidden text-blue-900 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </nav>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="md:hidden fixed top-0 left-0 w-full h-full bg-white z-40 transform -translate-y-full opacity-0 transition-all duration-300 ease-in-out">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <img src="{{asset ('assets/img/logo_nobg.png') }}" alt="Hewitt and Bennet Logo" class="h-10">
                        <span class="text-base font-semibold text-blue-900 leading-tight">
                            Hewitt And Bennet<br>International College
                        </span>
                    </div>
                    <button id="mobile-menu-close" class="text-blue-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <ul class="flex flex-col space-y-4 text-center">
                    <li><a href="/" class="text-lg text-blue-900 hover:text-red-600">Home</a></li>
                    <li><a href="/#about" class="text-lg text-blue-900 hover:text-red-600">About Us</a></li>
                    <li><a href="{{ route('courses.all') }}" class="text-lg text-blue-900 hover:text-red-600">Courses</a></li>
                    <li><a href="/#admissions" class="text-lg text-blue-900 hover:text-red-600">Admissions</a></li>
                    <li><a href="/#campus" class="text-lg text-blue-900 hover:text-red-600">Campus</a></li>
                    <li><a href="/#contact" class="text-lg text-blue-900 hover:text-red-600">Contact Us</a></li>
                    <li>
                        <a href="/#admissions" class="bg-red-600 text-white w-full py-3 rounded-md hover:bg-red-700 block text-lg">Enroll Now</a>
                    </li>
                    <li>
                        <a href="{{ route('courses.all') }}" class="border border-blue-900 text-blue-900 w-full py-3 rounded-md hover:bg-blue-100 block text-lg">View Courses</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Hero section -->
    <section id="hero-carousel" class="relative h-screen flex items-center justify-center text-white overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
            <!-- Replace the current carousel item with this: -->
            @foreach($banners as $index => $banner)
            <div class="carousel-item absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 active' : 'opacity-0' }}" data-index="{{ $index }}">
                <img src="{{ $banner->image_path }}" alt="College Banner" class="object-cover w-full h-full">
                <div class="absolute inset-0 bg-black opacity-30 z-10"></div>
            </div>
            @endforeach
        </div>

        <div class="relative z-20 text-center px-4 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-4 text-white drop-shadow-lg">
                <span>Training for</span> <span>Global</span> Assignments
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-white text-opacity-90 drop-shadow-md">
                Empowering students to excel globally through industry-focused training and internationally recognized programs.
            </p>
            <div class="flex flex-col items-center space-y-4">
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#admissions" class="bg-red-600 text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-red-700 transition-colors shadow-lg">Enroll Now</a>
                    <a href="{{ route('courses.all') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-white hover:text-blue-900 transition-colors shadow-lg">View Courses</a>
                </div>
                <a href="{{ route('workabroad.index') }}" class="bg-red-600 text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-red-700 transition-colors shadow-lg">Abroad Opportunities</a>
            </div>
        </div>

        <button class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-3 rounded-full z-30" id="carousel-prev">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-3 rounded-full z-30" id="carousel-next">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <div class="absolute bottom-8 z-30 flex space-x-2" id="carousel-dots">
            @foreach($banners as $index => $banner)
            <span class="dot w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer hover:bg-opacity-80 transition-colors duration-300 {{ $index === 0 ? 'active-dot' : '' }}"></span>
            @endforeach
        </div>
    </section>

    <!-- After the hero carousel section -->
    <section class="py-12 bg-blue-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold mb-6">Ready to start your journey with us?</h3>
            <a href="https://wa.me/254700207013" class="inline-flex items-center bg-white text-blue-700 px-8 py-4 rounded-lg text-xl font-semibold hover:bg-gray-100 transition-colors shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                Want to join? Chat Now
            </a>
        </div>
    </section>

    <!-- College About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl md:text-5xl font-bold text-blue-900 text-center mb-12">About Our College</h2>

            <div class="grid grid-cols-1 md:grid-cols-[2fr_3fr] gap-10 max-w-6xl mx-auto items-stretch">
                <!-- Left: About Text -->
                <div class="bg-white p-8 rounded-lg shadow-xl transform hover:scale-105 transition-transform duration-300 min-h-full flex flex-col justify-center">
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">
                        At Hewitt and Bennet International College, we're dedicated to delivering industry-focused training that empowers students for global careers. Our accreditations and partnerships highlight our commitment to high-quality, internationally recognized education.
                    </p>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        Our curriculum prepares students for success, with programs tailored to meet today's job market demands. We also offer visa application support to help graduates transition smoothly into their professional journeys worldwide.
                    </p>
                </div>

                <!-- Right: Vision, Mission, Values -->
                <div class="relative flex flex-col gap-8">
                    <div class="absolute inset-y-0 left-1/2 transform -translate-x-1/2 w-px bg-gray-300 z-0 hidden sm:block"></div>

                    <!-- Vision -->
                    <div class="bg-white p-8 rounded-lg shadow-xl border-t-4 border-blue-600 transform hover:-translate-y-2 transition-transform duration-300 relative z-10 pl-8 pr-4">
                        <h3 class="text-3xl font-bold text-blue-800 mb-4">Our Vision</h3>
                        <p class="text-gray-700 leading-relaxed">
                            To become Africa's premier training institution, aligning student skills with global job market needs.
                        </p>
                    </div>

                    <!-- Mission & Values -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 relative z-10">
                        <!-- Mission -->
                        <div class="bg-white p-8 rounded-lg shadow-xl border-t-4 border-red-600 transform hover:-translate-y-2 transition-transform duration-300 pl-8 pr-4">
                            <h3 class="text-3xl font-bold text-red-600 mb-4">Our Mission</h3>
                            <p class="text-gray-700 leading-relaxed">
                                To deliver globally in-demand training programs that equip students for success.
                            </p>
                        </div>

                        <!-- Values -->
                        <div class="bg-white p-8 rounded-lg shadow-xl border-t-4 border-blue-600 transform hover:-translate-y-2 transition-transform duration-300 pl-8 pr-4">
                            <h3 class="text-3xl font-bold text-blue-800 mb-4">Our Values</h3>
                            <ul class="list-disc list-inside text-gray-700 leading-relaxed space-y-2">
                                <li>Excellence and Integrity</li>
                                <li>Service and Self-determination</li>
                                <li>Global Citizenship</li>
                                <li>Compassion and Respect</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center mt-16">
                <p class="text-2xl font-semibold text-gray-800 mb-6">Ready to start your global journey?</p>
                <a href="{{ route('courses.all') }}" class="bg-blue-700 text-white px-10 py-4 rounded-full text-xl font-bold hover:bg-blue-800 transition-colors shadow-lg">
                    Explore Programs
                </a>
            </div>
        </div>
    </section>

    <!-- After the courses section -->
    <section class="py-12 bg-gray-100">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold mb-6 text-blue-900">Need career guidance?</h3>
            <a href="https://wa.me/254740197796" class="inline-flex items-center bg-blue-700 text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-blue-800 transition-colors shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                Get Career Guidance
            </a>
        </div>
    </section>

    <!-- Leadership Team -->
    <section class="px-6 py-12 bg-gray-100" id="management">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-blue-900 mb-10">Leadership Team</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($teams as $member)
                <div class="relative rounded-xl overflow-hidden shadow-md h-64 md:h-80">
                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="w-full h-full object-cover" />
                    <div class="absolute top-0 left-0 md:top-auto md:bottom-4 md:left-1/2 md:transform md:-translate-x-1/2">
                        <div class="bg-blue-900 text-white px-4 py-2 text-sm font-semibold rounded-lg shadow-md text-left md:text-center">
                            {{ $member->name }}<br />
                            <span class="text-xs font-normal">{{ $member->description }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Courses section -->
    <section class="px-6 py-16 bg-gradient-to-br from-blue-50 to-blue-100" id="admissions">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-blue-900 mb-4">Our Featured Courses</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover programs designed to launch your career with industry-relevant skills</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($coursese as $course)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group flex flex-col h-full">
                    <!-- Course Image -->
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Featured</span>
                    </div>

                    <!-- Course Content -->
                    <div class="p-6 flex-grow">
                        <!-- Course Name & Department -->
                        <div class="mb-3">
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">
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

                    <!-- Action Buttons - Now fixed at bottom -->
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

            <!-- View All Button -->
            <div class="text-center mt-12">
                <a href="{{ route('courses.all') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    View All Courses
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
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
                    <!-- Personal Information -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold text-blue-800 mb-4 border-b pb-2">Personal Information</h3>
                    </div>

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

                    <!-- Course Information -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold text-blue-800 mb-4 border-b pb-2">Course Information</h3>
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
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
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

    <!-- Before the footer section -->
    <section class="py-12 bg-red-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold mb-6">Have questions? We're here to help!</h3>
            <a href="https://wa.me/254701978169" class="inline-flex items-center bg-white text-red-600 px-8 py-4 rounded-lg text-xl font-semibold hover:bg-gray-100 transition-colors shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                Contact via WhatsApp
            </a>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-blue-900 mb-8">Our Valued Partners</h2>

            <div class="partners-slider relative overflow-hidden h-32">
                <div class="partners-track flex absolute left-0 top-0 h-full items-center">
                    @foreach($partners as $partner)
                    <div class="partner-slide mx-8 flex-shrink-0">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-20 object-contain opacity-80 hover:opacity-100 transition-opacity duration-300" title="{{ $partner->name }}">
                    </div>
                    @endforeach

                    <!-- Duplicate for seamless looping -->
                    @foreach($partners as $partner)
                    <div class="partner-slide mx-8 flex-shrink-0">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-20 object-contain opacity-80 hover:opacity-100 transition-opacity duration-300" title="{{ $partner->name }}">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <style>
        .partners-slider {
            width: 100%;
        }

        .partners-track {
            animation: scroll 30s linear infinite;
            width: max-content;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .partner-slide {
            transition: all 0.3s ease;
        }

        .partner-slide:hover {
            transform: scale(1.1);
        }

    </style>

    <!-- Student Life -->
    <section id="student-life" class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl md:text-5xl font-bold text-blue-900 text-center mb-12">Student Life</h2>

            <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6 max-w-7xl mx-auto">
                @foreach($galleryItems as $item)
                @if($item->file_type === 'image')
                <div class="mb-6 break-inside-avoid-column">
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}" class="w-full rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 object-cover">
                </div>
                @endif
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('student.gallery') }}" class="inline-block bg-blue-700 text-white px-8 py-4 rounded-full text-xl font-bold hover:bg-blue-800 transition-colors shadow-lg">
                    View Full Gallery
                </a>
            </div>
        </div>
    </section>

    <!-- campuses -->
    <section class="py-16 bg-white" id="campus">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-blue-900 text-center mb-8">Our Campuses</h2>
            <p class="text-gray-700 text-center mb-12">Explore our campuses located in Nairobi CBD, Buruburu, and Thika.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($campuses as $campus)
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    @if($campus->banner_image)
                    <img src="{{ asset('storage/' . $campus->banner_image) }}" alt="{{ $campus->name }}" class="w-full h-40 object-cover rounded mb-4">
                    @endif
                    <h3 class="text-xl font-semibold text-blue-900 mb-4">{{ $campus->name }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Social Media / TikTok Section -->
    <section class="py-16 bg-gradient-to-br from-pink-50 to-blue-50" id="social-media">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-blue-900 mb-8">Follow Us on TikTok</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($tiktokVideos as $video)
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center">
                    <div class="relative w-full aspect-w-9 aspect-h-16 mb-4">
                        <iframe id="tiktok-iframe-{{ $video->id }}" src="https://www.tiktok.com/embed/v2/{{ basename($video->video_url) }}" class="w-full h-72 rounded-xl border-0" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="w-full text-center">
                        <a href="{{ $video->video_url }}" target="_blank" class="text-blue-700 hover:underline font-semibold break-all">
                            View on TikTok
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-white" id="testimonials">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-blue-900 mb-8">What Our Students Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                <div class="bg-gray-100 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        @if($testimonial->avatar)
                        <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full mr-4">
                        @endif
                        <h3 class="font-semibold text-gray-800">{{ $testimonial->name }}</h3>
                    </div>
                    <p class="text-gray-600">"{{ strip_tags($testimonial->testimony) }}"</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Review Section -->
    <section id="reviews" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-blue-900 mb-8">Reviews </h2>
            <!-- Review Submission Card (only if logged in) -->
            @auth
            <div class="max-w-xl mx-auto mb-12 bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-xl font-semibold text-blue-800 mb-4">Add Your Review</h3>
                <form action="{{ route('review.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" readonly>
                    </div>
                    <div>
                        <label for="message" class="block text-gray-700 font-medium mb-2">Your Review</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required></textarea>
                    </div>
                    <div>
                        <label for="rate" class="block text-gray-700 font-medium mb-2">Rating</label>
                        <select id="rate" name="rate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">-- Select Rating --</option>
                            @for($i = 1; $i <= 5; $i++) <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-700 text-white py-3 px-6 rounded-lg hover:bg-blue-800 transition font-medium">Submit Review</button>
                </form>
            </div>
            @endauth

            <!-- Reviews Carousel -->
            <div class="relative w-full max-w-6xl mx-auto">
                <div id="reviews-carousel" class="overflow-hidden relative">
                    <div id="reviews-track" class="flex transition-transform duration-700 ease-in-out">
                        @php $approvedReviews = $reviews->where('status', 1); @endphp
                        @if($approvedReviews->count())
                        @foreach($approvedReviews as $review)
                        <div class="w-full sm:w-1/1 md:w-1/2 lg:w-1/3 px-4 flex-shrink-0">
                            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col h-full border border-gray-100">
                                <div class="flex items-center mb-3">
                                    <span class="font-semibold text-blue-900 text-lg">{{ $review->name }}</span>
                                    <span class="ml-auto flex items-center">
                                        @for($i = 1; $i <= 5; $i++) <svg class="w-5 h-5" fill="{{ $i <= $review->rate ? '#FBBF24' : '#E5E7EB' }}" viewBox="0 0 20 20">
                                            <polygon points="10,1 12.59,7.36 19.51,7.36 13.96,11.64 16.55,18 10,13.72 3.45,18 6.04,11.64 0.49,7.36 7.41,7.36" />
                                            </svg>
                                            @endfor
                                    </span>
                                </div>
                                <p class="text-gray-700 leading-relaxed">“{{ $review->message }}”</p>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="min-w-full text-center text-gray-500 py-8">No reviews yet. Be the first to share your experience!</div>
                        @endif
                    </div>
                </div>

                @if($approvedReviews->count() > 1)
                <!-- Prev Button -->
                <button id="reviews-prev" class="absolute -left-6 md:-left-10 top-1/2 -translate-y-1/2 bg-white text-blue-600 p-3 md:p-4 rounded-full shadow-lg border border-gray-200 hover:bg-blue-600 hover:text-white transition">
                    <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <!-- Next Button -->
                <button id="reviews-next" class="absolute -right-6 md:-right-10 top-1/2 -translate-y-1/2 bg-white text-blue-600 p-3 md:p-4 rounded-full shadow-lg border border-gray-200 hover:bg-blue-600 hover:text-white transition">
                    <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Pagination Dots -->
                <div id="reviews-dots" class="flex justify-center space-x-2 mt-6"></div>
                @endif
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const track = document.getElementById('reviews-track');
                    const slides = track ? track.children : [];
                    let currentIndex = 0;
                    const prevBtn = document.getElementById('reviews-prev');
                    const nextBtn = document.getElementById('reviews-next');
                    const dotsContainer = document.getElementById('reviews-dots');
                    let autoSlide;

                    function slidesPerView() {
                        if (window.innerWidth >= 1024) return 3; // lg: show 3
                        if (window.innerWidth >= 768) return 2; // md: show 2
                        return 1; // mobile: show 1
                    }

                    function showSlide(idx) {
                        const perView = slidesPerView();
                        const totalGroups = Math.ceil(slides.length / perView);
                        if (idx < 0) idx = totalGroups - 1;
                        if (idx >= totalGroups) idx = 0;
                        currentIndex = idx;
                        track.style.transform = `translateX(-${idx * 100}%)`;
                        updateDots(totalGroups);
                    }

                    // Create dots
                    function createDots() {
                        if (!dotsContainer) return;
                        dotsContainer.innerHTML = '';
                        const perView = slidesPerView();
                        const totalGroups = Math.ceil(slides.length / perView);
                        for (let i = 0; i < totalGroups; i++) {
                            const dot = document.createElement('button');
                            dot.className = "w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-400 transition";
                            dot.addEventListener('click', () => showSlide(i));
                            dotsContainer.appendChild(dot);
                        }
                        updateDots(totalGroups);
                    }

                    function updateDots(totalGroups) {
                        if (!dotsContainer) return;
                        [...dotsContainer.children].forEach((dot, i) => {
                            dot.className = i === currentIndex ?
                                "w-3 h-3 rounded-full bg-blue-600" :
                                "w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-400";
                        });
                    }

                    if (prevBtn && nextBtn) {
                        prevBtn.addEventListener('click', () => showSlide(currentIndex - 1));
                        nextBtn.addEventListener('click', () => showSlide(currentIndex + 1));
                    }

                    // Auto-play
                    function startAutoPlay() {
                        autoSlide = setInterval(() => showSlide(currentIndex + 1), 5000);
                    }

                    function stopAutoPlay() {
                        clearInterval(autoSlide);
                    }

                    if (track) {
                        track.addEventListener('mouseenter', stopAutoPlay);
                        track.addEventListener('mouseleave', startAutoPlay);
                    }

                    createDots();
                    showSlide(0);
                    startAutoPlay();

                    // Rebuild on resize for responsive
                    window.addEventListener('resize', () => {
                        createDots();
                        showSlide(currentIndex);
                    });
                });

            </script>


        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 bg-gray-50" id="contact">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Contact Us</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We'd love to hear from you! Whether you have questions, need assistance, or are interested in our programs, reach out today.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="lg:w-1/2">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d510528.70323917136!2d36.278633167492444!3d-1.4698621662224913!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1128783fffff%3A0x34ca92a42c32810!2sHewitt%20and%20Bennet%20International%20College!5e0!3m2!1sen!2ske!4v1694245829727!5m2!1sen!2ske" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mt-8">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-primary/10 p-3 rounded-full mr-4">
                                    <i class="fas fa-map-marker-alt text-primary text-xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Our Locations</h3>
                            </div>
                            <ul class="text-gray-600 space-y-2">
                                <li>Nairobi CBD</li>
                                <li>Buruburu</li>
                                <li>Thika</li>
                            </ul>
                        </div>

                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-primary/10 p-3 rounded-full mr-4">
                                    <i class="fas fa-phone-alt text-primary text-xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Contact Numbers</h3>
                            </div>
                            <ul class="text-gray-600 space-y-2">
                                <li>+254 740 197 796</li>
                                <li>+254 792 168 754</li>
                                <li>+254 700 207 013</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Send Us a Message</h3>
                        <form action="" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-700 font-medium mb-2">Your Email</label>
                                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                </div>
                            </div>

                            <div>
                                <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                            </div>

                            <div>
                                <label for="message" class="block text-gray-700 font-medium mb-2">Your Message</label>
                                <textarea id="message" name="body" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required></textarea>
                            </div>

                            <button type="submit" class="w-full bg-primary text-white py-3 px-6 rounded-lg hover:bg-secondary transition font-medium">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chatbot -->
    <div class="fixed bottom-8 right-8 z-50">
        <button id="chatbot-toggle" class="bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        </button>
        <div id="chatbot-container" class="absolute bottom-full right-0 w-80 h-96 bg-white rounded-lg shadow-xl border border-gray-200 flex flex-col">
            <div class="p-4 flex justify-between items-center border-b border-gray-200 bg-blue-600 text-white rounded-t-lg">
                <h3 class="font-semibold">Hewitt & Bennet Chat</h3>
                <button id="chatbot-close" class="text-white hover:text-gray-200">&times;</button>
            </div>
            <div id="chatbot-messages" class="p-4 overflow-y-auto flex-grow">
                <div class="mb-2 text-sm text-gray-600 self-start">
                    Hello! How can I assist you with registration today?
                </div>
            </div>
            <div class="p-4 border-t border-gray-200 flex items-center">
                <input type="text" id="chatbot-input" placeholder="Type your message..." class="flex-grow p-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button id="chatbot-send" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Send</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white py-12">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">

            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center space-x-2 mb-4">
                    <img src="{{asset ('assets/img/logo_nobg.png') }}" alt="Hewitt and Bennet Logo" class="h-10">
                    <span class="text-xl font-bold leading-tight">Hewitt And Bennet<br>International College</span>
                </div>
                <p class="text-gray-300 text-sm">
                    Empowering students for global careers through industry-focused and internationally recognized education.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold mb-4 text-red-600">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                    <li><a href="/#about" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="/#admissions" class="text-gray-300 hover:text-white transition-colors">Admissions</a></li>
                    <li><a href="/#student-life" class="text-gray-300 hover:text-white transition-colors">Campus Life</a></li>
                    <li><a href="/#contact" class="text-gray-300 hover:text-white transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-semibold mb-4 text-red-600">Programs & Opportunities</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('courses.all') }}" class="text-gray-300 hover:text-white transition-colors">View All Courses</a></li>
                    <li><a href="/#admissions" class="text-gray-300 hover:text-white transition-colors">Enroll Now</a></li>
                    <li><a href="{{ route('workabroad.index') }}" class="text-gray-300 hover:text-white transition-colors">Study Abroad</a></li>
                    <li><a href="{{ route('workabroad.index') }}" class="text-gray-300 hover:text-white transition-colors">Work Abroad</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-semibold mb-4 text-red-600">Contact & Info</h3>
                <ul class="space-y-2 mb-4">
                    <li><a href="mailto:info@hewittandbennet.com" class="text-gray-300 hover:text-white transition-colors">Email: info@hewittbennet.co.ke</a></li>
                    <li><a href="tel:+1234567890" class="text-gray-300 hover:text-white transition-colors">Phone: +254 740 197 796</a></li>
                    <li class="text-gray-300">Nairobi, Buruburu, Thika</li>
                </ul>
                <div class="mt-4">
                    <p class="text-lg font-semibold text-white">Google Rating: <span class="font-bold">4.9</span> <span class="text-yellow-400">★★★★★</span></p>
                    <p class="text-sm text-gray-300">Based on student reviews </p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
            <p>&copy; 2025 Hewitt And Bennet International College. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        // grab everything AFTER the DOM is parsed:
        const menu = document.getElementById('mobile-menu');
        const openBtn = document.getElementById('mobile-menu-toggle');
        const closeBtn = document.getElementById('mobile-menu-close');
        const chatbotToggle = document.getElementById('chatbot-toggle');
        const chatbotContainer = document.getElementById('chatbot-container');
        const chatbotClose = document.getElementById('chatbot-close');
        const chatbotMessages = document.getElementById('chatbot-messages');
        const chatbotInput = document.getElementById('chatbot-input');
        const chatbotSend = document.getElementById('chatbot-send');

        const carouselItems = document.querySelectorAll('.carousel-item');
        const carouselPrevBtn = document.getElementById('carousel-prev');
        const carouselNextBtn = document.getElementById('carousel-next');
        const carouselDots = document.querySelectorAll('.dot');
        let currentIndex = 0;
        let autoSlideInterval;
        const slideDuration = 7000;

        const enrollButtons = document.querySelectorAll('.apply-btn');
        const enrollModal = document.getElementById('enroll-modal');
        const modalCloseBtn = document.getElementById('modal-close');
        const enrollmentForm = document.getElementById('enrollment-form');
        const cancelBtn = document.getElementById('cancel-btn');

        // —— Mobile menu ——
        openBtn.addEventListener('click', () => {
            menu.classList.replace('-translate-y-full', 'translate-y-0');
            menu.classList.replace('opacity-0', 'opacity-100');
        });
        closeBtn.addEventListener('click', () => {
            menu.classList.replace('translate-y-0', '-translate-y-full');
            menu.classList.replace('opacity-100', 'opacity-0');
        });

        // —— Chatbot ——
        function toggleChatbot() {
            chatbotContainer.classList.toggle('active');
        }
        chatbotToggle.addEventListener('click', toggleChatbot);
        chatbotClose.addEventListener('click', toggleChatbot);

        function displayMessage(text, sender) {
            const msg = document.createElement('div');
            msg.classList.add('message', sender);
            msg.textContent = text;
            chatbotMessages.appendChild(msg);
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }
        chatbotSend.addEventListener('click', () => {
            const t = chatbotInput.value.trim();
            if (!t) return;
            displayMessage(t, 'user');
            chatbotInput.value = '';
            setTimeout(() => displayMessage("Thank you! We'll be in touch.", 'bot'), 500);
        });
        chatbotInput.addEventListener('keypress', e => {
            if (e.key === 'Enter') chatbotSend.click();
        });

        // —— Carousel ——
        function showSlide(idx) {
            if (idx >= carouselItems.length) idx = 0;
            if (idx < 0) idx = carouselItems.length - 1;
            currentIndex = idx;
            carouselItems.forEach(item => {
                item.classList.toggle('opacity-100', item.dataset.index == idx);
                item.classList.toggle('opacity-0', item.dataset.index != idx);
                const vid = item.querySelector('video');
                if (vid) {
                    if (item.dataset.index == idx) vid.play();
                    else {
                        vid.pause();
                        vid.currentTime = 0;
                    }
                }
            });
            carouselDots.forEach((dot, i) => {
                dot.classList.toggle('active-dot', i == idx);
            });
        }

        function nextSlide() {
            showSlide(currentIndex + 1);
        }

        function prevSlide() {
            showSlide(currentIndex - 1);
        }

        function startAutoSlide() {
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, slideDuration);
        }
        carouselPrevBtn.addEventListener('click', () => {
            prevSlide();
            startAutoSlide();
        });
        carouselNextBtn.addEventListener('click', () => {
            nextSlide();
            startAutoSlide();
        });
        carouselDots.forEach((dot, i) => {
            dot.dataset.index = i;
            dot.addEventListener('click', () => {
                showSlide(i);
                startAutoSlide();
            });
        });
        showSlide(0);
        startAutoSlide();

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) clearInterval(autoSlideInterval);
            else startAutoSlide();
        });

        // —— Enrollment Modal ——
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
                // Submit the form programmatically
                this.submit();
                closeEnrollModal();
            });
        });

        // ...existing code...

    </script>

</body>
</html>
