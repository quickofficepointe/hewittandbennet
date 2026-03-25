<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('assets/img/hbiclogo.jpeg') }}" type="image/png">
  <title>Hewitt and Bennet International College | Student Dashboard</title>

  <!-- Google Font: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">

  <!-- Tailwind CSS via CDN (for demo purposes; better to use built version in production) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#1148C9',
              600: '#0e3ca5',
              700: '#0c3187',
            }
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
        }
      }
    }
  </script>

  <style>
    .sidebar-transition {
      transition: all 0.3s ease;
    }

    .dataTables_wrapper {
      padding: 0;
    }

    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
      width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #c5c5c5;
      border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
      background: #a8a8a8;
    }
  </style>
</head>
<body class="font-sans bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="sidebar-transition w-64 bg-primary-500 text-white flex flex-col flex-shrink-0">
            <!-- Brand Logo -->
            <div class="flex items-center justify-between p-4 border-b border-primary-600">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC Logo" class="w-10 h-10 rounded-full">
                    <span class="text-lg font-semibold truncate">{{ Auth::user()->username }}</span>
                </div>
                <button id="sidebarToggle" class="md:hidden text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar Menu -->
            <nav class="flex-1 overflow-y-auto custom-scrollbar py-4">
                <ul class="space-y-1 px-2">
                    <li>
                        <a href="{{ route('student.dashboard') }}" class="flex items-center p-3 rounded-lg bg-primary-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>MY APPLICATIONS</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('fee-statement.index') }}" class="flex items-center p-3 rounded-lg hover:bg-primary-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Fees Statement</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.courses') }}" class="flex items-center p-3 rounded-lg hover:bg-primary-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>My Courses</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('exams_all.index') }}" class="flex items-center p-3 rounded-lg hover:bg-primary-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <span>My Exams</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.my-scores') }}" class="flex items-center p-3 rounded-lg hover:bg-primary-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>My Scores</span>
                        </a>
                    </li>

                    <li class="pt-10 mt-10 border-t border-primary-600">
                        <a href="{{ route('logout') }}" class="flex items-center p-3 rounded-lg hover:bg-primary-600 text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center">
                        <button id="mobileSidebarToggle" class="md:hidden text-gray-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="text-xl font-semibold">Dashboard</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <a href="/" class="text-gray-600 hover:text-primary-500">Home</a>
                        <a href="#" class="text-gray-600 hover:text-primary-500">Contact</a>
                        <a href="{{ route('logout') }}" class="flex items-center text-gray-600 hover:text-primary-500" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <div class="px-6 py-2 bg-gray-100 text-sm">
                    <ol class="flex items-center space-x-2">
                        <li><a href="/" class="text-primary-500 hover:text-primary-600">Home</a></li>
                        <li class="text-gray-400">/</li>
                        <li class="text-gray-600">Student Dashboard</li>
                    </ol>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <section>
                    @yield('content')
                </section>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t py-4 px-6 text-sm text-gray-600">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <strong>Copyright &copy; <span id="current-year"></span> <a href="" class="text-primary-500 hover:text-primary-600">HewittandBennetInternationalCollege</a>.</strong>
                        All rights reserved.
                    </div>
                    <div class="mt-2 md:mt-0">
                        <!-- Optional footer content -->
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        const currentYear = new Date().getFullYear();
        document.getElementById("current-year").textContent = currentYear;

        // Mobile sidebar toggle
        document.getElementById('mobileSidebarToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('absolute');
            sidebar.classList.toggle('z-20');
            sidebar.classList.toggle('h-full');
        });

        // For larger screens, we can keep the sidebar always visible
        function handleResize() {
            const sidebar = document.querySelector('aside');
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('hidden', 'absolute', 'z-20');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial call
    </script>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('.data-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search...",
                },
                dom: '<"flex flex-col md:flex-row md:items-center md:justify-between"<"mb-4 md:mb-0"l><"flex"<"mr-4"f><"mb-4 md:mb-0"B>>>rt<"flex flex-col md:flex-row md:items-center md:justify-between"<"mb-4 md:mb-0"i><"md:flex"p>>',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg text-sm font-medium'
                    },
                    {
                        extend: 'csv',
                        className: 'bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg text-sm font-medium'
                    },
                    {
                        extend: 'excel',
                        className: 'bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg text-sm font-medium'
                    },
                    {
                        extend: 'pdf',
                        className: 'bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg text-sm font-medium'
                    },
                    {
                        extend: 'print',
                        className: 'bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg text-sm font-medium'
                    }
                ]
            });
        });
    </script>
</body>
</html>
