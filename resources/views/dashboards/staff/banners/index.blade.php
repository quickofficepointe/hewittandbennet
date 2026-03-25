@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Banners Management')

@section('content')
<!-- Error Messages -->
@if($errors->any())
<div x-data="{ show: true }"
     x-show="show"
     x-transition
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

<!-- Success Message -->
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
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h4 class="text-lg font-semibold text-gray-800">All Banners</h4>
            <button @click="openModal = true"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
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
                            <a href="{{ route('hewitt_banners.edit', $banner->id) }}"
                               class="text-blue-600 hover:text-blue-800 transition flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('hewitt_banners.destroy', $banner->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this banner?');"
                                        class="text-red-600 hover:text-red-800 transition flex items-center">
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

<!-- Add Banner Modal -->
<div x-data="{ openModal: false }" x-cloak>
    <!-- Modal Backdrop -->
    <div x-show="openModal"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Modal Content -->
    <div x-show="openModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="openModal = false">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-blue-700 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-white">Add New Banner</h3>
                        <button @click="openModal = false" class="text-white hover:text-blue-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('hewitt_banners.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" required>
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openModal = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Upload Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
