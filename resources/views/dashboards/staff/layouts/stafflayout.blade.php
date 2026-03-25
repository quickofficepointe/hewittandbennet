<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/img/hbiclogo.jpeg') }}" type="image/png">
    <title>Hewitt and Bennet International College | Staff Dashboard</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome (single version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4C+X...snip..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- TailwindCSS (single version) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'playfair': ['Playfair Display', 'serif'],
                        'sans': ['Source Sans Pro', 'sans-serif']
                    },
                    colors: {
                        'primary': '#1d4ed8',
                        'primary-light': '#3b82f6',
                        'primary-lighter': '#93c5fd',
                        'primary-dark': '#1e40af',
                        'gray': '#374151',
                        'gray-light': '#6b7280',
                        'gray-lighter': '#e5e7eb',
                    },
                    transitionProperty: {
                        'width': 'width',
                        'spacing': 'margin, padding'
                    }
                }
            }
        }
    </script>

    <style>
        .sidebar-hidden { display: none !important; }
        .dropdown-enter-active, .dropdown-leave-active { transition: all 0.2s; }
        .dropdown-enter-from, .dropdown-leave-to { opacity: 0; transform: translateY(-10px); }
        .sidebar-transition { transition: all 0.3s ease-in-out; }
        .overlay-transition { transition: opacity 0.3s linear; }
        /* Initially hide mobile sidebar */
        #mobile-sidebar { display: none; }
        /* Show mobile sidebar when active */
        #mobile-sidebar.mobile-active { display: flex; }

        /* Custom styles for DataTables buttons */
        .dt-buttons {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
            margin-bottom: 1rem !important;
        }

        @media (max-width: 768px) {
            .dt-buttons {
                overflow-x: auto !important;
                padding-bottom: 0.5rem !important;
                flex-wrap: nowrap !important;
            }
        }
    </style>

    <!-- DataTables CSS (single set) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Summernote CSS (single version – lite) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
</head>

