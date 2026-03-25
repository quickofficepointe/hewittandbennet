<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Hewitt And Bennet International College offers a variety of courses...">
  <meta name="keywords" content="Hewitt And Bennet, International College, courses, education, Caregiving...">
  <meta name="author" content="Hewitt And Bennet International College">

  <!-- Favicon -->
  <link rel="icon" href="{{asset('assets/img/hewittlogo.jpeg')}}" type="image/x-icon"/>
  <link rel="shortcut icon" href="{{asset('assets/img/hewittlogo.jpeg')}}" type="image/x-icon"/>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Quicksand:wght@600;700&display=swap" rel="stylesheet"/>

  <!-- Icon Fonts -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"/>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#1E40AF',
            secondary: '#1E3A8A',
            accent: '#D97706',
          },
          fontFamily: {
            sans: ['Open Sans', 'sans-serif'],
            display: ['Quicksand', 'sans-serif'],
          },
        }
      }
    }
  </script>
</head>

<body class="font-sans antialiased text-gray-800 bg-white">
  <!-- Notification Alerts -->
  @if($errors->any())
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white text-sm p-4 rounded-lg shadow-lg z-50 max-w-md w-full">
      <ul class="space-y-1">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    <script>
      setTimeout(() => document.querySelector('.fixed').remove(), 5000);
    </script>
  @endif

  @if(session('success'))
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-sm p-4 rounded-lg shadow-lg z-50 max-w-md w-full">
      {{ session('success') }}
    </div>
    <script>
      setTimeout(() => document.querySelector('.fixed').remove(), 5000);
    </script>
  @endif

  <!-- Topbar -->
  <div class="bg-gray-100 py-2 hidden lg:block">
    <div class="container mx-auto px-4 flex justify-between items-center text-sm">
      <div class="flex space-x-6">
        <div class="flex items-center space-x-2 text-gray-600">
          <i class="fas fa-map-marker-alt text-primary"></i>
          <span>Nairobi, Kenya</span>
        </div>
        <div class="flex items-center space-x-2 text-gray-600">
          <i class="far fa-clock text-primary"></i>
          <span>Mon - Fri: 08.00 AM - 05.00 PM</span>
        </div>
      </div>
      <div class="flex space-x-6">
        <div class="flex items-center space-x-2 text-gray-600">
          <i class="fas fa-phone-alt text-primary"></i>
          <span>Thika: 0700207013</span>
        </div>
        <div class="flex items-center space-x-2 text-gray-600">
          <i class="fas fa-phone-alt text-primary"></i>
          <span>Buruburu: 070197819</span>
        </div>
      </div>
      <div class="flex space-x-4">
        <a href="https://www.facebook.com" target="_blank" class="text-blue-600 hover:text-blue-800 transition">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://api.whatsapp.com/send?phone=+254713490768&text=Hello" target="_blank" class="text-green-500 hover:text-green-600 transition">
          <i class="fab fa-whatsapp"></i>
        </a>
        <a href="https://twitter.com" target="_blank" class="text-blue-400 hover:text-blue-500 transition">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="https://www.linkedin.com" target="_blank" class="text-blue-700 hover:text-blue-800 transition">
          <i class="fab fa-linkedin-in"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- Navbar -->
  <nav class="bg-white shadow-md sticky top-0 z-40">
    <div class="container mx-auto px-4 flex justify-between items-center py-4">
      <!-- Logo -->
      <a href="/" class="flex items-center">
        <img src="{{ asset('assets/img/hewittlogo.jpeg') }}" alt="Hewitt and Bennet Logo" class="h-10">
      </a>

      <!-- Desktop Navigation -->
      <div class="hidden lg:flex items-center space-x-8">
        <a href="/" class="text-gray-700 hover:text-primary font-medium transition">Home</a>

        <div class="relative group">
          <button class="text-gray-700 hover:text-primary font-medium transition flex items-center">
            About <i class="fas fa-chevron-down ml-1 text-xs"></i>
          </button>
          <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50 opacity-0 group-hover:opacity-100 transition duration-300 invisible group-hover:visible">
            <a href="{{ route('hewitt_director.about') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Director's Message</a>
            <a href="{{ route('hewitt_principal.about') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Principal's Message</a>
            <a href="{{ route('hewitt_dean.about') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dean's Message</a>
            <a href="{{ route('hewitt_Captain.about') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Captain's Message</a>
          </div>
        </div>

        <div class="relative group">
          <button class="text-gray-700 hover:text-primary font-medium transition flex items-center">
            Courses <i class="fas fa-chevron-down ml-1 text-xs"></i>
          </button>
          <div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg py-2 z-50 opacity-0 group-hover:opacity-100 transition duration-300 invisible group-hover:visible">
            <a href="{{ route('hewitt_Captain.caregivercourses') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Caregiver Courses</a>
            <a href="{{ route('hewitt_Captain.cnacourses') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Community Health</a>
            <a href="{{ route('hewitt_Captain.hosipitality') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Hospitality</a>
            <a href="{{ route('hewitt_Captain.othercourses') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Other Courses</a>
          </div>
        </div>

        <div class="relative group">
          <button class="text-gray-700 hover:text-primary font-medium transition flex items-center">
            Students <i class="fas fa-chevron-down ml-1 text-xs"></i>
          </button>
          <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50 opacity-0 group-hover:opacity-100 transition duration-300 invisible group-hover:visible">
            <a href="{{ route('student.gallery') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Gallery</a>
            <a href="{{ route('registration.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Applications</a>
          </div>
        </div>

        <a href="{{ route('workabroad.index') }}" class="text-gray-700 hover:text-primary font-medium transition">Work Abroad</a>
        <a href="{{ route('news.event') }}" class="text-gray-700 hover:text-primary font-medium transition">News & Events</a>
        <a href="#contact" class="text-gray-700 hover:text-primary font-medium transition">Contact</a>
        <a href="{{ route('login') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-secondary transition">Portal</a>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-button" class="lg:hidden text-gray-700 focus:outline-none">
        <i class="fas fa-bars text-xl"></i>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden bg-white shadow-lg">
      <div class="px-4 py-2 space-y-2">
        <a href="/" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Home</a>

        <div class="relative">
          <button class="w-full text-left py-2 px-4 text-gray-700 hover:bg-gray-100 rounded flex justify-between items-center">
            About <i class="fas fa-chevron-down text-xs"></i>
          </button>
          <div class="hidden pl-4">
            <a href="{{ route('hewitt_director.about') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Director's Message</a>
            <a href="{{ route('hewitt_principal.about') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Principal's Message</a>
            <a href="{{ route('hewitt_dean.about') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Dean's Message</a>
            <a href="{{ route('hewitt_Captain.about') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Captain's Message</a>
          </div>
        </div>

        <div class="relative">
          <button class="w-full text-left py-2 px-4 text-gray-700 hover:bg-gray-100 rounded flex justify-between items-center">
            Courses <i class="fas fa-chevron-down text-xs"></i>
          </button>
          <div class="hidden pl-4">
            <a href="{{ route('hewitt_Captain.caregivercourses') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Caregiver Courses</a>
            <a href="{{ route('hewitt_Captain.cnacourses') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Community Health</a>
            <a href="{{ route('hewitt_Captain.hosipitality') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Hospitality</a>
            <a href="{{ route('hewitt_Captain.othercourses') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Other Courses</a>
          </div>
        </div>

        <div class="relative">
          <button class="w-full text-left py-2 px-4 text-gray-700 hover:bg-gray-100 rounded flex justify-between items-center">
            Students <i class="fas fa-chevron-down text-xs"></i>
          </button>
          <div class="hidden pl-4">
            <a href="{{ route('student.gallery') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Gallery</a>
            <a href="{{ route('registration.create') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Applications</a>
          </div>
        </div>

        <a href="{{ route('workabroad.index') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Work Abroad</a>
        <a href="{{ route('news.event') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">News & Events</a>
        <a href="#contact" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 rounded">Contact</a>
        <a href="{{ route('login') }}" class="block py-2 px-4 bg-primary text-white rounded hover:bg-secondary transition">Portal</a>
      </div>
    </div>
  </nav>

  <!-- Hero Carousel -->
  <section class="relative">
    <div class="relative w-full overflow-hidden h-96 md:h-[500px]">
      @foreach ($banners as $index => $banner)
        <div class="absolute inset-0 transition-opacity duration-500 ease-in-out opacity-0 {{ $index === 0 ? 'opacity-100' : '' }}" data-carousel-item="{{ $index }}">
          <img class="w-full h-full object-cover" src="{{ $banner->image_path }}" alt="Banner Image {{ $index + 1 }}">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-8">
            <h5 class="text-2xl md:text-4xl font-bold text-white mb-2">{{ $banner->title }}</h5>
            <p class="text-white max-w-2xl">{{ $banner->description }}</p>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Carousel Controls -->
    <button id="prevButton" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/70 transition z-10">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <button id="nextButton" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/70 transition z-10">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </section>

  <!-- Call to Action -->
  <section class="bg-primary py-8">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center bg-white rounded-lg shadow-lg p-6">
        <div class="mb-4 md:mb-0 text-center md:text-left">
          <h2 class="text-2xl font-bold text-gray-800 mb-2">Start Your Journey with Us Today!</h2>
          <p class="text-gray-600">Take the first step towards success. Our programs are designed to give you the knowledge and skills you need.</p>
        </div>
        <a href="{{route ('registration.create') }}" class="inline-flex items-center bg-accent text-white text-lg font-semibold px-6 py-3 rounded-lg hover:bg-yellow-600 transition shadow-md">
          Get Started
        </a>
      </div>
    </div>
  </section>

  <!-- Courses Section -->
  <section class="py-16 bg-gray-50" id="courses">
    <div class="container mx-auto px-4">
      <div class="text-center max-w-2xl mx-auto mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Explore Our Courses</h2>
        <p class="text-gray-600">Discover a wide range of courses designed to enhance your skills and career opportunities.</p>
      </div>

      <!-- Course Categories -->
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">
          <div class="p-6">
            <div class="text-primary mb-4">
              <i class="fas fa-hands-helping text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Caregiver Certification</h3>
            <p class="text-gray-600 mb-4">Comprehensive training for professional caregivers with international standards.</p>
            <a href="{{ route('hewitt_Captain.caregivercourses') }}" class="text-primary font-medium hover:underline">
              View Courses <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">
          <div class="p-6">
            <div class="text-primary mb-4">
              <i class="fas fa-user-nurse text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Community Health</h3>
            <p class="text-gray-600 mb-4">Training for community health assistants to serve diverse populations.</p>
            <a href="{{ route('hewitt_Captain.cnacourses') }}" class="text-primary font-medium hover:underline">
              View Courses <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">
          <div class="p-6">
            <div class="text-primary mb-4">
              <i class="fas fa-utensils text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hospitality</h3>
            <p class="text-gray-600 mb-4">Professional training in hospitality and culinary arts.</p>
            <a href="{{ route('hewitt_Captain.hosipitality') }}" class="text-primary font-medium hover:underline">
              View Courses <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">
          <div class="p-6">
            <div class="text-primary mb-4">
              <i class="fas fa-graduation-cap text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Other Courses</h3>
            <p class="text-gray-600 mb-4">Additional professional development and vocational training.</p>
            <a href="{{ route('hewitt_Captain.othercourses') }}" class="text-primary font-medium hover:underline">
              View Courses <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Featured Courses -->
      <div class="mb-16">
        <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">Featured Courses</h3>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          @foreach ($shortCourses->take(3) as $course)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-[1.02]">
              <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" class="w-full h-48 object-cover">
              <div class="p-6">
                <h5 class="text-lg font-semibold text-gray-800 mb-2">{{ $course->name }}</h5>
                <p class="text-sm text-gray-600 mb-4">Duration: <span class="font-medium">{{ $course->duration }}</span></p>
                <a href="#" class="block w-full bg-primary text-white text-center py-2 rounded-lg hover:bg-secondary transition" data-bs-toggle="modal" data-bs-target="#registrationModal">
                  Apply Now
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  <!-- Career Guidance CTA -->
  <section class="bg-gray-100 py-12">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center bg-white rounded-lg shadow-lg p-8">
        <div class="mb-6 md:mb-0 text-center md:text-left">
          <h2 class="text-2xl font-bold text-gray-800 mb-2">Need Career Guidance?</h2>
          <p class="text-gray-600">We are here to help you find the right path for your future.</p>
        </div>
        <a href="https://wa.me/+254713490768" target="_blank" class="inline-flex items-center bg-green-500 text-white text-lg font-semibold px-6 py-3 rounded-lg hover:bg-green-600 transition shadow-md">
          <i class="fab fa-whatsapp mr-2"></i> Chat on WhatsApp
        </a>
      </div>
    </div>
  </section>

  <!-- About Us Section -->
  <section class="py-16 bg-white" id="aboutus">
    <div class="container mx-auto px-4">
      <div class="flex flex-col lg:flex-row items-center gap-12">
        <div class="lg:w-1/2">
          <div class="mb-8">
            <span class="text-primary font-semibold"># Welcome to Hewitt and Bennet</span>
            <h2 class="text-3xl font-bold text-gray-800 mt-2 mb-4">About Our College</h2>
            <p class="text-gray-600 mb-4 leading-relaxed">
              At Hewitt and Bennet International College, we're dedicated to delivering industry-focused training that empowers students for global careers. Our accreditations and partnerships highlight our commitment to high-quality, internationally recognized education.
            </p>
            <p class="text-gray-600 mb-4 leading-relaxed">
              Our curriculum prepares students for success, with programs tailored to meet today's job market demands. We also offer visa application support to help graduates transition smoothly into their professional journeys worldwide.
            </p>
          </div>

          <div class="space-y-6">
            <div>
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Our Vision</h3>
              <p class="text-gray-600">To become Africa's premier training institution, aligning student skills with global job market needs.</p>
            </div>

            <div>
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Our Mission</h3>
              <p class="text-gray-600">To deliver globally in-demand training programs that equip students for success.</p>
            </div>

            <div>
              <h3 class="text-xl font-semibold text-gray-800 mb-2">Our Values</h3>
              <ul class="list-disc list-inside text-gray-600 space-y-1">
                <li>Excellence and Integrity</li>
                <li>Service and Self-determination</li>
                <li>Global Citizenship</li>
                <li>Compassion and Respect</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="lg:w-1/2">
          <div class="relative rounded-lg overflow-hidden shadow-xl">
            <div class="carousel relative h-96 w-full">
              @foreach(['IMG_3312.jpg', 'IMG_4054.jpg', 'IMG_4061.jpg', 'IMG_4168.jpg', 'IMG_4167.jpg', 'IMG_4243.jpg'] as $image)
                <div class="carousel-item absolute inset-0 transition-opacity duration-500 {{ $loop->first ? 'opacity-100' : 'opacity-0' }}">
                  <img src="{{ asset('assets/gallery/' . $image) }}" alt="College Image" class="w-full h-full object-cover">
                </div>
              @endforeach
            </div>
            <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
              @foreach(range(1, 6) as $index)
                <button class="w-3 h-3 rounded-full bg-white opacity-50 {{ $index === 1 ? 'opacity-100' : '' }}" data-carousel-indicator="{{ $index - 1 }}"></button>
              @endforeach
            </div>
            <button class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 text-gray-800 p-2 rounded-full hover:bg-white transition" data-carousel-prev>
              <i class="fas fa-chevron-left"></i>
            </button>
            <button class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 text-gray-800 p-2 rounded-full hover:bg-white transition" data-carousel-next>
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Registration CTA -->
  <section class="bg-primary py-12">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center bg-white rounded-lg shadow-lg p-8">
        <div class="mb-6 md:mb-0 text-center md:text-left">
          <h2 class="text-2xl font-bold text-gray-800 mb-2">Ready to Shape Your Future?</h2>
          <p class="text-gray-600">Join us now and take the first step towards your career success.</p>
        </div>
        <a href="{{route ('registration.create') }}" class="inline-flex items-center bg-accent text-white text-lg font-semibold px-6 py-3 rounded-lg hover:bg-yellow-600 transition shadow-md">
          Register Now
        </a>
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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d510528.70323917136!2d36.278633167492444!3d-1.4698621662224913!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1128783fffff%3A0x34ca92a42c32810!2sHewitt%20and%20Bennet%20International%20College!5e0!3m2!1sen!2ske!4v1694245829727!5m2!1sen!2ske"
              width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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

  <!-- Partners Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Trusted Partners</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Collaborating with industry leaders to provide world-class education.</p>
      </div>

      <div class="flex flex-wrap justify-center gap-8">
        @foreach(['nita.png', 'knec.png', 'tvet.png', 'cdcc.png'] as $logo)
          <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition">
            <img src="{{ asset('assets/img/' . $logo) }}" alt="Partner Logo" class="h-16 object-contain">
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Final CTA -->
  <section class="bg-primary py-12">
    <div class="container mx-auto px-4 text-center">
      <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Ready to Begin Your Journey?</h2>
      <p class="text-white/90 mb-8 max-w-2xl mx-auto">Join our community of learners and take the first step towards a successful career.</p>
      <a href="{{route ('registration.create') }}" class="inline-block bg-white text-primary font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition shadow-lg">
        Apply Now
      </a>
    </div>
  </section>

