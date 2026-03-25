<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/img/hbiclogo.jpeg') }}" type="image/png">
    <title>Hewitt and Bennet International College | Staff Dashboard 2026</title>

    <!-- Google Fonts - Modern Font Stack -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                        'heading': ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        'primary': {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        'gray': {
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            300: '#d1d5db',
                            400: '#9ca3af',
                            500: '#6b7280',
                            600: '#4b5563',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                        },
                        'accent': {
                            purple: '#8b5cf6',
                            pink: '#ec489a',
                            teal: '#14b8a6',
                            orange: '#f97316',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        }
                    },
                    backdropBlur: {
                        xs: '2px',
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f8fafc 100%);
        }

        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sidebar Transitions */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Glassmorphism Effects */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Modern DataTables Styling */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        table.dataTable {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        table.dataTable thead th {
            border-bottom: 2px solid #e2e8f0;
            background: #f8fafc;
            padding: 1rem;
            font-weight: 600;
            color: #1e293b;
        }

        table.dataTable tbody tr {
            transition: all 0.2s;
        }

        table.dataTable tbody tr:hover {
            background-color: #f1f5f9;
            transform: scale(1.01);
        }

        table.dataTable tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Modern Buttons */
        .dt-buttons button {
            border-radius: 12px !important;
            padding: 0.5rem 1rem !important;
            font-weight: 500 !important;
            transition: all 0.2s !important;
            margin: 0 0.25rem !important;
            border: none !important;
        }

        .dt-buttons button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Summernote Modern Styling */
        .note-editor {
            border-radius: 16px !important;
            border: 1px solid #e2e8f0 !important;
            overflow: hidden;
        }

        .note-toolbar {
            background: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        /* Hide mobile sidebar by default */
        #mobile-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #mobile-sidebar.mobile-active {
            transform: translateX(0);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .dt-buttons {
                flex-wrap: wrap !important;
                gap: 0.5rem !important;
            }

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                text-align: left !important;
                margin-bottom: 1rem !important;
            }
        }
    </style>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
</head>

<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Mobile Header -->
        <div class="lg:hidden fixed top-0 left-0 right-0 bg-white/80 backdrop-blur-md z-50 border-b border-gray-100">
            <div class="flex justify-between items-center px-6 py-4">
                <button id="mobile-sidebar-toggle" class="text-gray-700 hover:text-primary-600 transition">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC" class="w-10 h-10 rounded-full object-cover border-2 border-primary-500">
                    <span class="font-bold text-gray-800">HBIC Staff</span>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-600 hover:text-red-500 transition">
                    <i class="fas fa-sign-out-alt text-xl"></i>
                </a>
            </div>
        </div>

        <!-- Desktop Header -->
        <header class="hidden lg:block bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-gray-100">
            <div class="px-8 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <button id="desktop-sidebar-toggle" class="text-gray-600 hover:text-primary-600 transition p-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">@yield('pageTitle', 'Dashboard')</h1>
                            <p class="text-xs text-gray-500">Staff Control Panel</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-3 px-4 py-2 rounded-xl bg-gray-50">
                        <i class="fas fa-user-circle text-gray-500 text-xl"></i>
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->username }}</span>
                    </div>
                    <a href="/" class="text-gray-600 hover:text-primary-600 transition flex items-center space-x-2">
                        <i class="fas fa-globe"></i>
                        <span class="text-sm">Website</span>
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-600 hover:text-red-500 transition flex items-center space-x-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="text-sm">Logout</span>
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </header>

        <div class="flex flex-1 pt-16 lg:pt-0">
            <!-- Desktop Sidebar -->
            <aside id="desktop-sidebar" class="fixed lg:relative z-30 bg-white shadow-xl sidebar-transition w-72 lg:w-64 flex-shrink-0 h-[calc(100vh-4rem)] lg:h-screen overflow-y-auto">
                <div class="sticky top-0 bg-white z-10">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC" class="w-12 h-12 rounded-full object-cover border-2 border-primary-500 shadow-lg">
                            <div>
                                <h3 class="font-bold text-gray-800">{{ Auth::user()->username }}</h3>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="p-4 space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('staff.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-tachometer-alt w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600 font-medium">Dashboard</span>
                    </a>

                    <!-- Admissions Section -->
                    <div class="pt-4 pb-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4">Admissions</p>
                    </div>
                    <a href="{{ route('staff.onlineregister') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-user-edit w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">Online Registration</span>
                    </a>
                    <a href="{{ route('students.create') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-graduation-cap w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">Student Onboarding</span>
                    </a>
                    <a href="{{ route('registrationforms.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-clipboard-list w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">Online Forms</span>
                    </a>

                    <!-- Finance Section -->
                    <div class="pt-4 pb-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4">Finance</p>
                    </div>
                    <a href="{{ route('Paymentreceipt.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-receipt w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">Payments</span>
                    </a>

                    <!-- Content Section -->
                    <div class="pt-4 pb-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4">Content Management</p>
                    </div>
                    <a href="{{ route('gallery.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-camera-retro w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">Gallery</span>
                    </a>
                    <a href="{{ route('newsandevent.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-calendar-alt w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">News & Events</span>
                    </a>
                    <a href="{{ route('testimonials.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-quote-right w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">Testimonials</span>
                    </a>
                    <a href="{{ route('index.review') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-star-half-alt w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">Reviews</span>
                    </a>

                    <!-- Marketing Section -->
                    <div class="pt-4 pb-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4">Marketing</p>
                    </div>
                    <a href="{{ route('hewitt_banners.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fas fa-bullseye w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">Campaigns</span>
                    </a>
                    <a href="{{ route('tiktok-videos.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
                        <i class="fab fa-tiktok w-5 text-gray-400 group-hover:text-primary-600"></i>
                        <span class="text-gray-700 group-hover:text-primary-600">Social Media</span>
                    </a>

                    <!-- Administration Section -->
                    <!-- Administration Section -->
