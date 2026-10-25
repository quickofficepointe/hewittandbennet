<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/img/hbiclogo.jpeg') }}">
    <title>@yield('pageTitle', 'Portal') | HBIC Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                    colors: {
                        primary: { DEFAULT: '#1E3A8A', light: '#3B5BB5', dark: '#172E6E', 50: '#EEF2FB' },
                        secondary: '#DC2626',
                        'primary-dark': '#172E6E', 'primary-light': '#3B5BB5', 'primary-lighter': '#93c5fd',
                        'gray-light': '#6b7280', 'gray-lighter': '#e5e7eb',
                    }
                }
            }
        }
    </script>
    {{-- DataTables + Summernote are kept for the website content (CMS) pages. --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .dt-buttons { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1rem; }
        .dt-button { background: #1E3A8A !important; color: #fff !important; border: 0 !important; border-radius: .375rem !important; padding: .35rem .8rem !important; }
        table.dataTable { width: 100% !important; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
            main { padding: 0 !important; }
            .print-area { box-shadow: none !important; border: 0 !important; }
        }
    </style>
    @yield('styles')
    @stack('styles')
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased" x-data="{ sidebar: false }">
@php($menu = \App\Support\PortalMenu::for(auth()->user()))
<div class="min-h-screen flex">
    {{-- Sidebar --}}
    <div x-show="sidebar" x-cloak @click="sidebar = false" class="fixed inset-0 bg-black/40 z-30 lg:hidden no-print"></div>
    <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
           class="no-print fixed lg:sticky top-0 z-40 h-screen w-64 shrink-0 bg-primary-dark text-blue-100 transform lg:translate-x-0 transition-transform duration-200 flex flex-col">
        <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-3 px-5 h-16 border-b border-white/10 shrink-0">
            <img src="{{ asset('assets/img/logo_nobg.png') }}" alt="HBIC" class="h-9 w-9 object-contain bg-white rounded-full p-0.5">
            <div class="leading-tight">
                <div class="font-semibold text-white text-sm">Hewitt &amp; Bennet</div>
                <div class="text-[11px] text-blue-200">College Management System</div>
            </div>
        </a>
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-5 text-sm">
            @foreach ($menu as $section => $items)
                <div>
                    <div class="px-3 mb-1 text-[11px] font-semibold uppercase tracking-wider text-blue-300/70">{{ $section }}</div>
                    @foreach ($items as [$label, $routeName, $icon, $pattern])
                        @php($active = request()->routeIs($pattern))
                        <a href="{{ route($routeName) }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-md {{ $active ? 'bg-white/15 text-white font-medium' : 'hover:bg-white/5 hover:text-white' }}">
                            <i class="fa-solid {{ $icon }} w-4 text-center {{ $active ? 'text-white' : 'text-blue-300' }}"></i>
                            <span>{{ $label }}</span>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </nav>
        <div class="p-3 border-t border-white/10 text-xs">
            <a href="{{ url('/') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white/5"><i class="fa-solid fa-globe w-4"></i> View website</a>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 min-w-0 flex flex-col">
        <header class="no-print sticky top-0 z-20 bg-white border-b border-slate-200 h-16 flex items-center justify-between px-4 lg:px-8">
            <div class="flex items-center gap-3 min-w-0">
                <button @click="sidebar = true" class="lg:hidden text-slate-600" aria-label="Open menu"><i class="fa-solid fa-bars text-xl"></i></button>
                <h1 class="text-lg font-semibold text-slate-800 truncate">@yield('pageTitle', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-4" x-data="{ open: false }">
                <span class="hidden sm:inline-flex items-center rounded-full bg-primary-50 text-primary px-3 py-1 text-xs font-medium">{{ auth()->user()->role_label }}</span>
                <div class="relative">
                    <button @click="open = !open" class="flex items-center gap-2">
                        @if (auth()->user()->avatar)
                            <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="h-9 w-9 rounded-full object-cover" alt="">
                        @else
                            <span class="h-9 w-9 rounded-full bg-primary text-white flex items-center justify-center text-sm font-semibold">{{ auth()->user()->initials }}</span>
                        @endif
                        <span class="hidden md:block text-sm font-medium">{{ auth()->user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                    </button>
                    <div x-show="open" x-cloak @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-slate-100 py-1 text-sm">
                        <a href="{{ route('portal.profile.edit') }}" class="block px-4 py-2 hover:bg-slate-50"><i class="fa-solid fa-user-gear w-5 text-slate-400"></i> Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 hover:bg-slate-50 text-red-600"><i class="fa-solid fa-right-from-bracket w-5"></i> Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-8">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" class="no-print mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    <i class="fa-solid fa-circle-check mt-0.5"></i><div class="flex-1">{{ session('success') }}</div>
                    <button @click="show = false" class="text-green-600"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
            @if (session('error'))
                <div class="no-print mb-6 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i><div>{{ session('error') }}</div>
                </div>
            @endif
            @if ($errors->any())
                <div class="no-print mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    <div class="font-medium mb-1"><i class="fa-solid fa-triangle-exclamation"></i> Please fix the following:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="no-print px-8 py-4 text-xs text-slate-400 border-t border-slate-200 bg-white">
            &copy; {{ date('Y') }} Hewitt and Bennet International College &middot; College Management System
        </footer>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    // Any table with data-table="true" becomes searchable/exportable.
    $(function () {
        $('table[data-table]').DataTable({
            pageLength: 25,
            order: [],
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'csv', 'print'],
        });
    });
</script>
@yield('scripts')
@stack('scripts')
</body>
</html>