<body class="font-sans bg-gray-50 text-gray-700">
<div class="min-h-screen flex flex-col">
    <!-- Mobile header -->
    <div class="lg:hidden bg-primary text-white p-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-4">
            <button id="mobile-sidebar-toggle" class="text-white focus:outline-none" aria-label="Open sidebar">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <a href="/" class="text-white font-bold text-lg">HBIC Staff</a>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white hover:text-primary-lighter transition" aria-label="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>

    <!-- Desktop header -->
    <header class="hidden lg:flex bg-white shadow-md p-4 justify-between items-center">
        <div class="flex items-center space-x-4">
            <button id="desktop-sidebar-toggle" class="text-gray-700 hover:text-primary focus:outline-none" aria-label="Toggle sidebar">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="text-xl font-bold text-primary">@yield('pageTitle', 'Dashboard')</h1>
        </div>
        <div class="flex items-center space-x-6">
            <a href="/" class="text-gray-700 hover:text-primary transition">Home</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-700 hover:text-primary transition flex items-center space-x-2">
                <span>Logout</span>
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar (Desktop) -->
        <aside id="desktop-sidebar" class="bg-primary text-white flex flex-col sidebar-transition w-64">
            <div class="p-4 flex flex-col items-center border-b border-primary-lighter/20">
                <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC Logo" class="w-12 h-12 rounded-full object-cover mb-2 border-2 border-primary-lighter">
                <h4 class="font-bold text-center text-primary-lighter">{{ Auth::user()->username }}</h4>
            </div>

            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-1 px-2">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('staff.dashboard') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-tachometer-alt w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Dashboard</span>
                        </a>
                    </li>

                    <!-- Admissions -->
                    <li class="pt-4">
                        <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Admissions</span>
                    </li>
                    <li>
                        <a href="{{ route('staff.onlineregister') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-user-edit w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Online Registration</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('students.create') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-graduation-cap w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Student Onboarding</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('registrationforms.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-clipboard-list w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Online forms</span>
                        </a>
                    </li>

                    <!-- Finance -->
                    <li class="pt-4">
                        <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Finance</span>
                    </li>
                    <li>
                        <a href="{{ route('Paymentreceipt.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-receipt w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Payments</span>
                        </a>
                    </li>

                    <!-- Content -->
                    <li class="pt-4">
                        <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Content</span>
                    </li>
                    <li>
                        <a href="{{ route('gallery.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-camera-retro w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Gallery</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('newsandevent.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-calendar-alt w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">News & Events</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('testimonials.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-quote-right w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Testimonials</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index.review') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-star-half-alt w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Reviews</span>
                        </a>
                    </li>

                    <!-- Marketing -->
                    <li class="pt-4">
                        <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Marketing</span>
                    </li>
                    <li>
                        <a href="{{ route('hewitt_banners.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-bullseye w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Campaigns</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tiktok-videos.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fab fa-tiktok w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Social Media</span>
                        </a>
                    </li>

                    <!-- Administration -->
                    <li class="pt-4">
                        <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Administration</span>
                    </li>
                    <li>
                        <a href="{{ route('index.departments') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-book w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Departments</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index.cdpert') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-book w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Courses</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('campuses.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-university w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Campuses</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('teams.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-users w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Team Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('partners.show') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10">
                            <i class="fas fa-users w-6 text-center text-primary-lighter"></i>
                            <span class="ml-3 font-medium">Partners Management</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Mobile Sidebar (same routes, preserved) -->
        <aside id="mobile-sidebar" class="fixed inset-y-0 z-50 bg-primary text-white flex flex-col sidebar-transition w-64">
            <div class="p-4 flex flex-col items-center border-b border-primary-lighter/20">
                <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC Logo" class="w-12 h-12 rounded-full object-cover mb-2 border-2 border-primary-lighter">
                <h4 class="font-bold text-center text-primary-lighter">{{ Auth::user()->username }}</h4>
            </div>
            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-1 px-2">
                    <li><a href="{{ route('staff.dashboard') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-tachometer-alt w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Dashboard</span></a></li>

                    <li class="pt-4"><span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Admissions</span></li>
                    <li><a href="{{ route('staff.onlineregister') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-user-edit w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Registrations</span></a></li>
                    <li><a href="{{ route('students.create') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-graduation-cap w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Student Data</span></a></li>
                    <li><a href="{{ route('registrationforms.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-clipboard-list w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Registration Forms</span></a></li>

                    <li class="pt-4"><span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Finance</span></li>
                    <li><a href="{{ route('Paymentreceipt.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-receipt w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Payments</span></a></li>

                    <li class="pt-4"><span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Content</span></li>
                    <li><a href="{{ route('gallery.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-camera-retro w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Gallery</span></a></li>
                    <li><a href="{{ route('newsandevent.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-calendar-alt w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">News & Events</span></a></li>
                    <li><a href="{{ route('testimonials.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-quote-right w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Testimonials</span></a></li>
                    <li><a href="{{ route('index.review') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-star-half-alt w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Reviews</span></a></li>

                    <li class="pt-4"><span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Marketing</span></li>
                    <li><a href="{{ route('hewitt_banners.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-bullseye w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Campaigns</span></a></li>
                    <li><a href="{{ route('tiktok-videos.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fab fa-tiktok w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Social Media</span></a></li>

                    <li class="pt-4"><span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Administration</span></li>
                    <li><a href="{{ route('index.departments') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-book w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Departments</span></a></li>
                    <li><a href="{{ route('index.cdpert') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-book w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Courses</span></a></li>
                    <li><a href="{{ route('campuses.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-university w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Campuses</span></a></li>
                    <li><a href="{{ route('teams.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-users w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Team Management</span></a></li>
                    <li><a href="{{ route('partners.show') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10"><i class="fas fa-users w-6 text-center text-primary-lighter"></i><span class="ml-3 font-medium">Partners Management</span></a></li>
                </ul>
            </nav>
        </aside>

        <!-- Overlay for mobile sidebar -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden overlay-transition opacity-0 pointer-events-none"></div>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-primary mb-2">@yield('pageTitle', 'Dashboard')</h1>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white p-4 text-center shadow-inner">
        <strong>&copy; <span id="current-year"></span> <a href="https://hewittandbenet.edu" class="hover:text-primary-lighter">Hewett and Benet International College</a>.</strong> All rights reserved.
    </footer>
</div>