<!-- TikTok Videos Section -->
<section class="py-16 bg-white">
  <div class="container mx-auto px-4">
    <!-- Section Header -->
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-800 mb-4">Life at Hewitt & Bennet</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">Follow us on TikTok <a href="https://www.tiktok.com/@hewittbennetinternationa" target="_blank" class="text-blue-600 hover:underline">@hewittbennetinternationa</a> to see daily campus life, student experiences, and more!</p>
    </div>

    <!-- TikTok Video Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- TikTok Video 1 -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
        <div class="relative" style="padding-bottom: 125%"> <!-- 9:16 aspect ratio -->
          <iframe
            src="https://www.tiktok.com/embed/v2/7522782386602478904"
            class="absolute top-0 left-0 w-full h-full"
            frameborder="0"
            allowfullscreen
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            loading="lazy">
          </iframe>
        </div>
        <div class="p-4">
          <p class="text-gray-700 font-medium">Campus Tour - Main Building</p>
          <p class="text-gray-500 text-sm">2 days ago</p>
        </div>
      </div>

      <!-- TikTok Video 2 -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
        <div class="relative" style="padding-bottom: 125%">
          <iframe
            src="https://www.tiktok.com/embed/v2/7525028797142306054"
            class="absolute top-0 left-0 w-full h-full"
            frameborder="0"
            allowfullscreen
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            loading="lazy">
          </iframe>
        </div>
        <div class="p-4">
          <p class="text-gray-700 font-medium">Student Success Stories</p>
          <p class="text-gray-500 text-sm">1 week ago</p>
        </div>
      </div>

      <!-- TikTok Video 3 -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
        <div class="relative" style="padding-bottom: 125%">
          <iframe
            src="https://www.tiktok.com/embed/v2/7521445948078230790"
            class="absolute top-0 left-0 w-full h-full"
            frameborder="0"
            allowfullscreen
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            loading="lazy">
          </iframe>
        </div>
        <div class="p-4">
          <p class="text-gray-700 font-medium">Practical Training Session</p>
          <p class="text-gray-500 text-sm">2 weeks ago</p>
        </div>
      </div>
    </div>

    <!-- View More Button -->
    <div class="text-center mt-8">
      <a href="https://www.tiktok.com/@hewittbennetinternationa" target="_blank" class="inline-flex items-center bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">
        <i class="fab fa-tiktok mr-2"></i> View More on TikTok
      </a>
    </div>
  </div>
