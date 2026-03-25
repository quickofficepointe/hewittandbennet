@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Registered Users')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold mb-2">Registered Users</h2>
                <p class="text-primary-100">Manage and view all student registrations</p>
            </div>
            <div class="flex space-x-3">
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <i class="fas fa-users mr-2"></i>
                    <span class="font-semibold">{{ $courseapplications->count() }}</span>
                    <span class="text-sm">Total Registrations</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Applications -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-file-alt text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-primary-600">{{ $courseapplications->count() }}</span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Total Applications</h3>
            <p class="text-sm text-gray-500">All time registrations</p>
        </div>

        <!-- This Month Applications -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-calendar-week text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-purple-600">
                    {{ $courseapplications->where('created_at', '>=', now()->startOfMonth())->count() }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">This Month</h3>
            <p class="text-sm text-gray-500">{{ now()->format('F Y') }}</p>
        </div>

        <!-- Unique Courses -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-book-open text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">{{ $courseapplications->unique('course')->count() }}</span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Active Courses</h3>
            <p class="text-sm text-gray-500">Courses with registrations</p>
        </div>

        <!-- Learning Modes -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-chalkboard-user text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-orange-600">
                    {{ $courseapplications->unique('modeOfLearning')->count() }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Learning Modes</h3>
            <p class="text-sm text-gray-500">Available study options</p>
        </div>
    </div>

    <!-- DataTable Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Student Registrations</h3>
                    <p class="text-sm text-gray-500 mt-1">Complete list of all registered students</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="window.location.reload()" class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table id="registeredUsersTable" class="min-w-full" style="width:100%">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Location</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone Number</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Course</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Application Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Start Month</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Start Year</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mode Of Learning</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($courseapplications as $application)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-primary-600 text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $application->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-600">{{ $application->email }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-600">{{ $application->location }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-600">{{ $application->phoneNumber }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $application->course }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-600">{{ \Carbon\Carbon::parse($application->timestamp)->format('d/m/Y H:i:s') }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-gray-600">{{ $application->startMonth }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-gray-600">{{ $application->startYear }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @php
                                    $modeColors = [
                                        'On-Campus' => 'bg-green-100 text-green-800',
                                        'Online' => 'bg-purple-100 text-purple-800',
                                        'Hybrid' => 'bg-orange-100 text-orange-800'
                                    ];
                                    $modeColor = $modeColors[$application->modeOfLearning] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $modeColor }}">
                                    {{ $application->modeOfLearning }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h3 class="font-bold text-gray-800 mb-1">Export Data</h3>
                <p class="text-sm text-gray-500">Download registration data in various formats</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="exportToExcel()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl transition flex items-center">
                    <i class="fas fa-file-excel mr-2"></i>Export to Excel
                </button>
                <button onclick="window.print()" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition flex items-center">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable with enhanced options
        if ($.fn.DataTable) {
            const table = $('#registeredUsersTable').DataTable({
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
                        titleAttr: 'Export to Excel',
                        title: 'Registered_Users_' + new Date().toISOString().slice(0,10)
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv mr-2"></i>CSV',
                        className: 'bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-xl transition',
                        titleAttr: 'Export to CSV',
                        title: 'Registered_Users_' + new Date().toISOString().slice(0,10)
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf mr-2"></i>PDF',
                        className: 'bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-xl transition',
                        titleAttr: 'Export to PDF',
                        title: 'Registered_Users_' + new Date().toISOString().slice(0,10),
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 9;
                            doc.styles.tableHeader.fontSize = 10;
                            doc.styles.tableHeader.fillColor = '#1e3a8a';
                            doc.styles.title.fontSize = 14;
                            doc.content[0].text = 'Hewitt and Bennet International College - Registered Users';
                            doc.content[0].alignment = 'center';
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print mr-2"></i>Print',
                        className: 'bg-purple-50 hover:bg-purple-100 text-purple-700 px-4 py-2 rounded-xl transition',
                        titleAttr: 'Print table',
                        title: 'Registered Users - Hewitt and Bennet International College',
                        customize: function(win) {
                            $(win.document.body).find('h1').css('text-align', 'center');
                            $(win.document.body).find('table').addClass('display').css('font-size', '10px');
                        }
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
                    searchPlaceholder: "Search students...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>'
                    }
                },
                order: [[5, 'desc']], // Order by application date descending
                columnDefs: [
                    { responsivePriority: 1, targets: 0 }, // Student name priority
                    { responsivePriority: 2, targets: 4 }, // Course priority
                    { responsivePriority: 3, targets: 8 }, // Mode of learning priority
                    { responsivePriority: 4, targets: 5 }  // Application date
                ],
                initComplete: function() {
                    // Style the search input
                    $('.dataTables_filter input').addClass('border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent');
                    $('.dataTables_length select').addClass('border border-gray-300 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500');

                    // Style the buttons container
                    $('.dt-buttons').addClass('flex flex-wrap gap-2');
                }
            });
        }

        // Animate cards on load
        const cards = document.querySelectorAll('.bg-white.rounded-2xl');
        cards.forEach((card, index) => {
            card.style.animation = `slideUp 0.4s ease-out ${index * 0.05}s forwards`;
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
        });

        // Add animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    });

    // Export to Excel function
    function exportToExcel() {
        const table = $('#registeredUsersTable').DataTable();
        table.button('.buttons-excel').trigger();
    }
</script>
@endpush

@push('styles')
<style>
    /* DataTables custom styling */
    .dataTables_wrapper .dataTables_filter input {
        width: 250px;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: 0.75rem;
        padding: 0.5rem 2rem 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        background-color: white;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_length select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .dataTables_wrapper .dataTables_info {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin: 0 0.25rem;
        border-radius: 0.5rem;
        background: #f3f4f6;
        color: #374151 !important;
        border: none;
        transition: all 0.2s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e5e7eb;
        transform: translateY(-1px);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #3b82f6;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        background: #f9fafb;
        color: #d1d5db !important;
        cursor: not-allowed;
    }

    /* Table hover effect */
    #registeredUsersTable tbody tr {
        transition: all 0.2s ease;
    }

    #registeredUsersTable tbody tr:hover {
        background-color: #f9fafb;
        transform: scale(1.01);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Responsive table adjustments */
    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_filter input {
            width: 100%;
        }

        .dt-buttons {
            overflow-x: auto;
            padding-bottom: 0.5rem;
            flex-wrap: nowrap !important;
        }

        .dt-buttons button {
            white-space: nowrap;
        }
    }
</style>
@endpush
@endsection