<!-- jQuery (single version) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS (ordered & complete: core → responsive → buttons → exporters) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<!-- Export deps BEFORE buttons.html5 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- Summernote JS (single version – lite) -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Footer year
    document.getElementById('current-year').textContent = new Date().getFullYear();

    // Sidebar state
    let sidebarOpen = window.innerWidth > 1024;
    let mobileSidebarOpen = false;

    // Elements
    const desktopSidebar = document.getElementById('desktop-sidebar');
    const mobileSidebar  = document.getElementById('mobile-sidebar');
    const mobileOverlay  = document.getElementById('mobile-overlay');
    const desktopSidebarToggle = document.getElementById('desktop-sidebar-toggle');
    const mobileSidebarToggle  = document.getElementById('mobile-sidebar-toggle');

    function setDesktopSidebar(open) {
        if (open) {
            desktopSidebar.classList.remove('w-20');
            desktopSidebar.classList.add('w-64');
            document.querySelectorAll('#desktop-sidebar span, #desktop-sidebar .pt-4').forEach(el => el.classList.remove('hidden'));
        } else {
            desktopSidebar.classList.remove('w-64');
            desktopSidebar.classList.add('w-20');
            document.querySelectorAll('#desktop-sidebar span, #desktop-sidebar .pt-4').forEach(el => el.classList.add('hidden'));
        }
    }

    function setMobileSidebar(open) {
        if (open) {
            mobileSidebar.classList.add('mobile-active');
            mobileOverlay.classList.remove('opacity-0', 'pointer-events-none');
            mobileOverlay.classList.add('opacity-100');
        } else {
            mobileSidebar.classList.remove('mobile-active');
            mobileOverlay.classList.remove('opacity-100');
            mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    function initSidebar() {
        setDesktopSidebar(sidebarOpen);
        setMobileSidebar(mobileSidebarOpen);
    }

    // Init on DOM ready
    $(function () {
        initSidebar();

        // Toggle desktop sidebar
        if (desktopSidebarToggle) {
            desktopSidebarToggle.addEventListener('click', function() {
                sidebarOpen = !sidebarOpen;
                setDesktopSidebar(sidebarOpen);
            });
        }

        // Toggle mobile sidebar
        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileSidebarOpen = !mobileSidebarOpen;
                setMobileSidebar(mobileSidebarOpen);
            });
        }

        // Close mobile sidebar on overlay click or ESC
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function() {
                mobileSidebarOpen = false;
                setMobileSidebar(false);
            });
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileSidebarOpen) {
                mobileSidebarOpen = false;
                setMobileSidebar(false);
            }
        });

        // Close mobile sidebar when clicking outside
        document.addEventListener('click', function(event) {
            if (mobileSidebarOpen && !mobileSidebar.contains(event.target) && event.target !== mobileSidebarToggle) {
                mobileSidebarOpen = false;
                setMobileSidebar(false);
            }
        });

        // Close mobile sidebar when resizing to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024 && mobileSidebarOpen) {
                mobileSidebarOpen = false;
                setMobileSidebar(false);
            }
        });

        // Summernote init (keep your selectors)
        $('#content, #content1').summernote({
            placeholder: '',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // DataTables init with horizontal buttons
        $('#registeredUsersTable').DataTable({
            responsive: true,
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"l>B<"mt-4 md:mt-0"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"i><"flex space-x-2"p>>',
            buttons: {
                dom: {
                    container: {
                        tag: 'div',
                        className: 'flex flex-wrap gap-2 mb-4'
                    },
                    button: {
                        tag: 'button',
                        className: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-3 rounded-lg flex items-center shadow-sm text-nowrap',
                        active: 'bg-gray-400'
                    }
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy mr-1"></i> Copy',
                        titleAttr: 'Copy to clipboard'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                        className: 'bg-green-500 hover:bg-green-600 text-white',
                        title: 'Registered_Users_Export',
                        titleAttr: 'Export to Excel',
                        exportOptions: { columns: ':visible' }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                        className: 'bg-blue-500 hover:bg-blue-600 text-white',
                        title: 'Registered_Users_Export',
                        titleAttr: 'Export to CSV',
                        exportOptions: { columns: ':visible' }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                        className: 'bg-red-500 hover:bg-red-600 text-white',
                        title: 'Registered Users - Hewitt and Bennet International College',
                        titleAttr: 'Export to PDF',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: { columns: ':visible' },
                        customize: function(doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            doc.styles.title = { color: '#1d4ed8', fontSize: '18', alignment: 'center' };
                            doc.styles.tableHeader = { fillColor: '#1d4ed8', color: '#FFFFFF', bold: true };
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print mr-1"></i> Print',
                        className: 'bg-purple-500 hover:bg-purple-600 text-white',
                        title: 'Registered Users - Hewitt and Bennet International College',
                        titleAttr: 'Print table',
                        exportOptions: { columns: ':visible' },
                        customize: function(win) {
                            $(win.document.body).find('h1').css('text-align', 'center');
                            $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                            $(win.document.body).find('tr:nth-child(odd) td').each(function() { $(this).css('background-color', '#D0D0D0'); });
                            $(win.document.body).find('h1').text('Registered Users - ' + new Date().toDateString());
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns mr-1"></i> Columns',
                        className: 'bg-gray-500 hover:bg-gray-600 text-white',
                        titleAttr: 'Column visibility'
                    }
                ]
            },
            lengthMenu: [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
            pageLength: 25,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
            initComplete: function() {
                // Remove default DataTables button classes
                $('.dt-button').removeClass('dt-button');

                // Make buttons responsive on mobile
                if (window.innerWidth < 768) {
                    $('.dt-buttons').addClass('overflow-x-auto pb-2');
                    $('.dt-button').addClass('text-sm py-1 px-2');
                }
            }
        });

        // Handle window resize for button responsiveness
        $(window).on('resize', function() {
            if (window.innerWidth < 768) {
                $('.dt-buttons').addClass('overflow-x-auto pb-2');
                $('.dt-button').addClass('text-sm py-1 px-2');
            } else {
                $('.dt-buttons').removeClass('overflow-x-auto pb-2');
                $('.dt-button').removeClass('text-sm py-1 px-2');
            }
        });
    });
</script>
</body>
</html>