</section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
        <div>
          <h3 class="text-xl font-semibold mb-4">About Us</h3>
          <p class="text-gray-400">Hewitt and Bennet International College is dedicated to providing top-tier education, empowering students to excel globally.</p>
        </div>

        <div>
          <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
          <ul class="space-y-2 text-gray-400">
            <li><a href="/" class="hover:text-white transition">Home</a></li>
            <li><a href="#aboutus" class="hover:text-white transition">About</a></li>
            <li><a href="#courses" class="hover:text-white transition">Courses</a></li>
            <li><a href="#contact" class="hover:text-white transition">Contact</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-xl font-semibold mb-4">Contact Info</h3>
          <ul class="space-y-2 text-gray-400">
            <li class="flex items-start">
              <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
              <span>Nairobi, Buruburu, Thika</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-phone-alt mt-1 mr-3 text-primary"></i>
              <span>+254 740 197 796</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-envelope mt-1 mr-3 text-primary"></i>
              <span>info@hewittbennet.co.ke</span>
            </li>
          </ul>
        </div>

        <div>
          <h3 class="text-xl font-semibold mb-4">Follow Us</h3>
          <div class="flex space-x-4">
            <a href="#" class="bg-gray-700 hover:bg-primary w-10 h-10 rounded-full flex items-center justify-center transition">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="bg-gray-700 hover:bg-blue-400 w-10 h-10 rounded-full flex items-center justify-center transition">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="bg-gray-700 hover:bg-pink-600 w-10 h-10 rounded-full flex items-center justify-center transition">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="bg-gray-700 hover:bg-blue-700 w-10 h-10 rounded-full flex items-center justify-center transition">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
        <p>&copy; <span id="current-year"></span> Hewitt and Bennet International College. All rights reserved.</p>
        <p class="mt-2">Website by <a href="https://quickofficepointe.co.ke/" class="text-primary hover:underline">Quick Office Pointe</a></p>
      </div>
    </div>
  </footer>

  <!-- Registration Modal -->
  <div id="registrationModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
      <div class="flex justify-between items-center border-b p-4">
        <h3 class="text-xl font-bold text-gray-800">Registration Form</h3>
        <button class="text-gray-500 hover:text-gray-700" data-modal-close>
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="p-6">
        <form action="{{ route ('courseregistration.store') }}" method="POST">
          @csrf
          <div class="space-y-4">
            <div>
              <label for="name" class="block text-gray-700 font-medium mb-1">Full Name</label>
              <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
            </div>

            <div>
              <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
              <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
            </div>

            <div>
              <label for="phoneNumber" class="block text-gray-700 font-medium mb-1">Phone Number</label>
              <input type="tel" name="phoneNumber" id="phoneNumber" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
            </div>

            <div>
              <label for="location" class="block text-gray-700 font-medium mb-1">Location</label>
              <input type="text" name="location" id="location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
            </div>

            <div>
              <label for="modeOfLearning" class="block text-gray-700 font-medium mb-1">Mode of Learning</label>
              <select name="modeOfLearning" id="modeOfLearning" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                <option value="" disabled selected>Select mode</option>
                <option value="e-learning">E-Learning</option>
                <option value="face-to-face">Face-to-Face</option>
              </select>
            </div>

            <div>
              <label for="course" class="block text-gray-700 font-medium mb-1">Course Selection</label>
              <select name="course" id="course" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                <option value="" disabled selected>Select a course</option>
                @foreach($coursese as $course)
                  <option value="{{ $course->name }}">{{ $course->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label for="startMonth" class="block text-gray-700 font-medium mb-1">Start Month</label>
                <input type="text" name="startMonth" id="startMonth" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
              </div>
              <div>
                <label for="startYear" class="block text-gray-700 font-medium mb-1">Start Year</label>
                <input type="text" name="startYear" id="startYear" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
              </div>
            </div>

            <button type="submit" class="w-full bg-primary text-white py-3 px-6 rounded-lg hover:bg-secondary transition font-medium">
              Submit Application
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- TikTok Embed Script -->
<script>
  // Load TikTok embed script dynamically
  document.addEventListener('DOMContentLoaded', function() {
    const script = document.createElement('script');
    script.src = 'https://www.tiktok.com/embed.js';
    script.async = true;
    document.body.appendChild(script);
  });
</script>
  <!-- Scripts -->
  <script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    });

    // Mobile submenu toggles
    document.querySelectorAll('#mobile-menu .relative button').forEach(button => {
      button.addEventListener('click', function() {
        const submenu = this.nextElementSibling;
        submenu.classList.toggle('hidden');
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-chevron-down');
        icon.classList.toggle('fa-chevron-up');
      });
    });

    // Carousel functionality
    let currentSlide = 0;
    const slides = document.querySelectorAll('[data-carousel-item]');
    const indicators = document.querySelectorAll('[data-carousel-indicator]');

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.toggle('opacity-0', i !== index);
        slide.classList.toggle('opacity-100', i === index);
      });

      indicators.forEach((indicator, i) => {
        indicator.classList.toggle('opacity-50', i !== index);
        indicator.classList.toggle('opacity-100', i === index);
      });

      currentSlide = index;
    }

    document.getElementById('nextButton').addEventListener('click', () => {
      showSlide((currentSlide + 1) % slides.length);
    });

    document.getElementById('prevButton').addEventListener('click', () => {
      showSlide((currentSlide - 1 + slides.length) % slides.length);
    });

    indicators.forEach((indicator, index) => {
      indicator.addEventListener('click', () => {
        showSlide(index);
      });
    });

    // Auto-advance carousel
    setInterval(() => {
      showSlide((currentSlide + 1) % slides.length);
    }, 5000);

    // About carousel
    let aboutCurrent = 0;
    const aboutItems = document.querySelectorAll('.carousel-item');

    function showAboutSlide(index) {
      aboutItems.forEach((item, i) => {
        item.classList.toggle('opacity-0', i !== index);
        item.classList.toggle('opacity-100', i === index);
      });
      aboutCurrent = index;
    }

    document.querySelector('[data-carousel-prev]').addEventListener('click', () => {
      showAboutSlide((aboutCurrent - 1 + aboutItems.length) % aboutItems.length);
    });

    document.querySelector('[data-carousel-next]').addEventListener('click', () => {
      showAboutSlide((aboutCurrent + 1) % aboutItems.length);
    });

    // Auto-advance about carousel
    setInterval(() => {
      showAboutSlide((aboutCurrent + 1) % aboutItems.length);
    }, 4000);

    // Modal functionality
    const modal = document.getElementById('registrationModal');

    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
      button.addEventListener('click', () => {
        modal.classList.remove('hidden');
      });
    });

    document.querySelector('[data-modal-close]').addEventListener('click', () => {
      modal.classList.add('hidden');
    });

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.add('hidden');
      }
    });

    // Set current year in footer
    document.getElementById('current-year').textContent = new Date().getFullYear();

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 100,
            behavior: 'smooth'
          });
        }
      });
    });
  </script>
</body>
</html>
