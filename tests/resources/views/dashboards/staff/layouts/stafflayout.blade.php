<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/img/hbiclogo.jpeg') }}" type="image/png">
    <title>Hewitt and Bennet International College | Staff Dashboard</title>

    <!-- Google Font: Playfair Display & Source Sans Pro for classic academic feel -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'playfair': ['Playfair Display', 'serif']
                        , 'sans': ['Source Sans Pro', 'sans-serif']
                    , }
                    , colors: {
                        'primary': '#1d4ed8', // blue-700
                        'primary-light': '#3b82f6', // blue-500
                        'primary-lighter': '#93c5fd', // blue-300
                        'primary-dark': '#1e40af', // blue-800
                        'gray': '#374151', // gray-700
                        'gray-light': '#6b7280', // gray-500
                        'gray-lighter': '#e5e7eb', // gray-200
                    }
                    , transitionProperty: {
                        'width': 'width'
                        , 'spacing': 'margin, padding'
                    , }
                }
            }
        }

    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .dropdown-enter-active,
        .dropdown-leave-active {
            transition: all 0.2s;
        }

        .dropdown-enter-from,
        .dropdown-leave-to {
            opacity: 0;
            transform: translateY(-10px);
        }

    </style>

    <!-- DataTables CSS with Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Alpine JS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    
