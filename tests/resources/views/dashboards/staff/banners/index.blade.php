@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Banners Management')

@section('content')
<!-- Error Messages -->
@if($errors->any())
<div x-data="{ show: true }" x-show="show" x-transition class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
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

<!-- Success Message -->
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h4 class="text-lg font-semibold text-gray-800">All Banners</h4>
            <button id="openModalBtn" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Add Banner
            </button>
        </div>
        <div class="overflow-x-auto">
            <table id="myDataTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delete</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($banners as $banner)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $banner->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ $banner->image_path }}" alt="Banner Image" class="max-w-[100px] max-h-[100px] object-contain">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                @if ($banner->status == 1)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                <form action="{{ route('hewitt_banners.update', $banner->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-800 hover:bg-red-200 transition">
                                        Deactivate
                                    </button>
                                </form>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                <form action="{{ route('hewitt_banners.update', $banner->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-800 hover:bg-green-200 transition">
                                        Activate
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('hewitt_banners.edit', $banner->id) }}" class="text-blue-600 hover:text-blue-800 transition flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('hewitt_banners.destroy', $banner->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this banner?');" class="text-red-600 hover:text-red-800 transition flex items-center">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Backdrop -->
<div id="bannerModalBackdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 z-40 hidden"></div>

<!-- Modal -->
<div id="bannerModal" class="fixed inset-0 z-50 overflow-y-auto hidden">

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl sm:w-full sm:max-w-3xl">
            <div class="bg-blue-700 px-4 py-3 flex items-center justify-between">
                <h3 class="text-lg font-medium text-white">Add New Banner</h3>
                <button id="closeModalBtn" class="text-white hover:text-blue-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('hewitt_banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="banner_image" class="block text-sm font-medium text-gray-700">Banner Image</label>
                        <input type="file" name="image" id="banner_image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-700 focus:ring focus:ring-blue-700 focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-4">
                        <label for="banner_status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="banner_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-700 focus:ring focus:ring-blue-700 focus:ring-opacity-50">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="closeModalBtn2" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-700 hover:bg-blue-800">
                            Save Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
<script>
    // Global modal toggle function for add and edit modals
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

</script>
<script>
    // Toggle modal function
    document.addEventListener('DOMContentLoaded', function() {
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const closeBtn2 = document.getElementById('closeModalBtn2');
        const modal = document.getElementById('bannerModal');
        const backdrop = document.getElementById('bannerModalBackdrop');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            backdrop.classList.remove('hidden');
        });

        const closeModal = () => {
            modal.classList.add('hidden');
            backdrop.classList.add('hidden');
        };

        closeBtn.addEventListener('click', closeModal);
        closeBtn2.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
    });

    $(document).ready(function() {
        // Prevent double submission of delete banner form
        $('.delete-banner-form').on('submit', function(e) {
            var btn = $(this).find('.delete-banner-btn');
            btn.prop('disabled', true);
        });

    });

</script>

@endsection
