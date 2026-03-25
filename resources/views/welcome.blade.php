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
                        primary: '#1E3A8A',
                        secondary: '#DC2626',
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .message {
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 80%;
            margin-bottom: 8px;
            word-wrap: break-word;
        }

        .message.user {
            background-color: #EFF6FF;
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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 1rem;
            width: 100%;
            max-width: 42rem;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .modal-enter {
            animation: modalFadeIn 0.3s ease-out;
        }

        .modal-leave {
            animation: modalFadeOut 0.2s ease-in;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes modalFadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.95); }
        }

        .carousel-item {
            transition: opacity 0.7s ease-in-out;
        }
    </style>
</head>
<body class="bg-white text-primary">
    <!-- Header & Navigation -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{asset ('assets/img/logo_nobg.png') }}" alt="Hewitt and Bennet Logo" class="h-12 sm:h-14">
                <span class="text-xl sm:text-2xl font-bold leading-tight">
                    Hewitt And Bennet<br class="hidden sm:block" />International College
                </span>
            </div>

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

            <button id="mobile-menu-button" class="md:hidden text-primary">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </nav>

        <div id="mobile-menu" class="hidden fixed inset-0 bg-white z-40 overflow-y-auto">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <img src="{{asset ('assets/img/logo_nobg.png') }}" alt="Hewitt and Bennet Logo" class="h-10">
                        <span class="text-base font-semibold text-primary leading-tight">
                            Hewitt And Bennet<br>International College
                        </span>
                    </div>
                    <button id="close-mobile-menu" class="text-primary">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>
                <div class="flex flex-col space-y-5 text-center py-6">
                    <a href="/" class="text-lg text-primary hover:text-secondary py-2">Home</a>
                    <a href="#about" class="text-lg text-primary hover:text-secondary py-2">About Us</a>
                    <a href="{{ route('courses.all') }}" class="text-lg text-primary hover:text-secondary py-2">Courses</a>
                    <a href="#admissions" class="text-lg text-primary hover:text-secondary py-2">Admissions</a>
                    <a href="#campus" class="text-lg text-primary hover:text-secondary py-2">Campus</a>
                    <a href="#contact" class="text-lg text-primary hover:text-secondary py-2">Contact Us</a>

                    <div class="pt-4 border-t border-gray-200 space-y-4">
                        <a href="#enroll" class="block bg-secondary text-white py-3 rounded-lg hover:bg-red-700 text-lg">Enroll Now</a>
                        <a href="{{ route('courses.all') }}" class="block border border-primary text-primary py-3 rounded-lg hover:bg-blue-50 text-lg">View Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Carousel -->
    <section id="hero-carousel" class="relative h-screen flex items-center justify-center text-white overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
        @foreach($banners as $index => $banner)