<div class="pt-4 pb-2">
    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4">Administration</p>
</div>
<a href="{{ route('index.departments') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
    <i class="fas fa-building w-5 text-gray-400 group-hover:text-primary-600"></i>
    <span class="text-gray-700 group-hover:text-primary-600">Departments</span>
</a>
<a href="{{ route('index.cdpert') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
    <i class="fas fa-book w-5 text-gray-400 group-hover:text-primary-600"></i>
    <span class="text-gray-700 group-hover:text-primary-600">Courses</span>
</a>
<a href="{{ route('campuses.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
    <i class="fas fa-university w-5 text-gray-400 group-hover:text-primary-600"></i>
    <span class="text-gray-700 group-hover:text-primary-600">Campuses</span>
</a>
<a href="{{ route('teams.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
    <i class="fas fa-users w-5 text-gray-400 group-hover:text-primary-600"></i>
    <span class="text-gray-700 group-hover:text-primary-600">Team Management</span>
</a>
<a href="{{ route('partners.show') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
    <i class="fas fa-handshake w-5 text-gray-400 group-hover:text-primary-600"></i>
    <span class="text-gray-700 group-hover:text-primary-600">Partners</span>
</a>
<!-- CONTACT MESSAGES LINK - ADD THIS -->
<a href="{{ route('contact.messages.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition group">
    <i class="fas fa-envelope w-5 text-gray-400 group-hover:text-primary-600"></i>
    <span class="text-gray-700 group-hover:text-primary-600">Contact Messages</span>
    @php
        $unreadCount = App\Models\Contact::where('is_read', false)->count();
    @endphp
    @if($unreadCount > 0)
        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $unreadCount }}</span>
    @endif
