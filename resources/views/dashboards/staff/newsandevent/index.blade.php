@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'News & Events Management')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold mb-2">News & Events Management</h2>
                <p class="text-primary-100">Create, manage and publish news and events for the college community</p>
            </div>
            <div class="flex space-x-3">
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <i class="fas fa-newspaper mr-2"></i>
                    <span class="font-semibold">{{ isset($newsEvents) ? $newsEvents->count() : 0 }}</span>
                    <span class="text-sm">Total Posts</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span class="font-semibold">{{ isset($newsEvents) ? $newsEvents->where('created_at', '>=', now()->startOfMonth())->count() : 0 }}</span>
                    <span class="text-sm">This Month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Posts -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-newspaper text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-primary-600">{{ isset($newsEvents) ? $newsEvents->count() : 0 }}</span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Total Posts</h3>
            <p class="text-sm text-gray-500">All published content</p>
        </div>

        <!-- This Month -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-calendar-week text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-purple-600">
                    {{ isset($newsEvents) ? $newsEvents->where('created_at', '>=', now()->startOfMonth())->count() : 0 }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">This Month</h3>
            <p class="text-sm text-gray-500">{{ now()->format('F Y') }}</p>
        </div>

        <!-- With Images -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-image text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">
                    {{ isset($newsEvents) ? $newsEvents->whereNotNull('cover_image')->count() : 0 }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">With Images</h3>
            <p class="text-sm text-gray-500">Posts with cover images</p>
        </div>

        <!-- Published by You -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-edit text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-orange-600">
                    {{ isset($newsEvents) ? $newsEvents->where('user_id', Auth::id())->count() : 0 }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Your Posts</h3>
            <p class="text-sm text-gray-500">Published by you</p>
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

    <!-- News & Events Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Published News & Events</h3>
                    <p class="text-sm text-gray-500 mt-1">Manage all news articles and event announcements</p>
                </div>
                <div class="flex space-x-2">
                    <button id="createNewsBtn" class="px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl transition shadow-md hover:shadow-lg flex items-center">
                        <i class="fas fa-plus-circle mr-2"></i>Add News/Event
                    </button>
                    <button onclick="window.location.reload()" class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table id="newsEventsTable" class="min-w-full" style="width:100%">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cover Image</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Preview</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Author</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Published Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if(isset($newsEvents) && $newsEvents->count() > 0)
                            @foreach($newsEvents as $event)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-{{ $event->type == 'event' ? 'calendar-alt' : 'newspaper' }} text-primary-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800">{{ $event->title }}</div>
                                            <div class="text-xs text-gray-400 mt-0.5">{{ $event->slug }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($event->cover_image)
                                        <img src="{{ asset('storage/' . $event->cover_image) }}"
                                             alt="{{ $event->title }}"
                                             class="h-12 w-12 rounded-lg object-cover ring-2 ring-gray-200">
                                    @else
                                        <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-600 text-sm line-clamp-2">{!! Str::limit(strip_tags($event->content), 100) !!}</p>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-gray-500 text-xs"></i>
                                        </div>
                                        <span class="text-gray-600 text-sm">{{ $event->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-gray-600 text-sm">{{ $event->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $event->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <button onclick="openEditModal({{ json_encode($event) }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 rounded-lg transition group">
                                            <i class="fas fa-edit text-sm group-hover:scale-110 transition"></i>
                                            <span class="ml-1 text-sm">Edit</span>
                                        </button>
                                        <form action="{{ route('newsandevent.destroy', $event->id) }}" method="POST" class="inline delete-form">
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
                        @else
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-newspaper text-4xl mb-2 opacity-50"></i>
                                    <p>No news or events found</p>
                                    <button onclick="document.getElementById('createNewsBtn').click()"
                                            class="mt-3 text-primary-600 hover:text-primary-700 text-sm font-medium">
                                        <i class="fas fa-plus-circle mr-1"></i>Create your first post
                                    </button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create News/Event Modal -->
<div id="createModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50 hidden">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">
            <div class="bg-gradient-to-r from-primary-600 to-primary-800 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white">Create News/Event</h3>
                        <p class="text-primary-100 text-sm mt-1">Share important updates with the college community</p>
                    </div>
                    <button id="closeCreateModal" class="text-white hover:text-primary-200 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('newsandevent.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                            <input type="text" name="title" id="create_title" required
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2.5 border"
                                   placeholder="Enter news or event title">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                            <div id="coverUploadArea" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary-500 transition cursor-pointer">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                            <span>Upload a cover image</span>
                                            <input type="file" name="cover_image" id="create_cover_image" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 5MB</p>
                                </div>
                            </div>
                            <div id="coverPreview" class="mt-3 hidden">
                                <p class="text-sm text-gray-600 mb-2">Preview:</p>
                                <img id="coverPreviewImg" class="h-32 w-auto rounded-lg object-cover shadow-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                            <textarea name="content" id="create_content" rows="10"
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2.5 border summernote"
                                      placeholder="Write your content here..."></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" id="cancelCreateModal"
                                class="px-4 py-2 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl shadow-sm hover:shadow-md transition">
                            <i class="fas fa-paper-plane mr-2"></i>Publish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit News/Event Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50 hidden">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">
            <div class="bg-gradient-to-r from-yellow-600 to-orange-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white">Edit News/Event</h3>
                        <p class="text-yellow-100 text-sm mt-1">Update your news article or event details</p>
                    </div>
                    <button id="closeEditModal" class="text-white hover:text-yellow-200 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                            <input type="text" name="title" id="edit_title" required
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2.5 border">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Cover Image</label>
                            <div id="currentCoverPreview" class="mb-3"></div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Replace Cover Image (Optional)</label>
                            <div id="editCoverUploadArea" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary-500 transition cursor-pointer">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                            <span>Choose new image</span>
                                            <input type="file" name="cover_image" id="edit_cover_image" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">Leave empty to keep current image</p>
                                </div>
                            </div>
                            <div id="editCoverPreview" class="mt-3 hidden">
                                <p class="text-sm text-gray-600 mb-2">New Preview:</p>
                                <img id="editCoverPreviewImg" class="h-32 w-auto rounded-lg object-cover shadow-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                            <textarea name="content" id="edit_content" rows="10"
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2.5 border summernote"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" id="cancelEditModal"
                                class="px-4 py-2 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-700 hover:to-orange-700 text-white rounded-xl shadow-sm hover:shadow-md transition">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        if ($.fn.DataTable && $('#newsEventsTable').length && $('#newsEventsTable tbody tr').length > 1) {
            $('#newsEventsTable').DataTable({
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
                        title: 'News_Events_' + new Date().toISOString().slice(0,10)
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
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns mr-2"></i>Columns',
                        className: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl transition'
                    }
                ],
                order: [[4, 'desc']],
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: [1, 5] }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search news...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ posts"
                },
                initComplete: function() {
                    $('.dt-buttons').addClass('flex flex-wrap gap-2');
                    $('.dataTables_filter input').addClass('border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary-500');
                    $('.dataTables_length select').addClass('border border-gray-300 rounded-xl px-3 py-2');
                }
            });
        }

        // Initialize Summernote
        $('.summernote').summernote({
            placeholder: 'Write your content here...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Modal functionality
        const createModal = document.getElementById('createModal');
        const editModal = document.getElementById('editModal');
        const createBtn = document.getElementById('createNewsBtn');

        function openCreateModal() { createModal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
        function closeCreateModal() { createModal.classList.add('hidden'); document.body.style.overflow = ''; }
        function closeEditModalFunc() { editModal.classList.add('hidden'); document.body.style.overflow = ''; }

        if(createBtn) createBtn.addEventListener('click', openCreateModal);
        document.getElementById('closeCreateModal')?.addEventListener('click', closeCreateModal);
        document.getElementById('cancelCreateModal')?.addEventListener('click', closeCreateModal);
        document.getElementById('closeEditModal')?.addEventListener('click', closeEditModalFunc);
        document.getElementById('cancelEditModal')?.addEventListener('click', closeEditModalFunc);

        createModal?.addEventListener('click', function(e) { if(e.target === createModal) closeCreateModal(); });
        editModal?.addEventListener('click', function(e) { if(e.target === editModal) closeEditModalFunc(); });

        // Cover image preview
        const coverInput = document.getElementById('create_cover_image');
        const coverPreview = document.getElementById('coverPreview');
        const coverPreviewImg = document.getElementById('coverPreviewImg');

        if(coverInput) {
            coverInput.addEventListener('change', function(e) {
                if(e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        coverPreviewImg.src = ev.target.result;
                        coverPreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }

        // File upload drag & drop
        const uploadArea = document.getElementById('coverUploadArea');
        if(uploadArea && coverInput) {
            uploadArea.addEventListener('click', () => coverInput.click());
            uploadArea.addEventListener('dragover', (e) => { e.preventDefault(); uploadArea.classList.add('border-primary-500', 'bg-primary-50'); });
            uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('border-primary-500', 'bg-primary-50'));
            uploadArea.addEventListener('drop', (e) => { e.preventDefault(); uploadArea.classList.remove('border-primary-500', 'bg-primary-50'); coverInput.files = e.dataTransfer.files; });
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

    // Edit modal functions
    function openEditModal(event) {
        const editModal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        const titleInput = document.getElementById('edit_title');
        const contentInput = document.getElementById('edit_content');
        const currentCoverPreview = document.getElementById('currentCoverPreview');

        form.action = '/newsandevent/' + event.id;
        titleInput.value = event.title;

        if(event.cover_image) {
            currentCoverPreview.innerHTML = `
                <img src="/storage/${event.cover_image}" class="h-24 w-auto rounded-lg object-cover shadow-sm">
            `;
        } else {
            currentCoverPreview.innerHTML = `<p class="text-gray-500 text-sm">No cover image</p>`;
        }

        // Set Summernote content
        $('#edit_content').summernote('code', event.content);

        editModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Delete confirmation
    function confirmDelete(button) {
        Swal.fire({
            title: 'Delete News/Event?',
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

    #newsEventsTable tbody tr {
        transition: all 0.2s ease;
    }

    #newsEventsTable tbody tr:hover {
        background-color: #f9fafb;
    }

    /* Summernote styling */
    .note-editor {
        border-radius: 1rem !important;
        border-color: #e2e8f0 !important;
    }

    .note-toolbar {
        background: #f8fafc !important;
        border-radius: 1rem 1rem 0 0 !important;
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
