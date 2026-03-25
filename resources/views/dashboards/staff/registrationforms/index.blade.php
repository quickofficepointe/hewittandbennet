@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Registration Forms')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold mb-2">Registration Forms</h2>
                <p class="text-primary-100">Manage and view all student registration applications</p>
            </div>
            <div class="flex space-x-3">
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <i class="fas fa-file-alt mr-2"></i>
                    <span class="font-semibold">{{ isset($registrationform) ? $registrationform->count() : 0 }}</span>
                    <span class="text-sm">Total Forms</span>
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
                <span class="text-3xl font-bold text-primary-600">{{ isset($registrationform) ? $registrationform->count() : 0 }}</span>
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
                    {{ isset($registrationform) ? $registrationform->where('created_at', '>=', now()->startOfMonth())->count() : 0 }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">This Month</h3>
            <p class="text-sm text-gray-500">{{ now()->format('F Y') }}</p>
        </div>

        <!-- With Documents -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-file-pdf text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">
                    {{ isset($registrationform) ? $registrationform->whereNotNull('file_name')->count() : 0 }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">With Documents</h3>
            <p class="text-sm text-gray-500">Applications with PDF</p>
        </div>

        <!-- Completion Rate -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-orange-600">
                    {{ isset($registrationform) && $registrationform->count() > 0 ? round(($registrationform->whereNotNull('file_name')->count() / $registrationform->count()) * 100) : 0 }}%
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Completion Rate</h3>
            <p class="text-sm text-gray-500">Documents uploaded</p>
        </div>
    </div>

    <!-- Alerts -->
    @if($errors->any())
    <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 animate-slide-down" id="error-alert">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-lg p-4 max-w-md">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">Please fix the following errors:</p>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.closest('#error-alert').remove()" class="ml-auto text-red-400 hover:text-red-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('error-alert');
            if(alert) alert.style.opacity = '0';
            setTimeout(() => { if(alert) alert.remove(); }, 300);
        }, 5000);
    </script>
    @endif

    @if(session('success'))
    <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 animate-slide-down" id="success-alert">
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-lg p-4 max-w-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('#success-alert').remove()" class="ml-auto text-green-400 hover:text-green-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if(alert) alert.style.opacity = '0';
            setTimeout(() => { if(alert) alert.remove(); }, 5000);
        }, 300);
    </script>
    @endif

    <!-- DataTable Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Student Registration Forms</h3>
                    <p class="text-sm text-gray-500 mt-1">Complete list of all registration applications</p>
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
                <table id="registrationFormsTable" class="min-w-full" style="width:100%">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date of Birth</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Citizenship</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Religion</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">City</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Home Contact</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Education</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Profession</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Other Skills</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Guardian Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Guardian Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Guardian ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Guardian Residence</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Medical Condition</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Medical Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Reason for Training</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Expected Gain</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Confirmation</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Document</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if(isset($registrationform) && $registrationform->count() > 0)
                            @foreach($registrationform as $form)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-medium text-gray-800">{{ $form->id }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-primary-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $form->student_name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-gray-600">{{ \Carbon\Carbon::parse($form->dob)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $form->citizenship }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $form->religion }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-gray-600">{{ $form->cityofresidence }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-gray-600">{{ $form->mobile }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-gray-600">{{ $form->emailadress }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $form->homephone }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $form->education }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $form->profession }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ Str::limit($form->otherskills, 30) }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-friends text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-gray-600">{{ $form->gurdianname }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $form->phonenumber }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $form->idnumber }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $form->gresidence }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($form->medical_info_yes)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            {{ $form->medical_info_yes }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">None</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ Str::limit($form->medical_info_explanation, 30) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-gray-600 text-sm">{{ Str::limit($form->reasonfortraining, 50) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-gray-600 text-sm">{{ Str::limit($form->gainfortraining, 50) }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($form->data_is_true)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i>Confirmed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($form->file_name)
                                        <a href="{{ asset('storage/application_documents/' . $form->file_name) }}"
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-1.5 bg-primary-50 hover:bg-primary-100 text-primary-600 rounded-lg transition group">
                                            <i class="fas fa-file-pdf text-sm group-hover:scale-110 transition"></i>
                                            <span class="ml-1 text-sm">View PDF</span>
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">No PDF</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="22" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 opacity-50"></i>
                                    <p>No registration forms found</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        if ($.fn.DataTable && $('#registrationFormsTable').length) {
            const table = $('#registrationFormsTable').DataTable({
                responsive: true,
                scrollX: true,
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
                        title: 'Registration_Forms_' + new Date().toISOString().slice(0,10),
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv mr-2"></i>CSV',
                        className: 'bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-xl transition',
                        title: 'Registration_Forms_' + new Date().toISOString().slice(0,10)
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf mr-2"></i>PDF',
                        className: 'bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-xl transition',
                        title: 'Registration Forms - Hewitt and Bennet International College',
                        orientation: 'landscape',
                        pageSize: 'A3',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 9;
                            doc.styles.tableHeader.fillColor = '#1e3a8a';
                            doc.styles.title.fontSize = 12;
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print mr-2"></i>Print',
                        className: 'bg-purple-50 hover:bg-purple-100 text-purple-700 px-4 py-2 rounded-xl transition',
                        title: 'Registration Forms - Hewitt and Bennet International College'
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
                    searchPlaceholder: "Search forms...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>'
                    }
                },
                order: [[0, 'desc']],
                initComplete: function() {
                    $('.dt-buttons').addClass('flex flex-wrap gap-2');
                    $('.dataTables_filter input').addClass('border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-transparent');
                    $('.dataTables_length select').addClass('border border-gray-300 rounded-xl px-3 py-2');
                }
            });
        }

        // Animate cards
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
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translate(-50%, -100%);
                }
                to {
                    opacity: 1;
                    transform: translate(-50%, 0);
                }
            }
            .animate-slide-down {
                animation: slideDown 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush

@push('styles')
<style>
    /* DataTables custom styling */
    .dataTables_wrapper .dataTables_filter input {
        width: 250px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: 0.75rem;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_length select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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

    /* Table hover effect */
    #registrationFormsTable tbody tr {
        transition: all 0.2s ease;
    }

    #registrationFormsTable tbody tr:hover {
        background-color: #f9fafb;
    }

    /* Responsive adjustments */
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