</a>
                </nav>
            </aside>

            <!-- Mobile Sidebar (Sliding) -->
            <div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 bg-white w-72 shadow-2xl overflow-y-auto">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC" class="w-12 h-12 rounded-full object-cover border-2 border-primary-500">
                            <div>
                                <h3 class="font-bold text-gray-800">{{ Auth::user()->username }}</h3>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                        <button id="close-mobile-sidebar" class="text-gray-400 hover:text-red-500">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                <nav class="p-4 space-y-1">
                    <!-- Same navigation links as desktop sidebar (copy the same structure) -->
                    <a href="{{ route('staff.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition">
                        <i class="fas fa-tachometer-alt w-5 text-gray-400"></i>
                        <span class="text-gray-700">Dashboard</span>
                    </a>
                    <div class="pt-4 pb-2"><p class="text-xs font-semibold text-gray-400 px-4">Admissions</p></div>
                    <a href="{{ route('staff.onlineregister') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-user-edit w-5 text-gray-400"></i><span>Online Registration</span></a>
                    <a href="{{ route('students.create') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-graduation-cap w-5 text-gray-400"></i><span>Student Onboarding</span></a>
                    <a href="{{ route('registrationforms.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-clipboard-list w-5 text-gray-400"></i><span>Online Forms</span></a>

                    <div class="pt-4 pb-2"><p class="text-xs font-semibold text-gray-400 px-4">Finance</p></div>
                    <a href="{{ route('Paymentreceipt.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-receipt w-5 text-gray-400"></i><span>Payments</span></a>

                    <div class="pt-4 pb-2"><p class="text-xs font-semibold text-gray-400 px-4">Content</p></div>
                    <a href="{{ route('gallery.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-camera-retro w-5 text-gray-400"></i><span>Gallery</span></a>
                    <a href="{{ route('newsandevent.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-calendar-alt w-5 text-gray-400"></i><span>News & Events</span></a>
                    <a href="{{ route('testimonials.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-quote-right w-5 text-gray-400"></i><span>Testimonials</span></a>
                    <a href="{{ route('index.review') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-star-half-alt w-5 text-gray-400"></i><span>Reviews</span></a>

                    <div class="pt-4 pb-2"><p class="text-xs font-semibold text-gray-400 px-4">Marketing</p></div>
                    <a href="{{ route('hewitt_banners.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-bullseye w-5 text-gray-400"></i><span>Campaigns</span></a>
                    <a href="{{ route('tiktok-videos.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fab fa-tiktok w-5 text-gray-400"></i><span>Social Media</span></a>

                   <div class="pt-4 pb-2"><p class="text-xs font-semibold text-gray-400 px-4">Administration</p></div>
<a href="{{ route('index.departments') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-building w-5 text-gray-400"></i><span>Departments</span></a>
<a href="{{ route('index.cdpert') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-book w-5 text-gray-400"></i><span>Courses</span></a>
<a href="{{ route('campuses.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-university w-5 text-gray-400"></i><span>Campuses</span></a>
<a href="{{ route('teams.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-users w-5 text-gray-400"></i><span>Team Management</span></a>
<a href="{{ route('partners.show') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition"><i class="fas fa-handshake w-5 text-gray-400"></i><span>Partners</span></a>
<!-- CONTACT MESSAGES LINK - ADD THIS -->
<a href="{{ route('contact.messages.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-primary-50 transition">
    <i class="fas fa-envelope w-5 text-gray-400"></i>
    <span>Contact Messages</span>
    @php
        $unreadCount = App\Models\Contact::where('is_read', false)->count();
    @endphp
    @if($unreadCount > 0)
        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $unreadCount }}</span>
    @endif
