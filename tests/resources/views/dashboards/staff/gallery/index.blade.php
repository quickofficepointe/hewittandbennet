@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Gallery Management')

@section('content')
<!-- Success/Error Messages -->
@if($errors->any())
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <i class="fas fa-exclamation-circle mr-2"></i>
                <strong>Error!</strong>
            </div>
            <button @click="show = false" class="text-red-700 hover:text-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="mt-2 text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

<div x-data="{ openGalleryModal: false, openEditGalleryModal: false, galleryItem: {} }" x-cloak>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Gallery</h2>
        <button @click="openGalleryModal = true" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Gallery Item
        </button>
    </div>

    <!-- Add Gallery Modal -->
    <div x-show="openGalleryModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <!-- Modal Content -->
        <div x-show="openGalleryModal" class="fixed inset-0 z-50 overflow-y-auto" @click.away="openGalleryModal = false">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-blue-700 px-4 py-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-white">Add Gallery Item</h3>
                            <button @click="openGalleryModal = false" class="text-white hover:text-blue-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Added Alpine data block to prevent double submission -->
                        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                                    <input type="text" id="title" name="title" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                                    <textarea id="description" name="description" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"></textarea>
                                </div>
                                <div>
                                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File *</label>
                                    <input type="file" id="file" name="file" required accept="image/*,video/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                                    <p class="mt-1 text-sm text-gray-500">Upload an image or video file</p>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" @click="openGalleryModal = false" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Cancel
                                </button>

                                <!-- Save Button Now Protected Against Double Click -->
                                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" :disabled="submitting" x-text="submitting ? 'Saving...' : 'Save Item'">
                                    Save Item
                                </button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table id="galleryTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($galleries as $gallery)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $gallery->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $gallery->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($gallery->file_type == 'image')
                            <img src="{{ asset('storage/' . $gallery->file_path) }}" class="h-16 w-auto rounded" alt="{{ $gallery->title }}">
                            @else
                            <video class="h-16 w-auto rounded" controls>
                                <source src="{{ asset('storage/' . $gallery->file_path) }}" type="video/{{ pathinfo($gallery->file_path, PATHINFO_EXTENSION) }}">
                            </video>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <button @click="openEditGalleryModal = true; galleryItem = {{ json_encode($gallery) }}" class="text-yellow-600 hover:text-yellow-900 transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('gallery.destroy', $gallery) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')" class="text-red-600 hover:text-red-900 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Gallery Modal -->
    <div x-show="editGalleryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md" @click.away="editGalleryModal = false">
            <h2 class="text-xl font-semibold mb-4">Edit Gallery Item</h2>

            <!-- Alpine state for preventing double submit -->
            <form id="editGalleryForm" method="POST" enctype="multipart/form-data" x-data="{ submitting: false }" x-on:submit="submitting = true">
                @csrf
                @method('PUT')

                <input type="hidden" name="gallery_id" x-model="editGallery.id" />

                <div class="mb-4">
                    <label for="edit_title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="edit_title" x-model="editGallery.title" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
                </div>

                <div class="mb-4">
                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="edit_description" x-model="editGallery.description" required rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2"></textarea>
                </div>

                <div class="mb-4">
                    <label for="edit_file" class="block text-sm font-medium text-gray-700">Change File (optional)</label>
                    <input type="file" name="file" id="edit_file" class="mt-1 block w-full text-sm text-gray-500">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded" x-on:click="editGalleryModal = false">Cancel</button>

                    <!-- Same double submit protection -->
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded" :disabled="submitting" x-text="submitting ? 'Saving...' : 'Update Item'"></button>
                </div>
            </form>
        </div>
    </div>

</div>


@endsection

@section('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('openEditGalleryModal', function(galleryItem) {
            this.galleryItem = galleryItem;
            this.openEditGalleryModal = true;
        });
    });

    $(document).ready(function() {
        $('#galleryTable').DataTable({
            responsive: true
            , dom: '<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"l><"flex space-x-2"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"i><"flex space-x-2"p>>'
            , language: {
                search: "_INPUT_"
                , searchPlaceholder: "Search..."
            , }
        });
    });

</script>
@endsection

@section('styles')
<style>
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        @apply px-4 py-3;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        @apply px-3 py-1 rounded border border-gray-300 mx-1;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        @apply bg-blue-700 text-white border-blue-700;
    }

    .dataTables_wrapper .dataTables_filter input {
        @apply rounded-md border-gray-300 shadow-sm focus: border-blue-500 focus:ring-blue-500 p-2 border;
    }

    .dataTables_wrapper .dataTables_length select {
        @apply rounded-md border-gray-300 shadow-sm focus: border-blue-500 focus:ring-blue-500 p-2 border;
    }

</style>
@endsection
