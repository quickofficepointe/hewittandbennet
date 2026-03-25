<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hewitt And Bennet International College - Leading Education Provider</title>
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
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">

    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .mobile-menu-transition {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        .carousel-item {
            transition: opacity 0.5s ease-in-out;
        }
        .chatbot-container {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo and Brand -->
            <div class="flex items-center space-x-3">
                <img src="{{asset ('assets/img/logo_nobg.png') }}" alt="Hewitt and Bennet Logo" class="h-12 sm:h-14">
                <span class="text-xl sm:text-2xl font-bold text-primary leading-tight">
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
                    <a href="/#campus" class="text-lg text-primary hover:text-secondary transition-colors">Campus</a>
                    <a href="{{ route('news.event') }}" class="text-lg text-primary hover:text-secondary transition-colors">News</a>
                    <a href="/#contact" class="text-lg text-primary hover:text-secondary transition-colors">Contact Us</a>
                </div>

                <div class="flex space-x-4 ml-6">
                    <a href="#enroll" class="bg-secondary text-white px-5 py-2.5 rounded-lg hover:bg-red-700 text-lg transition-colors">Enroll Now</a>
                    <a href="{{ route('courses.all') }}" class="border border-primary text-primary px-5 py-2.5 rounded-lg hover:bg-blue-50 text-lg transition-colors">View Courses</a>
                </div>
            </div>

            <!-- Mobile Toggle -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-primary">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </nav>

        <!-- Mobile Navigation -->
        <div x-show="mobileOpen" x-transition:enter="mobile-menu-transition"
             x-transition:enter-start="-translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="mobile-menu-transition"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="-translate-y-full opacity-0"
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
                    <a href="/" class="text-lg text-primary hover:text-secondary py-2">Home</a>
                    <a href="/#about" class="text-lg text-primary hover:text-secondary py-2">About Us</a>
                    <a href="{{ route('courses.all') }}" class="text-lg text-primary hover:text-secondary py-2">Courses</a>
                    <a href="/#admissions" class="text-lg text-primary hover:text-secondary py-2">Admissions</a>
                    <a href="/#campus" class="text-lg text-primary hover:text-secondary py-2">Campus</a>
                    <a href="/#contact" class="text-lg text-primary hover:text-secondary py-2">Contact Us</a>

                    <div class="pt-4 border-t border-gray-200 space-y-4">
                        <a href="#enroll" class="block bg-secondary text-white py-3 rounded-lg hover:bg-red-700 text-lg">Enroll Now</a>
                        <a href="{{ route('courses.all') }}" class="block border border-primary text-primary py-3 rounded-lg hover:bg-blue-50 text-lg">View Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Content will be injected here -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-12">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Footer content remains the same as your original -->
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
        // Alpine.js component for mobile menu
        document.addEventListener('alpine:init', () => {
            Alpine.data('navigation', () => ({
                mobileOpen: false,
            }))
        });
    </script>
</body>
</html>