</a>

                </nav>
            </div>

            <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden opacity-0 pointer-events-none transition-opacity duration-300"></div>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8 bg-gradient-to-br from-gray-50 to-gray-100">
                <div class="max-w-7xl mx-auto">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-primary-700 to-primary-900 bg-clip-text text-transparent font-heading">@yield('pageTitle', 'Dashboard')</h1>
                        <p class="text-gray-500 mt-1">Welcome back, {{ Auth::user()->username }}!</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-6 text-center">
            <p class="text-sm text-gray-500">
                <strong>&copy; 2026 <a href="https://hewittandbenet.edu" class="text-primary-600 hover:text-primary-700">Hewett and Benet International College</a></strong>. All rights reserved.
            </p>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            // Sidebar Toggle Functionality
            let desktopSidebarOpen = true;
            const desktopSidebar = $('#desktop-sidebar');
            const desktopToggle = $('#desktop-sidebar-toggle');

            if (desktopToggle.length) {
                desktopToggle.on('click', function() {
                    desktopSidebarOpen = !desktopSidebarOpen;
                    if (desktopSidebarOpen) {
                        desktopSidebar.removeClass('w-20').addClass('w-64');
                        desktopSidebar.find('span').removeClass('hidden');
                        desktopSidebar.find('.px-4').removeClass('justify-center');
                    } else {
                        desktopSidebar.removeClass('w-64').addClass('w-20');
                        desktopSidebar.find('span').addClass('hidden');
                    }
                });
            }

            // Mobile Sidebar
            const mobileSidebar = $('#mobile-sidebar');
            const mobileOverlay = $('#mobile-overlay');
            const mobileToggle = $('#mobile-sidebar-toggle');
            const closeMobile = $('#close-mobile-sidebar');

            function openMobileSidebar() {
                mobileSidebar.addClass('mobile-active');
                mobileOverlay.removeClass('opacity-0 pointer-events-none').addClass('opacity-100');
                $('body').css('overflow', 'hidden');
            }

            function closeMobileSidebar() {
                mobileSidebar.removeClass('mobile-active');
                mobileOverlay.removeClass('opacity-100').addClass('opacity-0 pointer-events-none');
                $('body').css('overflow', '');
            }

            if (mobileToggle.length) {
                mobileToggle.on('click', openMobileSidebar);
            }
            if (closeMobile.length) {
                closeMobile.on('click', closeMobileSidebar);
            }
            if (mobileOverlay.length) {
                mobileOverlay.on('click', closeMobileSidebar);
            }

            // Summernote Initialization
            $('#content, #content1').summernote({
                placeholder: 'Write your content here...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        // Handle image upload
                        console.log('Image uploaded:', files);
                    }
                }
            });

            // DataTables Initialization
            if ($('#registeredUsersTable').length) {
                $('#registeredUsersTable').DataTable({
                    responsive: true,
                    dom: '<"flex flex-col md:flex-row md:items-center md:justify-between mb-6"<"mb-4 md:mb-0"l>B<"mt-4 md:mt-0"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between mt-6"<"mb-4 md:mb-0"i><p>>',
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            text: '<i class="fas fa-copy mr-2"></i>Copy',
                            className: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl transition',
                            titleAttr: 'Copy to clipboard'
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fas fa-file-excel mr-2"></i>Excel',
                            className: 'bg-green-50 hover:bg-green-100 text-green-700 px-4 py-2 rounded-xl transition',
                            titleAttr: 'Export to Excel'
                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fas fa-file-csv mr-2"></i>CSV',
                            className: 'bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-xl transition',
                            titleAttr: 'Export to CSV'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fas fa-file-pdf mr-2"></i>PDF',
                            className: 'bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-xl transition',
                            titleAttr: 'Export to PDF',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            customize: function(doc) {
                                doc.defaultStyle.fontSize = 10;
                                doc.styles.tableHeader.fontSize = 11;
                                doc.styles.title.fontSize = 16;
                            }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print mr-2"></i>Print',
                            className: 'bg-purple-50 hover:bg-purple-100 text-purple-700 px-4 py-2 rounded-xl transition',
                            titleAttr: 'Print table'
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fas fa-columns mr-2"></i>Columns',
                            className: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl transition',
                            titleAttr: 'Column visibility'
                        }
                    ],
                    lengthMenu: [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
                    pageLength: 25,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search records...",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>',
                            next: '<i class="fas fa-angle-right"></i>'
                        }
                    },
                    initComplete: function() {
                        $('.dt-buttons').addClass('flex flex-wrap gap-2');
                    }
                });
            }

            // Handle window resize for responsive sidebar
            $(window).on('resize', function() {
                if ($(window).width() >= 1024) {
                    closeMobileSidebar();
                }
            });

            // Current year for footer
            $('#current-year').text(new Date().getFullYear());
        });
    </script>
</body>
</html>
