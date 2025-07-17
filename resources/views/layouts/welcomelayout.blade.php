<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Dynamic Meta Tags for SEO -->
    <title>@yield('meta-title', 'Hewitt And Bennet International College - Leading Education Provider')</title>
    <meta name="description" content="@yield('meta-description', 'Hewitt And Bennet International College offers top-notch courses in healthcare, caregiving, and more across various professional fields.')">
    <meta name="keywords" content="@yield('meta-keywords', 'Hewitt And Bennet, International College, education, caregiving, nursing assistant, health care')">
    <meta name="author" content="@yield('meta-author', 'Hewitt And Bennet International College')">

    <!-- Favicon and Touch Icons -->
    <link rel="icon" href="{{ asset('assets/img/hewittlogo.jpeg') }}" type="image/x-icon"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/hewittlogo.jpeg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/hewittlogo.jpeg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/hewittlogo.jpeg') }}">
    <link rel="manifest" href="{{ asset('assets/img/hewittlogo.jpeg') }}">

    <!-- Open Graph Meta Tags for Social Media Sharing -->
    <meta property="og:type" content="@yield('og-type', 'website')">
    <meta property="og:title" content="@yield('meta-title', 'Hewitt And Bennet International College')">
    <meta property="og:description" content="@yield('meta-description', 'Explore high-quality courses in caregiving, nursing, and more at Hewitt And Bennet International College.')">
    <meta property="og:image" content="@yield('meta-image', asset('assets/img/hewittlogo.jpeg'))">
    <meta property="og:url" content="@yield('meta-url', url()->current())">
    <meta property="og:site_name" content="Hewitt And Bennet International College">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta-title', 'Hewitt And Bennet International College')">
    <meta name="twitter:description" content="@yield('meta-description', 'Hewitt And Bennet International College offers industry-leading courses to support your career aspirations.')">
    <meta name="twitter:image" content="@yield('meta-image', asset('assets/img/hewittlogo.jpeg'))">
    <meta name="twitter:site" content="@HewittBennetIntl">
    <meta name="twitter:creator" content="@HewittBennetIntl">

    <!-- Preconnect and Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Quicksand:wght@600;700&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
     <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>

</head>
<body>

    <section>
        <!-- Error and Success Alerts -->
        @if($errors->any())
            <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white text-sm p-4 rounded shadow-lg z-50">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <script>
                setTimeout(() => document.querySelector('.fixed').remove(), 3000);
            </script>
        @endif

        @if(session('success'))
            <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-sm p-4 rounded shadow-lg z-50">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => document.querySelector('.fixed').remove(), 3000);
            </script>
        @endif

        <!-- Topbar Start -->
        <div class="bg-gray-100 py-2 hidden lg:block">
            <div class="container mx-auto flex justify-between items-center text-sm">
                <div class="flex space-x-6">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-map-marker-alt text-blue-500"></i>
                        <span>Nairobi, Kenya</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="far fa-clock text-blue-500"></i>
                        <span>Mon - Fri: 08.00 AM - 05.00 PM</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="far fa-clock text-blue-500"></i>
                        <span>Sat: 08.00 AM - 12.00 PM</span>
                    </div>
                </div>
                <div class="flex space-x-6">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-phone-alt text-blue-500"></i>
                        <span>Thika: 0700207013</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-phone-alt text-blue-500"></i>
                        <span>Buruburu: 070197819</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-phone-alt text-blue-500"></i>
                        <span>Town: 0792168754</span>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="https://www.facebook.com" target="_blank" class="text-blue-500 hover:text-blue-700">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=+254713490768&text=Hello" target="_blank" class="text-green-500 hover:text-green-700">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="text-blue-400 hover:text-blue-600">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com" target="_blank" class="text-blue-800 hover:text-blue-900">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="text-pink-500 hover:text-pink-700">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- Topbar End -->
<!-- Topbar End -->
<!-- Navbar Start -->
<nav class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4">
        <!-- Logo for Large Screens (left-aligned) and Small Screens (centered) -->
        <div class="lg:w-auto w-full flex justify-start items-center">
            <a href="/" class="lg:w-auto w-full text-center lg:text-left">
                <img src="{{ asset('assets/img/hewittlogo.jpeg') }}" alt="Your Logo" class="h-8 mx-auto lg:ml-0 lg:mr-auto">
            </a>
        </div>
 <!-- Navbar Toggle Button for Mobile -->
 <button class="lg:hidden text-gray-500" id="navbar-toggle">
    <i class="fas fa-bars"></i>