</head>
<body class="font-sans bg-gray-50 text-gray-700" x-data="{ sidebarOpen: window.innerWidth > 1024, mobileSidebarOpen: false }">
    <div class="min-h-screen flex flex-col">
        <!-- Mobile header -->
        <div class="lg:hidden bg-primary text-white p-4 flex justify-between items-center shadow-md">
            <div class="flex items-center space-x-4">
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="text-white focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="/" class="text-white font-bold text-lg">HBIC Staff</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white hover:text-primary-lighter transition">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>

        <!-- Desktop header -->
        <header class="hidden lg:flex bg-white shadow-md p-4 justify-between items-center">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-700 hover:text-primary focus:outline-none">
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
            <!-- Sidebar -->
            <aside class="bg-primary text-white flex flex-col transition-all duration-300 ease-in-out" :class="{'w-64': sidebarOpen, 'w-20': !sidebarOpen, 'fixed inset-y-0 z-50': mobileSidebarOpen, 'hidden lg:flex': !mobileSidebarOpen}">
                <!-- Sidebar header -->
                <div class="p-4 flex flex-col items-center border-b border-primary-lighter/20">
                    <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC Logo" class="w-12 h-12 rounded-full object-cover mb-2 border-2 border-primary-lighter">
                    <h4 class="font-bold text-center text-primary-lighter" :class="{'hidden': !sidebarOpen}">{{ Auth::user()->username }}</h4>
                </div>

                <!-- Sidebar content -->
                <nav class="flex-1 overflow-y-auto py-4">
                    <ul class="space-y-1 px-2">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('staff.dashboard') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('staff.dashboard') }}'}">
                                <i class="fas fa-tachometer-alt w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Dashboard</span>
                            </a>
                        </li>

                        <!-- Admissions Section -->
                        <li class="pt-4" :class="{'hidden': !sidebarOpen}">
                            <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Admissions</span>
                        </li>
                        <li>
                            <a href="{{ route('staff.onlineregister') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('staff.onlineregister') }}'}">
                                <i class="fas fa-user-edit w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Online Registrations</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('students.create') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('students.create') }}'}">
                                <i class="fas fa-graduation-cap w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Student Data</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('registrationforms.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('registrationforms.index') }}'}">
                                <i class="fas fa-clipboard-list w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Registration Forms</span>
                            </a>
                        </li>

                        <!-- Finance Section -->
                        <li class="pt-4" :class="{'hidden': !sidebarOpen}">
                            <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Finance</span>
                        </li>
                        <li>
                            <a href="{{ route('Paymentreceipt.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('Paymentreceipt.index') }}'}">
                                <i class="fas fa-receipt w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Payments</span>
                            </a>
                        </li>

                        <!-- Content Management -->
                        <li class="pt-4" :class="{'hidden': !sidebarOpen}">
                            <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Content</span>
                        </li>
                        <li>
                            <a href="{{ route('gallery.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('gallery.index') }}'}">
                                <i class="fas fa-camera-retro w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Gallery</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('newsandevent.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('newsandevent.index') }}'}">
                                <i class="fas fa-calendar-alt w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">News & Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('testimonials.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('index.cdpert') }}'}">
                                <i class="fas fa-quote-right w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Testimonials</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reviews.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('reviews.index') }}'}">
                                <i class="fas fa-star-half-alt w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Reviews</span>
                            </a>
                        </li>

                        <!-- Marketing Section -->
                        <li class="pt-4" :class="{'hidden': !sidebarOpen}">
                            <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Marketing</span>
                        </li>
                        <li>
                            <a href="{{ route('hewitt_banners.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('hewitt_banners.index') }}'}">
                                <i class="fas fa-bullseye w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Campaigns</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tiktok-videos.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('hewitt_banners.index') }}'}">
                                <i class="fab fa-tiktok w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Social Media</span>
                            </a>
                        </li>

                        <!-- Administration -->
                        <li class="pt-4" :class="{'hidden': !sidebarOpen}">
                            <span class="text-xs uppercase tracking-wider text-primary-lighter/80 px-3">Administration</span>
                        </li>
                        <li>
                            <a href="{{ route('index.departments') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('index.departments') }}'}">
                                <i class="fas fa-book w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Departments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('index.cdpert') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('index.cdpert') }}'}">
                                <i class="fas fa-book w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Courses</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('campuses.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('hewitt_banners.index') }}'}">
                                <i class="fas fa-university w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Campuses</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teams.index') }}" class="flex items-center p-3 rounded-lg transition hover:bg-primary-light/10" :class="{'bg-primary-light/20': window.location.pathname === '{{ route('hewitt_banners.index') }}'}">
                                <i class="fas fa-users w-6 text-center text-primary-lighter"></i>
                                <span class="ml-3 font-medium" :class="{'hidden': !sidebarOpen}">Team Management</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Overlay for mobile sidebar -->
            <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            </div>

            <!-- Main content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <!-- Content Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-primary mb-2">@yield('pageTitle', 'Dashboard')</h1>
                    <!-- Breadcrumbs can be added here if needed -->
                </div>

                <!-- Page content -->
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS with Buttons and Export -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <!-- PDFMake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Update current year in footer
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Initialize Summernote
        $(document).ready(function() {
            $('#content, #content1').summernote({
                placeholder: ''
                , tabsize: 2
                , height: 200
                , toolbar: [
                    ['style', ['style']]
                    , ['font', ['bold', 'underline', 'clear']]
                    , ['color', ['color']]
                    , ['para', ['ul', 'ol', 'paragraph']]
                    , ['table', ['table']]
                    , ['insert', ['link', 'picture', 'video']]
                    , ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        // Initialize DataTable with export buttons
        $(document).ready(function() {
            $('#registeredUsersTable').DataTable({
                responsive: true
                , dom: '<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"l><"flex space-x-2"Bf>>rt<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"i><"flex space-x-2"p>>'
                , buttons: [{
                        extend: 'copyHtml5'
                        , text: '<i class="fas fa-copy mr-1"></i> Copy'
                        , className: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                        , titleAttr: 'Copy to clipboard'
                    }
                    , {
                        extend: 'excelHtml5'
                        , text: '<i class="fas fa-file-excel mr-1"></i> Excel'
                        , className: 'bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                        , title: 'Registered_Users_Export'
                        , titleAttr: 'Export to Excel'
                        , exportOptions: {
                            columns: ':visible'
                        }
                    }
                    , {
                        extend: 'csvHtml5'
                        , text: '<i class="fas fa-file-csv mr-1"></i> CSV'
                        , className: 'bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                        , title: 'Registered_Users_Export'
                        , titleAttr: 'Export to CSV'
                        , exportOptions: {
                            columns: ':visible'
                        }
                    }
                    , {
                        extend: 'pdfHtml5'
                        , text: '<i class="fas fa-file-pdf mr-1"></i> PDF'
                        , className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                        , title: 'Registered Users - Hewitt and Bennet International College'
                        , titleAttr: 'Export to PDF'
                        , orientation: 'landscape'
                        , pageSize: 'A4'
                        , exportOptions: {
                            columns: ':visible'
                        }
                        , customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            doc.styles.title = {
                                color: '#1d4ed8'
                                , fontSize: '18'
                                , alignment: 'center'
                            };
                            doc.styles.tableHeader = {
                                fillColor: '#1d4ed8'
                                , color: '#FFFFFF'
                                , bold: true
                            };
                        }
                    }
                    , {
                        extend: 'print'
                        , text: '<i class="fas fa-print mr-1"></i> Print'
                        , className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                        , title: 'Registered Users - Hewitt and Bennet International College'
                        , titleAttr: 'Print table'
                        , exportOptions: {
                            columns: ':visible'
                        }
                        , customize: function(win) {
                            $(win.document.body).find('h1').css('text-align', 'center');
                            $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                            $(win.document.body).find('tr:nth-child(odd) td').each(function(index) {
                                $(this).css('background-color', '#D0D0D0');
                            });
                            $(win.document.body).find('h1').text('Registered Users - ' + new Date().toDateString());
                        }
                    }
                    , {
                        extend: 'colvis'
                        , text: '<i class="fas fa-columns mr-1"></i> Columns'
                        , className: 'bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                        , titleAttr: 'Column visibility'
                    }
                ]
                , lengthMenu: [
                    [10, 25, 50, 100, -1]
                    , ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
                ]
                , pageLength: 25
                , language: {
                    search: "_INPUT_"
                    , searchPlaceholder: "Search..."
                , }
                , initComplete: function() {
                    $('.dt-button').removeClass('dt-button');
                }
            });
        });

        // Close mobile sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('aside');
            const sidebarToggle = document.querySelector('[x-on\\:click="mobileSidebarOpen = !mobileSidebarOpen"]');

            if (!sidebar.contains(event.target) && event.target !== sidebarToggle) {
                Alpine.store('mobileSidebarOpen', false);
            }
        });

        // Close mobile sidebar when resizing to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                Alpine.store('mobileSidebarOpen', false);
            }
        });

    </script>
</body>
</html>
