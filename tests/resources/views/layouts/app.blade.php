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

    @yield('content')

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
        // Mobile Menu Toggle
        const menu = document.getElementById('mobile-menu');
        const openBtn = document.getElementById('mobile-menu-toggle');
        const closeBtn = document.getElementById('mobile-menu-close');

        openBtn.addEventListener('click', () => {
            menu.classList.remove('-translate-y-full', 'opacity-0');
            menu.classList.add('translate-y-0', 'opacity-100');
        });

        closeBtn.addEventListener('click', () => {
            menu.classList.add('-translate-y-full', 'opacity-0');
            menu.classList.remove('translate-y-0', 'opacity-100');
        });

        // Chatbot Toggle
        const chatbotToggle = document.getElementById('chatbot-toggle');
        const chatbotContainer = document.getElementById('chatbot-container');
        const chatbotClose = document.getElementById('chatbot-close');
        const chatbotMessages = document.getElementById('chatbot-messages');
        const chatbotInput = document.getElementById('chatbot-input');
        const chatbotSend = document.getElementById('chatbot-send');

        // Function to toggle chatbot visibility
        function toggleChatbot() {
            chatbotContainer.classList.toggle('active');
        }

        // Function to display a message
        function displayMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message');
            messageDiv.classList.add(sender); // 'user' or 'bot'
            messageDiv.textContent = text;
            chatbotMessages.appendChild(messageDiv);
            // Scroll to the bottom
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }

        // Function to handle sending message
        function sendMessage() {
            const messageText = chatbotInput.value.trim();
            if (messageText === '') return; // Don't send empty messages

            displayMessage(messageText, 'user');
            chatbotInput.value = ''; // Clear input field

            // Simulate static reply from chatbot
            setTimeout(() => {
                displayMessage("Thank you for your message! Our team will get back to you shortly.", 'bot');
            }, 1000); // Reply after 1 second
        }

        // Event listeners
        chatbotToggle.addEventListener('click', toggleChatbot);
        chatbotClose.addEventListener('click', toggleChatbot);
        chatbotSend.addEventListener('click', sendMessage);

        // Allow sending message with Enter key
        chatbotInput.addEventListener('keypress', (event) => {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });

        // Hero Carousel Functionality
        const carouselItems = document.querySelectorAll('.carousel-item');
        const carouselPrevBtn = document.getElementById('carousel-prev');
        const carouselNextBtn = document.getElementById('carousel-next');
        const carouselDotsContainer = document.getElementById('carousel-dots');
        const carouselDots = document.querySelectorAll('.dot');
        let currentIndex = 0;
        let autoSlideInterval;
        const slideDuration = 7000; // 7 seconds for auto-slide

        function showSlide(index) {
            // Ensure index wraps around
            if (index >= carouselItems.length) {
                currentIndex = 0;
            } else if (index < 0) {
                currentIndex = carouselItems.length - 1;
            } else {
                currentIndex = index;
            }

            // Hide all items and deactivate all dots
            carouselItems.forEach(item => {
                item.classList.remove('opacity-100');
                item.classList.add('opacity-0');
            });
            carouselDots.forEach(dot => dot.classList.remove('active-dot'));

            // Show the current item and activate its dot
            carouselItems[currentIndex].classList.remove('opacity-0');
            carouselItems[currentIndex].classList.add('opacity-100');
            carouselDots[currentIndex].classList.add('active-dot');

            // Pause/play video if present
            carouselItems.forEach((item, idx) => {
                const video = item.querySelector('video');
                if (video) {
                    if (idx === currentIndex) {
                        video.play();
                    } else {
                        video.pause();
                        video.currentTime = 0; // Reset video to start
                    }
                }
            });
        }

        function nextSlide() {
            showSlide(currentIndex + 1);
        }

        function prevSlide() {
            showSlide(currentIndex - 1);
        }

        function startAutoSlide() {
            stopAutoSlide(); // Clear any existing interval
            autoSlideInterval = setInterval(nextSlide, slideDuration);
        }

        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        // Event Listeners
        carouselPrevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoSlide(); // Stop auto-slide on manual interaction
            startAutoSlide(); // Restart after interaction
        });

        carouselNextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoSlide(); // Stop auto-slide on manual interaction
            startAutoSlide(); // Restart after interaction
        });

        carouselDots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                const dotIndex = parseInt(e.target.dataset.index); // Assuming data-index is added to dots
                showSlide(dotIndex);
                stopAutoSlide();
                startAutoSlide();
            });
        });

        // Initialize carousel on load
        document.addEventListener('DOMContentLoaded', () => {
            // Add data-index to dots for easier lookup in JS
            carouselDots.forEach((dot, index) => {
                dot.setAttribute('data-index', index);
            });

            showSlide(0); // Show the first slide
            startAutoSlide(); // Start auto-sliding
        });

        // Optional: Pause auto-slide when tab is not active
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopAutoSlide();
            } else {
                startAutoSlide();
            }
        });

        // Enroll Modal Functionality
        const enrollButtons = document.querySelectorAll('a[href="#enroll"]');
        const enrollModal = document.getElementById('enroll-modal');
        const modalCloseBtn = document.getElementById('modal-close');
        const enrollmentForm = document.getElementById('enrollment-form');

        // Function to open modal
        function openEnrollModal(event) {
            event.preventDefault(); // Prevent default link behavior
            enrollModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevent scrolling body when modal is open
        }

        // Function to close modal
        function closeEnrollModal() {
            enrollModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            enrollmentForm.reset(); // Clear form fields on close
        }

        // Add event listeners to all "Enroll Now" buttons
        enrollButtons.forEach(button => {
            button.addEventListener('click', openEnrollModal);
        });

        // Event listener for modal close button
        modalCloseBtn.addEventListener('click', closeEnrollModal);

        // Close modal if clicked outside the content (on the overlay)
        enrollModal.addEventListener('click', (event) => {
            if (event.target === enrollModal) {
                closeEnrollModal();
            }
        });

        // Handle form submission
        enrollmentForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent actual form submission

            // For now, just log the form data and simulate success
            const formData = new FormData(enrollmentForm);
            const data = {};
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            console.log('Enrollment Form Data:', data);

            Swal.fire({
                title: 'Success!'
                , text: 'Thank you for your application! Our admissions team will contact you shortly to confirm.'
                , icon: 'success'
                , confirmButtonText: 'OK'
                , customClass: {
                    confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'
                }
                , buttonsStyling: false // Important to disable default SweetAlert button styling if using custom classes
            }).then(() => {

                closeEnrollModal();
            });
        });

    </script>
</body>
</html>