</button>
        <!-- Navbar Links -->
        <div class="flex items-center space-x-6">
            <ul id="navbar-menu" class="hidden lg:flex space-x-6 text-center">
                <li><a href="/" class="hover:text-blue-500">Home</a></li>
                <li class="relative group">
                    <a href="#" class="hover:text-blue-500">About</a>
                    <ul class="absolute left-0 hidden group-hover:block bg-white shadow-md mt-2 py-2">
                        <li><a href="{{ route('hewitt_director.about') }}" class="block px-4 py-2 hover:bg-gray-100">Message from Director</a></li>
                        <li><a href="{{ route('hewitt_principal.about') }}" class="block px-4 py-2 hover:bg-gray-100">Message from Principal</a></li>
                        <li><a href="{{ route('hewitt_dean.about') }}" class="block px-4 py-2 hover:bg-gray-100">Message from Dean</a></li>
                        <li><a href="{{ route('hewitt_Captain.about') }}" class="block px-4 py-2 hover:bg-gray-100">Message from Captain</a></li>
                    </ul>
                </li>
                <li class="relative group">
                    <a href="#" class="hover:text-blue-500">Courses</a>
                    <ul class="absolute left-0 hidden group-hover:block bg-white shadow-md mt-2 py-2">
                        <li><a href="{{ route('hewitt_Captain.caregivercourses') }}" class="block px-4 py-2 hover:bg-gray-100">Caregiver Certification Courses</a></li>
                        <li><a href="{{ route('hewitt_Captain.cnacourses') }}" class="block px-4 py-2 hover:bg-gray-100">Community Health Assistant Course</a></li>
                        <li><a href="{{ route('hewitt_Captain.hosipitality') }}" class="block px-4 py-2 hover:bg-gray-100">Hospitality Course</a></li>
                        <li><a href="{{ route('hewitt_Captain.othercourses') }}" class="block px-4 py-2 hover:bg-gray-100">Other Courses</a></li>
                    </ul>
                </li>
                <li class="relative group">
                    <a href="#" class="hover:text-blue-500">Students</a>
                    <ul class="absolute left-0 hidden group-hover:block bg-white shadow-md mt-2 py-2">
                        <li><a href="{{ route('student.gallery') }}" class="block px-4 py-2 hover:bg-gray-100">Gallery</a></li>
                        <li><a href="{{ route('registration.create') }}" class="block px-4 py-2 hover:bg-gray-100">Online Applications</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('workabroad.index') }}" class="hover:text-blue-500">WorkAbroad</a></li>
                <li><a href="{{ route('news.event') }}" class="hover:text-blue-500">News and Events</a></li>
                <li><a href="/#contact" class="hover:text-blue-500">Contact</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-blue-500">Portal</a></li>
            </ul>
        </div>
    </div>


</nav>
<!-- Navbar End -->

<!-- Mobile Menu -->
<ul id="mobile-menu" class="lg:hidden absolute top-16 left-0 right-0 bg-white shadow-md hidden">
    <li><a href="/" class="block px-4 py-2 hover:bg-gray-100">Home</a></li>
    <li class="relative group">
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">About</a>
        <ul class="absolute left-0 hidden group-hover:block bg-white shadow-md mt-2 py-2">
            <li><a href="{{ route('hewitt_director.about') }}" class="block px-4 py-2 hover:bg-gray-100">Message from Director</a></li>
            <li><a href="{{ route('hewitt_principal.about') }}" class="block px-4 py-2 hover:bg-gray-100">Message from Principal</a></li>
            <li><a href="{{ route('hewitt_dean.about') }}" class="block px-4 py-2 hover:bg-gray-100">Message from Dean</a></li>
            <li><a href="{{ route('hewitt_Captain.about') }}" class="block px-4 py-2 hover:bg-gray-100">Message from Captain</a></li>
        </ul>
    </li>
    <li class="relative group">
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Courses</a>
        <ul class="absolute left-0 hidden group-hover:block bg-white shadow-md mt-2 py-2">
            <li><a href="{{ route('hewitt_Captain.caregivercourses') }}" class="block px-4 py-2 hover:bg-gray-100">Caregiver Certification Courses</a></li>
            <li><a href="{{ route('hewitt_Captain.cnacourses') }}" class="block px-4 py-2 hover:bg-gray-100">Community Health Assistant Course</a></li>
            <li><a href="{{ route('hewitt_Captain.hosipitality') }}" class="block px-4 py-2 hover:bg-gray-100">Hospitality Course</a></li>
            <li><a href="{{ route('hewitt_Captain.othercourses') }}" class="block px-4 py-2 hover:bg-gray-100">Other Courses</a></li>
        </ul>
    </li>
    <li class="relative group">
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Students</a>
        <ul class="absolute left-0 hidden group-hover:block bg-white shadow-md mt-2 py-2">
            <li><a href="{{ route('student.gallery') }}" class="block px-4 py-2 hover:bg-gray-100">Gallery</a></li>
            <li><a href="{{ route('registration.create') }}" class="block px-4 py-2 hover:bg-gray-100">Online Applications</a></li>
        </ul>
    </li>
    <li><a href="{{ route('workabroad.index') }}" class="block px-4 py-2 hover:bg-gray-100">WorkAbroad</a></li>
    <li><a href="{{ route('news.event') }}" class="block px-4 py-2 hover:bg-gray-100">News and Events</a></li>
    <li><a href="/#contact" class="block px-4 py-2 hover:bg-gray-100">Contact</a></li>
    <li><a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-100">Portal</a></li>
