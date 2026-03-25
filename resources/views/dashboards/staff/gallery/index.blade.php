@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Gallery Management')

@section('content')
<!-- Success/Error Messages -->
@if($errors->any())
<div x-data="{ show: true }"
     x-show="show"
     x-transition
     x-init="setTimeout(() => show = false, 3000)"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
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
<div x-data="{ show: true }"
     x-show="show"
     x-transition
     x-init="setTimeout(() => show = false, 3000)"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Gallery</h2>
        <button @click="openGalleryModal = true"
                class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Gallery Item
        </button>
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
                            <button @click="openEditGalleryModal({{ json_encode($gallery) }})"
                                    class="text-yellow-600 hover:text-yellow-900 transition">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Gallery Modal -->
<div x-data="{ openGalleryModal: false }" x-cloak>
    <!-- Modal Backdrop -->
    <div x-show="openGalleryModal"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Modal Content -->
    <div x-show="openGalleryModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="openGalleryModal = false">
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
                    <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                                <input type="text" id="title" name="title" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                                <textarea id="description" name="description" required
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"></textarea>
                            </div>
                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File *</label>
                                <input type="file" id="file" name="file" required accept="image/*,video/*"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                                <p class="mt-1 text-sm text-gray-500">Upload an image or video file</p>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openGalleryModal = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Save Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Gallery Modal -->
<div x-data="{ openEditGalleryModal: false, galleryItem: {} }" x-cloak>
    <!-- Modal Backdrop -->
    <div x-show="openEditGalleryModal"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Modal Content -->
    <div x-show="openEditGalleryModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="openEditGalleryModal = false">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-blue-700 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-white">Edit Gallery Item</h3>
                        <button @click="openEditGalleryModal = false" class="text-white hover:text-blue-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form x-bind:action="'/gallery/' + galleryItem.id" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                                <input type="text" id="edit_title" name="title" x-model="galleryItem.title" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                                <textarea id="edit_description" name="description" x-model="galleryItem.description" required
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"></textarea>
                            </div>
                            <div>
                                <label for="edit_file" class="block text-sm font-medium text-gray-700 mb-1">Upload New File (Optional)</label>
                                <input type="file" id="edit_file" name="file" accept="image/*,video/*"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                                <template x-if="galleryItem.file_path">
                                    <div class="mt-2">
                                        <small>Current File:</small>
                                        <template x-if="galleryItem.file_type === 'image'">
                                            <img x-bind:src="'/storage/' + galleryItem.file_path" class="mt-1 h-16 w-auto rounded">
                                        </template>
                                        <template x-if="galleryItem.file_type === 'video'">
                                            <video class="mt-1 h-16 w-auto rounded" controls>
                                                <source x-bind:src="'/storage/' + galleryItem.file_path" x-bind:type="'video/' + galleryItem.file_path.split('.').pop()">
                                            </video>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openEditGalleryModal = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
            responsive: true,
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"l><"flex space-x-2"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"i><"flex space-x-2"p>>',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
            }
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
        @apply rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border;
    }
    .dataTables_wrapper .dataTables_length select {
        @apply rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border;
    }
</style>
@endsection
