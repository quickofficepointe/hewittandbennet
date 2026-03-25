<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hewitt And Bennet International College</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A',   // blue-900
                        secondary: '#DC2626', // red-600
                        light: '#F8FAFC'
                    },
                    animation: {
                        'scroll': 'scroll 30s linear infinite',
                    },
                    keyframes: {
                        scroll: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-50%)' },
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="Assets/images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Assets/images/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="Assets/images/favicon_io/site.webmanifest">

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .break-inside-avoid-column {
            break-inside: avoid;
        }

        .chatbot-transition {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

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
    </style>
</head>
<body class="bg-white text-primary">
    <!-- Header & Navigation -->
    <header x-data="{ mobileOpen: false }" class="sticky top-0 z-50 bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo and Brand -->
            <div class="flex items-center space-x-3">
                <img src="{{asset ('assets/img/logo_nobg.png') }}" alt="Hewitt and Bennet Logo" class="h-12 sm:h-14">
                <span class="text-xl sm:text-2xl font-bold leading-tight">
                    Hewitt And Bennet<br class="hidden sm:block" />International College
                </span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <div class="flex space-x-6">
                    <a href="/" class="text-lg text-primary hover:text-secondary transition-colors">Home</a>
                    <a href="#about" class="text-lg text-primary hover:text-secondary transition-colors">About Us</a>
                    <a href="{{ route('courses.all') }}" class="text-lg text-primary hover:text-secondary transition-colors">Courses</a>
                    <a href="{{ route('registration.create') }}" class="text-lg text-primary hover:text-secondary transition-colors">Admissions</a>
                    <a href="#campus" class="text-lg text-primary hover:text-secondary transition-colors">Campus</a>
                    <a href="{{ route('news.event') }}" class="text-lg text-primary hover:text-secondary transition-colors">News</a>
                    <a href="#contact" class="text-lg text-primary hover:text-secondary transition-colors">Contact Us</a>
                </div>

                <div class="flex space-x-4 ml-6">
                    <a href="#enroll" class="bg-secondary text-white px-5 py-2.5 rounded-lg hover:bg-red-700 text-lg transition-colors">Enroll Now</a>
                    <a href="{{ route('courses.all') }}" class="border border-primary text-primary px-5 py-2.5 rounded-lg hover:bg-blue-50 text-lg transition-colors">View Courses</a>
                </div>
            </div>

            <!-- Mobile Toggle -->
            <button @click="mobileOpen = true" class="md:hidden text-primary">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </nav>

        <!-- Mobile Navigation -->
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden fixed inset-0 bg-white z-40 overflow-y-auto">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <img src="{{asset ('assets/img/logo_nobg.png') }}" alt="Hewitt and Bennet Logo" class="h-10">
                        <span class="text-base font-semibold text-primary leading-tight">
                            Hewitt And Bennet<br>International College
                        </span>
                    </div>
                    <button @click="mobileOpen = false" class="text-primary">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>
                <div class="flex flex-col space-y-5 text-center py-6">
                    <a href="/" @click="mobileOpen = false" class="text-lg text-primary hover:text-secondary py-2">Home</a>
                    <a href="#about" @click="mobileOpen = false" class="text-lg text-primary hover:text-secondary py-2">About Us</a>
                    <a href="{{ route('courses.all') }}" @click="mobileOpen = false" class="text-lg text-primary hover:text-secondary py-2">Courses</a>
                    <a href="#admissions" @click="mobileOpen = false" class="text-lg text-primary hover:text-secondary py-2">Admissions</a>
                    <a href="#campus" @click="mobileOpen = false" class="text-lg text-primary hover:text-secondary py-2">Campus</a>
                    <a href="#contact" @click="mobileOpen = false" class="text-lg text-primary hover:text-secondary py-2">Contact Us</a>

                    <div class="pt-4 border-t border-gray-200 space-y-4">
                        <a href="#enroll" @click="mobileOpen = false" class="block bg-secondary text-white py-3 rounded-lg hover:bg-red-700 text-lg">Enroll Now</a>
                        <a href="{{ route('courses.all') }}" @click="mobileOpen = false" class="block border border-primary text-primary py-3 rounded-lg hover:bg-blue-50 text-lg">View Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Carousel -->
    <section x-data="carousel()" id="hero-carousel" class="relative h-screen flex items-center justify-center text-white overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
            @foreach($banners as $index => $banner)
            <div x-show="currentIndex === {{ $index }}" x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="absolute inset-0 w-full h-full">
                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? 'Banner Image' }}" class="object-cover w-full h-full">
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
                    <a href="#enroll" class="bg-secondary text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-red-700 transition-colors shadow-lg">Enroll Now</a>
                    <a href="{{ route('courses.all') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-white hover:text-primary transition-colors shadow-lg">View Courses</a>
                </div>
                <a href="#abroad-opportunities" class="bg-secondary text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-red-700 transition-colors shadow-lg">Abroad Opportunities</a>
            </div>
        </div>

        <button @click="prev()" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-3 rounded-full z-30">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button @click="next()" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-3 rounded-full z-30">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <div class="absolute bottom-8 z-30 flex space-x-2">
            @foreach($banners as $index => $banner)
            <span @click="goTo({{ $index }})" :class="{'bg-white bg-opacity-80': currentIndex === {{ $index }}, 'bg-white bg-opacity-50': currentIndex !== {{ $index }}}" class="dot w-3 h-3 rounded-full cursor-pointer hover:bg-opacity-80 transition-colors duration-300"></span>
            @endforeach
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl md:text-5xl font-bold text-primary text-center mb-12">About Our College</h2>

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
                        <div class="bg-white p-8 rounded-lg shadow-xl border-t-4 border-secondary transform hover:-translate-y-2 transition-transform duration-300 pl-8 pr-4">
                            <h3 class="text-3xl font-bold text-secondary mb-4">Our Mission</h3>
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

    <!-- Leadership Team -->
    <section class="px-6 py-12 bg-gray-100" id="management">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-primary mb-10">Leadership Team</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($teams as $member)
                <div class="relative rounded-xl overflow-hidden shadow-md h-64 md:h-80 group">
                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300"></div>
                    <div class="absolute top-0 left-0 md:top-auto md:bottom-4 md:left-1/2 md:transform md:-translate-x-1/2">
                        <div class="bg-primary text-white px-4 py-2 text-sm font-semibold rounded-lg shadow-md text-left md:text-center">
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
    <section class="px-6 py-16 bg-gradient-to-br from-blue-50 to-blue-100" id="courses">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-primary mb-4">Our Featured Courses</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover programs designed to launch your career with industry-relevant skills</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($coursese as $course)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group flex flex-col h-full">
                    <!-- Course Image -->
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
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
                                    <i class="fa-solid fa-check-circle mr-1"></i>
                                    Accredited
                                </div>
                                <div class="flex items-center text-green-600">
                                    <i class="fa-solid fa-globe mr-1"></i>
                                    Global
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-6 pb-6 mt-auto">
                        <div class="flex gap-3">
                            <a href="{{ route('course.single', $course->slug) }}"
                               class="flex-1 text-center bg-white border border-blue-600 text-blue-600 py-2 px-4 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                                Learn More
                            </a>
                            <a href="#enroll-modal"
                               class="flex-1 text-center bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors apply-btn"
                               data-course="{{ $course->id }}">
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
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Apply Now Modal -->
    <div x-data="{ open: false, selectedCourse: '' }"
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         style="display: none;">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-auto overflow-y-auto max-h-[90vh] relative">
            <!-- Close Button -->
            <button @click="open = false" class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>

            <form id="enrollment-form" class="p-8 space-y-6" action="{{ route('courseregistration.store') }}" method="POST">
                @csrf
                <h2 class="text-2xl font-bold text-primary mb-6">Course Application Form</h2>

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
                        <select name="course_id" id="course_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
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
                            @for($year = date('Y'); $year <= date('Y') + 5; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
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
                    <button type="button" @click="open = false" class="mr-4 bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition">Cancel</button>
                    <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">Submit Application</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Partners Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-primary mb-8">Our Valued Partners</h2>

            <div class="partners-slider relative overflow-hidden h-32">
                <div class="partners-track flex absolute left-0 top-0 h-full items-center animate-scroll">
                    @foreach($partners as $partner)
                    <div class="partner-slide mx-8 flex-shrink-0">
                        <img src="{{ asset('storage/' . $partner->logo) }}"
                             alt="{{ $partner->name }}"
                             class="h-20 object-contain opacity-80 hover:opacity-100 transition-opacity duration-300"
                             title="{{ $partner->name }}">
                    </div>
                    @endforeach

                    <!-- Duplicate for seamless looping -->
                    @foreach($partners as $partner)
                    <div class="partner-slide mx-8 flex-shrink-0">
                        <img src="{{ asset('storage/' . $partner->logo) }}"
                             alt="{{ $partner->name }}"
                             class="h-20 object-contain opacity-80 hover:opacity-100 transition-opacity duration-300"
                             title="{{ $partner->name }}">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Student Life -->
    <section id="student-life" class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl md:text-5xl font-bold text-primary text-center mb-12">Student Life</h2>

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

    <!-- Campuses -->
    <section class="py-16 bg-white" id="campus">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-primary text-center mb-8">Our Campuses</h2>
            <p class="text-gray-700 text-center mb-12">Explore our campuses located in Nairobi CBD, Buruburu, and Thika.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($campuses as $campus)
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    @if($campus->banner_image)
                    <img src="{{ asset('storage/' . $campus->banner_image) }}" alt="{{ $campus->name }}" class="w-full h-40 object-cover rounded mb-4">
                    @endif
                    <h3 class="text-xl font-semibold text-primary mb-4">{{ $campus->name }}</h3>
                </div>
                @endforeach
            </div>
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
    <div x-data="{ chatbotOpen: false }" class="fixed bottom-8 right-8 z-50">
        <button @click="chatbotOpen = !chatbotOpen" class="bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">
            <i class="fa-solid fa-comments text-xl"></i>
        </button>
        <div x-show="chatbotOpen" x-transition:enter="chatbot-transition"
             x-transition:enter-start="opacity-0 transform translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="chatbot-transition"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-4"
             class="absolute bottom-full right-0 w-80 h-96 bg-white rounded-lg shadow-xl border border-gray-200 flex flex-col"
             style="display: none;">
            <div class="p-4 flex justify-between items-center border-b border-gray-200 bg-blue-600 text-white rounded-t-lg">
                <h3 class="font-semibold">Hewitt & Bennet Chat</h3>
                <button @click="chatbotOpen = false" class="text-white hover:text-gray-200">&times;</button>
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
    <footer class="bg-primary text-white py-12">
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
                <h3 class="text-xl font-semibold mb-4 text-secondary">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                    <li><a href="#about" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="#admissions" class="text-gray-300 hover:text-white transition-colors">Admissions</a></li>
                    <li><a href="#student-life" class="text-gray-300 hover:text-white transition-colors">Campus Life</a></li>
                    <li><a href="#contact" class="text-gray-300 hover:text-white transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-semibold mb-4 text-secondary">Programs & Opportunities</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('courses.all') }}" class="text-gray-300 hover:text-white transition-colors">View All Courses</a></li>
                    <li><a href="#enroll" class="text-gray-300 hover:text-white transition-colors">Enroll Now</a></li>
                    <li><a href="{{ route('workabroad.index') }}" class="text-gray-300 hover:text-white transition-colors">Study Abroad</a></li>
                    <li><a href="{{ route('workabroad.index') }}" class="text-gray-300 hover:text-white transition-colors">Work Abroad</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-semibold mb-4 text-secondary">Contact & Info</h3>
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
        // Alpine.js components
        document.addEventListener('alpine:init', () => {
            // Carousel component
            Alpine.data('carousel', () => ({
                currentIndex: 0,
                totalItems: {{ count($banners) }},
                interval: null,

                init() {
                    this.startAutoSlide();
                },

                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.totalItems;
                    this.restartAutoSlide();
                },

                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.totalItems) % this.totalItems;
                    this.restartAutoSlide();
                },

                goTo(index) {
                    this.currentIndex = index;
                    this.restartAutoSlide();
                },

                startAutoSlide() {
                    this.interval = setInterval(() => {
                        this.next();
                    }, 7000);
                },

                restartAutoSlide() {
                    clearInterval(this.interval);
                    this.startAutoSlide();
                }
            }));

            // Initialize apply buttons to open modal
            document.querySelectorAll('.apply-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const courseId = btn.getAttribute('data-course');
                    Alpine.store('modal').open = true;
                    Alpine.store('modal').selectedCourse = courseId;

                    // Set the course value in the form if needed
                    if (courseId) {
                        document.getElementById('course_id').value = courseId;
                    }
                });
            });
        });

        // Simple store for modal state
        document.addEventListener('alpine:init', () => {
            Alpine.store('modal', {
                open: false,
                selectedCourse: ''
            });
        });

        // Chatbot functionality
        document.addEventListener('DOMContentLoaded', function() {
            const chatbotMessages = document.getElementById('chatbot-messages');
            const chatbotInput = document.getElementById('chatbot-input');
            const chatbotSend = document.getElementById('chatbot-send');

            function displayMessage(text, sender) {
                const msg = document.createElement('div');
                msg.classList.add('message', sender);
                msg.textContent = text;
                chatbotMessages.appendChild(msg);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            chatbotSend.addEventListener('click', () => {
                const text = chatbotInput.value.trim();
                if (!text) return;
                displayMessage(text, 'user');
                chatbotInput.value = '';
                setTimeout(() => displayMessage("Thank you! We'll be in touch.", 'bot'), 500);
            });

            chatbotInput.addEventListener('keypress', e => {
                if (e.key === 'Enter') chatbotSend.click();
            });
        });
    </script>
</body>
</html>