</ul>
    </section>


        <!-- Carousel End -->
    </section>


          @yield('content')





<!-- Registration Modal -->
<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrationModalLabel">Registration Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route ('courseregistration.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control"  name="email"id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" id="location" required>
                    </div>
                    <div class="mb-3">
                      <label for="modeOfLearning" class="form-label">Mode of Learning</label>
                      <select class="form-select" name="modeOfLearning" id="modeOfLearning" required>
                          <option value="" disabled selected>Select mode of learning</option>
                          <option value="e-learning">E-Learning</option>
                          <option value="face-to-face">Face-to-Face</option>
                      </select>
                  </div>
                  <div class="mb-3">
                    <label for="course" class="form-label">Course Selection</label>
                    <select class="form-select" name="course" id="course" required>
                        <option value="" disabled selected>Select a course</option>
                        @foreach($coursese as $course)
                            <option value="{{ $course->name }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startMonth" class="form-label">Start Month</label>
                                <input type="text" name="startMonth" class="form-control" id="startMonth" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startYear" class="form-label">Start Year</label>
                                <input type="text" name="startYear" class="form-control" id="startYear" required>
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
      <footer class="bg-gray-800 text-white py-16">
        <div class="container mx-auto px-6">
          <!-- Footer Content Row -->
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12">

            <!-- About Section -->
            <div class="space-y-4">
              <h5 class="text-xl font-semibold text-gray-300">About Hewitt and Bennet</h5>
              <p>
                Hewitt and Bennet International College is dedicated to providing top-tier education, empowering students to excel globally. Our partnerships with prestigious institutions ensure quality learning and success in the competitive job market.
              </p>
            </div>

            <!-- Quick Links Section -->
           <!-- Quick Links Section -->
<div class="space-y-4">
    <h5 class="text-xl font-semibold text-gray-300">Quick Links</h5>
    <ul class="space-y-2">
        <li><a href="/" class="hover:text-gray-400">Home</a></li> <!-- Added Home link -->
        <li><a href="/#aboutus" class="hover:text-gray-400">About Us</a></li>
        <li><a href="/#courses" class="hover:text-gray-400">Courses</a></li>
        <li><a href="{{ route('registration.create') }}" class="hover:text-gray-400">Admissions</a></li>
        <li><a href="/#contact" class="hover:text-gray-400">Contact Us</a></li>
        <li><a href="{{ route('news.event') }}" class="hover:text-gray-400">News & Events</a></li>
    </ul>