<div class="carousel-item absolute inset-0 w-full h-full {{ $index === 0 ? 'opacity-100 active' : 'opacity-0' }}" data-index="{{ $index }}">
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
                Empowering students to excel globally through industry-focused training and Internationally recognized programs.
            </p>
            <div class="flex flex-col items-center space-y-4">
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#enroll" class="bg-red-600 text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-red-700 transition-colors shadow-lg">Enroll Now</a>
                    <a href="{{ route('courses.all') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-white hover:text-blue-900 transition-colors shadow-lg">View Courses</a>
                </div>
                <a href="#abroad-opportunities" class="bg-red-600 text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-red-700 transition-colors shadow-lg">Abroad Opportunities</a>
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

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl md:text-5xl font-bold text-primary text-center mb-12">About Our College</h2>

            <div class="grid grid-cols-1 md:grid-cols-[2fr_3fr] gap-10 max-w-6xl mx-auto items-stretch">
                <div class="bg-white p-8 rounded-lg shadow-xl transform hover:scale-105 transition-transform duration-300 min-h-full flex flex-col justify-center">
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">
                        At Hewitt and Bennet International College, we're dedicated to delivering industry-focused training that empowers students for global careers. Our accreditations and partnerships highlight our commitment to high-quality, internationally recognized education.
                    </p>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        Our curriculum prepares students for success, with programs tailored to meet today's job market demands. We also offer visa application support to help graduates transition smoothly into their professional journeys worldwide.
                    </p>
                </div>

                <div class="relative flex flex-col gap-8">
                    <div class="absolute inset-y-0 left-1/2 transform -translate-x-1/2 w-px bg-gray-300 z-0 hidden sm:block"></div>

                    <div class="bg-white p-8 rounded-lg shadow-xl border-t-4 border-blue-600 transform hover:-translate-y-2 transition-transform duration-300 relative z-10 pl-8 pr-4">
                        <h3 class="text-3xl font-bold text-blue-800 mb-4">Our Vision</h3>
                        <p class="text-gray-700 leading-relaxed">
                            To become Africa's premier training institution, aligning student skills with global job market needs.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 relative z-10">
                        <div class="bg-white p-8 rounded-lg shadow-xl border-t-4 border-secondary transform hover:-translate-y-2 transition-transform duration-300 pl-8 pr-4">
                            <h3 class="text-3xl font-bold text-secondary mb-4">Our Mission</h3>
                            <p class="text-gray-700 leading-relaxed">
                                To deliver globally in-demand training programs that equip students for success.
                            </p>
                        </div>

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
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Featured</span>
                    </div>

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
                                <div class="flex items-center text-blue-600"><i class="fa-solid fa-check-circle mr-1"></i>Accredited</div>
                                <div class="flex items-center text-green-600"><i class="fa-solid fa-globe mr-1"></i>Global</div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 pb-6 mt-auto">
                        <div class="flex gap-3">
                            <a href="{{ route('course.single', $course->slug) }}" class="flex-1 text-center bg-white border border-blue-600 text-blue-600 py-2 px-4 rounded-lg font-medium hover:bg-blue-50 transition-colors">Learn More</a>
                            <a href="#" class="flex-1 text-center bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors apply-btn" data-course="{{ $course->id }}">Apply</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('courses.all') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    View All Courses <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Apply Now Modal -->
    <div id="apply-modal" class="modal">
        <div class="modal-content">
            <button id="close-modal" class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>
            <form id="enrollment-form" class="p-8 space-y-6" action="{{ route('courseregistration.store') }}" method="POST">
                @csrf
                <h2 class="text-2xl font-bold text-primary mb-6">Course Application Form</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2"><h3 class="text-lg font-semibold text-blue-800 mb-4 border-b pb-2">Personal Information</h3></div>
                    <div><label for="name" class="block text-sm font-medium text-gray-700">Full Name</label><input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></div>
                    <div><label for="email" class="block text-sm font-medium text-gray-700">Email Address</label><input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></div>
                    <div><label for="location" class="block text-sm font-medium text-gray-700">Location</label><input type="text" name="location" id="location" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></div>
                    <div><label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number</label><input type="tel" name="phoneNumber" id="phoneNumber" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></div>
                    <div class="md:col-span-2"><h3 class="text-lg font-semibold text-blue-800 mb-4 border-b pb-2">Course Information</h3></div>
                    <div><label for="course_id" class="block text-sm font-medium text-gray-700">Select Course</label><select name="course_id" id="course_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required><option value="">-- Select Course --</option>@foreach($coursese as $course)<option value="{{ $course->id }}">{{ $course->name }}</option>@endforeach</select></div>
                    <div><label for="campus_id" class="block text-sm font-medium text-gray-700">Select Campus</label><select name="campus_id" id="campus_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required><option value="">-- Select Campus --</option>@foreach($campuses as $campus)<option value="{{ $campus->id }}">{{ $campus->name }}</option>@endforeach</select></div>
                    <div><label for="startMonth" class="block text-sm font-medium text-gray-700">Start Month</label><select name="startMonth" id="startMonth" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required><option value="">-- Select Month --</option><option>January</option><option>February</option><option>March</option><option>April</option><option>May</option><option>June</option><option>July</option><option>August</option><option>September</option><option>October</option><option>November</option><option>December</option></select></div>
                    <div><label for="startYear" class="block text-sm font-medium text-gray-700">Start Year</label><select name="startYear" id="startYear" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required><option value="">-- Select Year --</option>@for($year = date('Y'); $year <= date('Y') + 5; $year++)<option value="{{ $year }}">{{ $year }}</option>@endfor</select></div>
                    <div class="md:col-span-2"><label for="modeOfLearning" class="block text-sm font-medium text-gray-700">Mode of Learning</label><select name="modeOfLearning" id="modeOfLearning" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required><option value="">-- Select Mode --</option><option value="On-Campus">On-Campus</option><option value="Online">Online</option><option value="Hybrid">Hybrid</option></select></div>
                </div>
                <div class="flex justify-end mt-8"><button type="button" id="cancel-application" class="mr-4 bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition">Cancel</button><button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">Submit Application</button></div>
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
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-20 object-contain opacity-80 hover:opacity-100 transition-opacity duration-300" title="{{ $partner->name }}">
                    </div>
                    @endforeach
                    @foreach($partners as $partner)
                    <div class="partner-slide mx-8 flex-shrink-0">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-20 object-contain opacity-80 hover:opacity-100 transition-opacity duration-300" title="{{ $partner->name }}">
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
                       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255306.42136370696!2d36.764713394531256!3d-1.0386013999999928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f4fba05870db9%3A0x9f1a0a8708f50e10!2sHewitt%20and%20Bennet%20International%20College%20Limited%20-%20Thika%20Campus!5e0!3m2!1sen!2ske!4v1757499126650!5m2!1sen!2ske" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                       <form action="{{ route('contact.store') }}" method="POST" class="space-y-6" id="contact-form">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="contact_name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                                    <input type="text" id="contact_name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                </div>
                                <div>
                                    <label for="contact_email" class="block text-gray-700 font-medium mb-2">Your Email</label>
                                    <input type="email" id="contact_email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
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
            <i class="fa-solid fa-comments text-xl"></i>
        </button>
        <div id="chatbot-container" class="hidden absolute bottom-full right-0 w-80 h-96 bg-white rounded-lg shadow-xl border border-gray-200 flex flex-col">
            <div class="p-4 flex justify-between items-center border-b border-gray-200 bg-blue-600 text-white rounded-t-lg">
                <h3 class="font-semibold">Hewitt & Bennet Chat</h3>
                <button id="close-chatbot" class="text-white hover:text-gray-200">&times;</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check for session flash messages
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#1E3A8A',
                confirmButtonText: 'Great!'
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#DC2626',
                confirmButtonText: 'OK'
            });
            @endif

            // Mobile menu functionality
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMobileMenu = document.getElementById('close-mobile-menu');
            const mobileMenu = document.getElementById('mobile-menu');

            if(mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.remove('hidden');
                    mobileMenu.classList.add('block');
                });
            }

            if(closeMobileMenu) {
                closeMobileMenu.addEventListener('click', function() {
                    mobileMenu.classList.remove('block');
                    mobileMenu.classList.add('hidden');
                });
            }

            if(mobileMenu) {
                const mobileLinks = mobileMenu.querySelectorAll('a');
                mobileLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.remove('block');
                        mobileMenu.classList.add('hidden');
                    });
                });
            }

            // Modal functionality
            const modal = document.getElementById('apply-modal');
            const applyButtons = document.querySelectorAll('.apply-btn');
            const closeModal = document.getElementById('close-modal');
            const cancelButton = document.getElementById('cancel-application');
            const courseSelect = document.getElementById('course_id');

            function openModal(courseId = '') {
                if (courseId && courseSelect) {
                    courseSelect.value = courseId;
                }
                if(modal) {
                    modal.style.display = 'flex';
                    setTimeout(() => {
                        modal.classList.add('modal-enter');
                    }, 10);
                }
            }

            function closeModalFunc() {
                if(modal) {
                    modal.classList.remove('modal-enter');
                    modal.classList.add('modal-leave');
                    setTimeout(() => {
                        modal.style.display = 'none';
                        modal.classList.remove('modal-leave');
                    }, 200);
                }
            }

            if(applyButtons.length) {
                applyButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const courseId = this.getAttribute('data-course');
                        openModal(courseId);
                    });
                });
            }

            if(closeModal) closeModal.addEventListener('click', closeModalFunc);
            if(cancelButton) cancelButton.addEventListener('click', closeModalFunc);

            if(modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModalFunc();
                    }
                });
            }

            // Handle enrollment form submission with SweetAlert
            const enrollmentForm = document.getElementById('enrollment-form');
            if(enrollmentForm) {
                enrollmentForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Submitting...',
                        text: 'Please wait while we process your application.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const formData = new FormData(enrollmentForm);

                    fetch(enrollmentForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if(response.redirected) {
                            // Success - redirect happened
                            closeModalFunc();
                            Swal.fire({
                                icon: 'success',
                                title: 'Application Submitted!',
                                text: 'Your course application has been submitted successfully! Our team will contact you shortly.',
                                confirmButtonColor: '#1E3A8A',
                                confirmButtonText: 'Great!'
                            }).then(() => {
                                enrollmentForm.reset();
                            });
                            return Promise.reject('redirect');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if(data && data.success === false) {
                            throw new Error(data.message || 'Submission failed');
                        } else {
                            closeModalFunc();
                            Swal.fire({
                                icon: 'success',
                                title: 'Application Submitted!',
                                text: data.message || 'Your course application has been submitted successfully! Our team will contact you shortly.',
                                confirmButtonColor: '#1E3A8A',
                                confirmButtonText: 'Great!'
                            }).then(() => {
                                enrollmentForm.reset();
                            });
                        }
                    })
                    .catch(error => {
                        if(error === 'redirect') return;
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Error',
                            text: 'There was an error submitting your application. Please try again or contact us directly.',
                            confirmButtonColor: '#DC2626',
                            confirmButtonText: 'OK'
                        });
                        console.error('Error:', error);
                    });
                });
            }

            // Handle contact form submission
            const contactForm = document.getElementById('contact-form');
            if(contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Sending Message...',
                        text: 'Please wait while we send your message.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const formData = new FormData(contactForm);

                    fetch(contactForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if(response.redirected) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Message Sent!',
                                text: 'Thank you for your message. We will get back to you soon!',
                                confirmButtonColor: '#1E3A8A',
                                confirmButtonText: 'Great!'
                            }).then(() => {
                                contactForm.reset();
                            });
                            return Promise.reject('redirect');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if(data && data.success === false) {
                            throw new Error(data.message || 'Failed to send message');
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Message Sent!',
                                text: data.message || 'Thank you for your message. We will get back to you soon!',
                                confirmButtonColor: '#1E3A8A',
                                confirmButtonText: 'Great!'
                            }).then(() => {
                                contactForm.reset();
                            });
                        }
                    })
                    .catch(error => {
                        if(error === 'redirect') return;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error sending your message. Please try again or call us directly.',
                            confirmButtonColor: '#DC2626',
                            confirmButtonText: 'OK'
                        });
                        console.error('Error:', error);
                    });
                });
            }

            // Carousel functionality
            let currentSlide = 0;
            const slides = document.querySelectorAll('.carousel-item');
            const dots = document.querySelectorAll('.dot');
            const prevButton = document.getElementById('carousel-prev');
            const nextButton = document.getElementById('carousel-next');

            if(slides.length && dots.length) {
                function showSlide(index) {
                    slides.forEach(slide => {
                        slide.classList.remove('opacity-100');
                        slide.classList.add('opacity-0');
                    });
                    dots.forEach(dot => {
                        dot.classList.remove('active-dot');
                        dot.classList.add('bg-opacity-50');
                    });
                    slides[index].classList.remove('opacity-0');
                    slides[index].classList.add('opacity-100');
                    dots[index].classList.add('active-dot');
                    dots[index].classList.remove('bg-opacity-50');
                    currentSlide = index;
                }

                function nextSlide() {
                    let nextIndex = (currentSlide + 1) % slides.length;
                    showSlide(nextIndex);
                }

                function prevSlide() {
                    let prevIndex = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(prevIndex);
                }

                if(prevButton) prevButton.addEventListener('click', prevSlide);
                if(nextButton) nextButton.addEventListener('click', nextSlide);

                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        showSlide(index);
                    });
                });

                let slideInterval = setInterval(nextSlide, 7000);
                const carousel = document.getElementById('hero-carousel');
                if(carousel) {
                    carousel.addEventListener('mouseenter', () => {
                        clearInterval(slideInterval);
                    });
                    carousel.addEventListener('mouseleave', () => {
                        slideInterval = setInterval(nextSlide, 7000);
                    });
                }
            }

            // Chatbot functionality
            const chatbotToggle = document.getElementById('chatbot-toggle');
            const closeChatbot = document.getElementById('close-chatbot');
            const chatbotContainer = document.getElementById('chatbot-container');
            const chatbotMessages = document.getElementById('chatbot-messages');
            const chatbotInput = document.getElementById('chatbot-input');
            const chatbotSend = document.getElementById('chatbot-send');

            if(chatbotToggle) {
                chatbotToggle.addEventListener('click', function() {
                    chatbotContainer.classList.toggle('hidden');
                });
            }

            if(closeChatbot) {
                closeChatbot.addEventListener('click', function() {
                    chatbotContainer.classList.add('hidden');
                });
            }

            function displayMessage(text, sender) {
                const msg = document.createElement('div');
                msg.classList.add('message', sender);
                msg.textContent = text;
                chatbotMessages.appendChild(msg);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            if(chatbotSend) {
                chatbotSend.addEventListener('click', () => {
                    const text = chatbotInput.value.trim();
                    if (!text) return;
                    displayMessage(text, 'user');
                    chatbotInput.value = '';
                    setTimeout(() => displayMessage("Thank you for your interest in Hewitt and Bennet International College! Our team will contact you shortly with more information about our programs and admission process.", 'bot'), 500);
                });
            }

            if(chatbotInput) {
                chatbotInput.addEventListener('keypress', e => {
                    if (e.key === 'Enter') chatbotSend.click();
                });
            }
        });
    </script>
</body>
</html>
