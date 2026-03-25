@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Edit Banner')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Banner</h2>

        <!-- Update Banner Form -->
        <form action="{{ route('hewitt_banners.update', $banner->id) }}" method="post" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('patch')

            <!-- Current Image -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Current Image:</label>
                <div class="flex items-center space-x-4">
                    <img src="{{ $banner->image_path }}" alt="Current Banner" class="h-32 object-contain border border-gray-200 rounded">
                    <span class="text-gray-600">{{ $banner->image_name }}</span>
                </div>
            </div>

            <!-- New Image Upload -->
            <div class="space-y-2">
                <label for="image" class="block text-sm font-medium text-gray-700">New Image:</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                    </div>
                </div>
            </div>

            <!-- Status Selector -->
            <div class="space-y-2">
                <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="1" {{ $banner->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$banner->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Banner
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