</div>


            <!-- Contact Information Section -->
            <div class="space-y-4">
              <h5 class="text-xl font-semibold text-gray-300">Contact Us</h5>
              <ul class="space-y-2">
                <li><i class="fas fa-map-marker-alt mr-2"></i>Nairobi (CBD), Kenya</li>
                <li><i class="fas fa-map-marker-alt mr-2"></i>Buruburu, Kenya</li>
                <li><i class="fas fa-map-marker-alt mr-2"></i>Thika, Kenya</li>
                <li><i class="fas fa-envelope mr-2"></i><a href="mailto:info@hewittbennet.co.ke" class="hover:text-gray-400">info@hewittbennet.co.ke</a></li>
                <li><i class="fas fa-phone mr-2"></i><a href="tel:+254740197796" class="hover:text-gray-400">+254 7 4019 7796</a></li>
                <li><i class="fas fa-phone mr-2"></i><a href="tel:+254792168754" class="hover:text-gray-400">+254 7 9216 8754</a></li>
                <li><i class="fas fa-phone mr-2"></i><a href="tel:+254700207013" class="hover:text-gray-400">+254 7 0020 7013</a></li>
              </ul>
            </div>

            <!-- Social Media Section -->
            <div class="space-y-4">
              <h5 class="text-xl font-semibold text-gray-300">Follow Us</h5>
              <div class="flex space-x-6">
                <a href="https://facebook.com" target="_blank" class="text-white hover:text-gray-400" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com" target="_blank" class="text-white hover:text-gray-400" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://instagram.com" target="_blank" class="text-white hover:text-gray-400" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://linkedin.com" target="_blank" class="text-white hover:text-gray-400" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                <a href="https://github.com" target="_blank" class="text-white hover:text-gray-400" aria-label="GitHub"><i class="fab fa-github"></i></a>
              </div>
            </div>
          </div>

          <!-- Footer Bottom -->
          <div class="text-center mt-12 border-t border-gray-600 pt-6">
            <p class="text-sm">&copy; <span id="year"></span> Hewitt and Bennet International College. All Rights Reserved.</p>
            <p class="text-sm">Website developed by <a href="https://quickofficepointe.co.ke/" class="hover:text-gray-400">Quick Office Pointe</a></p>
          </div>
        </div>
      </footer>


    <script>
      // Toggle mobile menu
      const toggleButton = document.getElementById('navbar-toggle');
      const mobileMenu = document.getElementById('mobile-menu');

      toggleButton.addEventListener('click', () => {
          mobileMenu.classList.toggle('hidden');
      });
    </script>
    <script>
      // Set the current year dynamically
      document.getElementById('year').textContent = new Date().getFullYear();
    </script>

    <script>
      const stars = document.querySelectorAll('.star');
      const ratingInput = document.getElementById('rate');

      stars.forEach(star => {
          star.addEventListener('click', () => {
              const rating = parseInt(star.getAttribute('data-rating'));
              ratingInput.value = rating;

              // Highlight the selected stars
              stars.forEach(s => {
                  s.classList.remove('selected');
              });

              star.classList.add('selected');
          });
      });
    </script>
<script>
    document.querySelectorAll('.relative.group').forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.querySelector('ul').style.display = 'block';
        });
        item.addEventListener('mouseleave', () => {
            item.querySelector('ul').style.display = 'none';
        });
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
      document.getElementById("showMoreBtn").addEventListener("click", function() {
        var hiddenDestinations = document.getElementsByClassName("hidden-destination");
        var count = 0;
        for (var i = 0; i < hiddenDestinations.length; i++) {
          if (count < 3) {
            hiddenDestinations[i].classList.remove("hidden-destination");
            count++;
          }
        }
        if (hiddenDestinations.length === 0) {
          this.style.display = "none";
        }
      });

      $(document).ready(function() {
        $('.select2').select2();
        $('#destinationCarousel').carousel();
      });

      var reviewForm = document.querySelector('.review-form');
      var openReviewFormBtn = document.querySelector('.open-review-form-btn');
      openReviewFormBtn.addEventListener('click', function() {
        reviewForm.style.display = (reviewForm.style.display === 'none') ? 'block' : 'none';
      });

    </script>

    <script>
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();

          const targetId = this.getAttribute('href').substring(1); // Remove the '#' symbol
          const targetElement = document.getElementById(targetId);

          if (targetElement) {
            window.scrollTo({
              top: targetElement.offsetTop,
              behavior: 'smooth' // This provides smooth scrolling
            });
          }
        });
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        let interval = setInterval(() => {
          document.querySelector('#courseCarousel .carousel-control-next').click();
        }, 5000);

        document.querySelector('#courseCarousel').addEventListener('mouseover', () => clearInterval(interval));
        document.querySelector('#courseCarousel').addEventListener('mouseleave', () => {
          interval = setInterval(() => {
            document.querySelector('#courseCarousel .carousel-control-next').click();
          }, 5000);
        });
      });
    </script>
    </body>
    </html>
