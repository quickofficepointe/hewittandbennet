@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Contact Messages')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold mb-2">Contact Messages</h2>
                <p class="text-primary-100">Manage and respond to messages from website visitors</p>
            </div>
            <div class="flex space-x-3">
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <i class="fas fa-envelope mr-2"></i>
                    <span class="font-semibold">{{ $messages->total() }}</span>
                    <span class="text-sm">Total Messages</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <i class="fas fa-envelope-open mr-2"></i>
                    <span class="font-semibold">{{ $unreadCount }}</span>
                    <span class="text-sm">Unread</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Messages -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-primary-600">{{ $messages->total() }}</span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Total Messages</h3>
            <p class="text-sm text-gray-500">All time inquiries</p>
        </div>

        <!-- Unread Messages -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-envelope-open-text text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-yellow-600">{{ $unreadCount }}</span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Unread Messages</h3>
            <p class="text-sm text-gray-500">Awaiting response</p>
        </div>

        <!-- This Month -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-calendar-week text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">
                    {{ $messages->where('created_at', '>=', now()->startOfMonth())->count() }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">This Month</h3>
            <p class="text-sm text-gray-500">{{ now()->format('F Y') }}</p>
        </div>

        <!-- Response Rate -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-purple-600">
                    {{ $messages->total() > 0 ? round(($messages->where('is_read', true)->count() / $messages->total()) * 100) : 0 }}%
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Response Rate</h3>
            <p class="text-sm text-gray-500">Messages read</p>
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

    <!-- Messages Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">All Contact Messages</h3>
                    <p class="text-sm text-gray-500 mt-1">View and manage inquiries from website visitors</p>
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
                <table id="messagesTable" class="min-w-full" style="width:100%">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subject</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Message Preview</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($messages as $message)
                        <tr class="hover:bg-gray-50 transition duration-200 {{ !$message->is_read ? 'bg-blue-50' : '' }}">
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if(!$message->is_read)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-circle mr-1 text-xs"></i>Unread
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <i class="fas fa-check-circle mr-1 text-xs"></i>Read
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-primary-600 text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $message->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 mr-2 text-sm"></i>
                                    <a href="mailto:{{ $message->email }}" class="text-primary-600 hover:text-primary-700 text-sm">
                                        {{ $message->email }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ Str::limit($message->subject, 30) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit(strip_tags($message->body), 60) }}</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-600 text-sm">{{ $message->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $message->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('contact.messages.show', $message->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-primary-50 hover:bg-primary-100 text-primary-600 rounded-lg transition group">
                                        <i class="fas fa-eye text-sm group-hover:scale-110 transition"></i>
                                        <span class="ml-1 text-sm">View</span>
                                    </a>
                                    <form action="{{ route('contact.messages.destroy', $message->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition group">
                                            <i class="fas fa-trash-alt text-sm group-hover:scale-110 transition"></i>
                                            <span class="ml-1 text-sm">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable if there are multiple pages
        if ($.fn.DataTable && $('#messagesTable tbody tr').length > 10) {
            $('#messagesTable').DataTable({
                responsive: true,
                dom: '<"flex flex-col md:flex-row md:items-center md:justify-between mb-6"<"mb-4 md:mb-0"l>B<"mt-4 md:mt-0"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between mt-6"<"mb-4 md:mb-0"i><p>>',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy mr-2"></i>Copy',
                        className: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl transition'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel mr-2"></i>Excel',
                        className: 'bg-green-50 hover:bg-green-100 text-green-700 px-4 py-2 rounded-xl transition',
                        title: 'Contact_Messages_' + new Date().toISOString().slice(0,10)
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf mr-2"></i>PDF',
                        className: 'bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-xl transition',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print mr-2"></i>Print',
                        className: 'bg-purple-50 hover:bg-purple-100 text-purple-700 px-4 py-2 rounded-xl transition'
                    }
                ],
                order: [[5, 'desc']],
                pageLength: 25,
                columnDefs: [
                    { orderable: false, targets: [0, 6] }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search messages...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ messages"
                },
                initComplete: function() {
                    $('.dt-buttons').addClass('flex flex-wrap gap-2');
                    $('.dataTables_filter input').addClass('border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary-500');
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

        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideUp {
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes slideDown {
                from { opacity: 0; transform: translate(-50%, -100%); }
                to { opacity: 1; transform: translate(-50%, 0); }
            }
            .animate-slide-down { animation: slideDown 0.3s ease-out; }
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        `;
        document.head.appendChild(style);
    });

    // Delete confirmation
    function confirmDelete(button) {
        Swal.fire({
            title: 'Delete Message?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('.delete-form').submit();
            }
        });
    }
</script>
@endpush

@push('styles')
<style>
    /* DataTables styling */
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

    #messagesTable tbody tr {
        transition: all 0.2s ease;
    }

    #messagesTable tbody tr:hover {
        background-color: #f9fafb;
    }

    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_filter input {
            width: 100%;
        }

        .dt-buttons {
            overflow-x: auto;
            padding-bottom: 0.5rem;
            flex-wrap: nowrap !important;
        }
    }
</style>
@endpush
@endsection
