@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'News & Events Management')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-primary">Published News & Events</h2>
        <button type="button"
                class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition flex items-center"
                onclick="toggleModal('createModal')">
            <i class="fas fa-plus-circle mr-2"></i> Add News/Event
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="newsEventsTable" class="w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover Image</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($newsEvents as $event)
                <tr>
                    <td class="px-4 py-3 whitespace-normal">
                        <div class="font-medium text-gray-900">{{ $event->title }}</div>
                        <div class="text-sm text-gray-500">{{ $event->slug }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if ($event->cover_image)
                        <img src="{{ asset('storage/' . $event->cover_image) }}"
                             alt="Cover Image"
                             class="h-16 w-16 object-cover rounded-md shadow-sm">
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-500">
                        {!! Str::limit(strip_tags($event->content), 100) !!}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        {{ $event->user->name }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        {{ $event->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button type="button"
                                    class="text-yellow-600 hover:text-yellow-900 transition"
                                    onclick="toggleModal('editModal{{ $event->id }}')"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('newsandevent.destroy', $event->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900 transition"
                                        onclick="return confirm('Are you sure you want to delete this item?')"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div id="editModal{{ $event->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleModal('editModal{{ $event->id }}')"></div>

                        <!-- Modal panel -->
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                            <div class="bg-primary px-4 py-3 sm:px-6 sm:flex sm:items-center sm:justify-between">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">Edit News/Event</h3>
                                <button type="button" class="text-white hover:text-gray-200" onclick="toggleModal('editModal{{ $event->id }}')">
                                    <span class="sr-only">Close</span>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <form action="{{ route('newsandevent.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="mb-4">
                                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                        <input type="text" name="title" id="title" value="{{ $event->title }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Image</label>
                                        <div class="mt-1 flex items-center">
                                            @if ($event->cover_image)
                                            <img src="{{ asset('storage/' . $event->cover_image) }}"
                                                 alt="Current Cover"
                                                 class="h-16 w-16 object-cover rounded-md mr-4">
                                            @endif
                                            <input type="file" name="cover_image" id="cover_image"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-lighter file:text-primary hover:file:bg-primary-light">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                                        <textarea name="content" id="content{{ $event->id }}" rows="8"
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 summernote" required>{{ $event->content }}</textarea>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                                        Save Changes
                                    </button>
                                    <button type="button" onclick="toggleModal('editModal{{ $event->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleModal('createModal')"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-primary px-4 py-3 sm:px-6 sm:flex sm:items-center sm:justify-between">
                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">Add News/Event</h3>
                <button type="button" class="text-white hover:text-gray-200" onclick="toggleModal('createModal')">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('newsandevent.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
                    </div>

                    <div class="mb-4">
                        <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Image</label>
                        <input type="file" name="cover_image" id="cover_image"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-lighter file:text-primary hover:file:bg-primary-light">
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea name="content" id="content1" rows="8"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 summernote" required></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Publish
                    </button>
                    <button type="button" onclick="toggleModal('createModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle modal function
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }

    $(document).ready(function() {
        // Initialize DataTable
        $('#newsEventsTable').DataTable({
            responsive: true,
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"l><"flex space-x-2"Bf>>rt<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"i><"flex space-x-2"p>>',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fas fa-copy mr-1"></i> Copy',
                    className: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    titleAttr: 'Copy to clipboard'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                    className: 'bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'News_Events_Export',
                    titleAttr: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'News & Events - Hewitt and Bennet International College',
                    titleAttr: 'Export to PDF'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Print',
                    className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'News & Events - Hewitt and Bennet International College',
                    titleAttr: 'Print table'
                }
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 0 }, // Title
                { responsivePriority: 2, targets: -1 }, // Actions
                { responsivePriority: 3, targets: 2 },  // Preview
                { responsivePriority: 4, targets: 1 },  // Cover Image
                { responsivePriority: 5, targets: 3 },  // Author
                { responsivePriority: 6, targets: 4 }  // Published
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search news...",
            }
        });

        // Initialize Summernote
        $('.summernote').summernote({
            placeholder: 'Write your content here...',
            tabsize: 2,
            height: 300,
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
    });
</script>
@endsection
