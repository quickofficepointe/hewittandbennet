@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Campuses Management')

@section('content')
@if(session('success'))
<div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
</div>
@endif

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Campuses</h2>
        <button id="openModalBtn" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Campus
        </button>
    </div>

    <!-- Campus Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table id="campusesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Country</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($campuses as $campus)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $campus->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $campus->city }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $campus->country }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-1">
                                @if($campus->active)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                @endif
                                @if($campus->is_main)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Main</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <!-- Future Edit Button -->
                                <form action="{{ route('campuses.destroy', $campus->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this campus?')" class="text-red-600 hover:text-red-900 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Backdrop -->
<div id="campusModalBackdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 z-40 hidden"></div>

<!-- Modal -->
<div id="campusModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl sm:w-full sm:max-w-3xl">
            <div class="bg-blue-700 px-4 py-3 flex items-center justify-between">
                <h3 class="text-lg font-medium text-white">Add New Campus</h3>
                <button id="closeModalBtn" class="text-white hover:text-blue-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('campuses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Campus Name *</label>
                            <input type="text" id="name" name="name" required class="w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" rows="6" class="w-full rounded-md border-gray-300 shadow-sm p-2 border summernote" required></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                <input type="text" id="city" name="city" required class="w-full rounded-md border-gray-300 shadow-sm p-2 border">
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                <input type="text" id="country" name="country" value="Kenya" required class="w-full rounded-md border-gray-300 shadow-sm p-2 border">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" id="phone" name="phone" class="w-full rounded-md border-gray-300 shadow-sm p-2 border">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" class="w-full rounded-md border-gray-300 shadow-sm p-2 border">
                            </div>
                        </div>

                        <div>
                            <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-1">Banner Image</label>
                            <input type="file" id="banner_image" name="banner_image" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm p-2 border">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_main" name="is_main" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <label for="is_main" class="ml-2 block text-sm text-gray-700">Main Campus</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="active" name="active" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <label for="active" class="ml-2 block text-sm text-gray-700">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" id="closeModalBtn2" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-700 hover:bg-blue-800">
                            Save Campus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const closeBtn2 = document.getElementById('closeModalBtn2');
        const modal = document.getElementById('campusModal');
        const backdrop = document.getElementById('campusModalBackdrop');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            backdrop.classList.remove('hidden');
            setTimeout(function() {
                $('#description.summernote').summernote({
                    placeholder: 'Write your description here...',
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
            }, 100); // Delay to ensure modal is visible
        });

        const closeModal = () => {
            modal.classList.add('hidden');
            backdrop.classList.add('hidden');
        };

        closeBtn.addEventListener('click', closeModal);
        closeBtn2.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
    });

</script>

<style>
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 1rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        border: 1px solid #d1d5db;
        margin: 0 0.25rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #1d4ed8;
        color: #fff;
        border-color: #1d4ed8;
    }

</style>
@endsection
