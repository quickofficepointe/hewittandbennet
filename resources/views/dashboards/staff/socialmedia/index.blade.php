@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'TikTok Videos Management')

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
        <h2 class="text-2xl font-bold text-gray-800">TikTok Videos</h2>
        <button @click="openTikTokModal = true"
                class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Video
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table id="videosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Video</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($videos as $video)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="tiktok-embed" style="max-width: 150px;">
                                <iframe
                                    src="https://www.tiktok.com/embed/v2/{{ basename($video->video_url) }}"
                                    style="width: 100%; height: 200px; border: none;"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="{{ $video->video_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition truncate max-w-xs inline-block">
                                {{ $video->video_url }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <button @click="openEditTikTokModal({{ json_encode($video) }})"
                                        class="text-yellow-600 hover:text-yellow-900 transition">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="deleteTikTokVideo({{ $video->id }})"
                                        class="text-red-600 hover:text-red-900 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TikTok Modal -->
<div x-data="{ openTikTokModal: false }" x-cloak>
    <!-- Modal Backdrop -->
    <div x-show="openTikTokModal"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Modal Content -->
    <div x-show="openTikTokModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="openTikTokModal = false">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-blue-700 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-white">Add TikTok Video</h3>
                        <button @click="openTikTokModal = false" class="text-white hover:text-blue-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form id="addVideoForm" action="{{ route('tiktok-videos.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-1">TikTok Video URL *</label>
                                <input type="url" id="video_url" name="video_url" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                       placeholder="https://www.tiktok.com/@username/video/1234567890123456789">
                                <p class="mt-1 text-sm text-gray-500">Paste the full TikTok video URL</p>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openTikTokModal = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Save Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit TikTok Modal -->
<div x-data="{ openEditTikTokModal: false, tiktokVideo: {} }" x-cloak>
    <!-- Modal Backdrop -->
    <div x-show="openEditTikTokModal"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Modal Content -->
    <div x-show="openEditTikTokModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="openEditTikTokModal = false">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-blue-700 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-white">Edit TikTok Video</h3>
                        <button @click="openEditTikTokModal = false" class="text-white hover:text-blue-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form x-bind:action="'/tiktok-videos/' + tiktokVideo.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="edit_video_url" class="block text-sm font-medium text-gray-700 mb-1">TikTok Video URL *</label>
                                <input type="url" id="edit_video_url" name="video_url" x-model="tiktokVideo.video_url" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openEditTikTokModal = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Video
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
        Alpine.store('openEditTikTokModal', function(video) {
            this.tiktokVideo = video;
            this.openEditTikTokModal = true;
        });

        Alpine.store('deleteTikTokVideo', function(id) {
            if (confirm('Are you sure you want to delete this video?')) {
                fetch(`/tiktok-videos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });

    $(document).ready(function() {
        $('#videosTable').DataTable({
            responsive: true,
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"l><"flex space-x-2"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"i><"flex space-x-2"p>>',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
            }
        });

        // Handle form submissions
        $('#addVideoForm').submit(function(e) {
            e.preventDefault();
            const form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Alpine.store('openTikTokModal', false);
                    form[0].reset();
                    location.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection

@section('styles')
<style>
    .tiktok-embed {
        border-radius: 4px;
        overflow: hidden;
    }
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
