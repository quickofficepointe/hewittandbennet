@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Testimonial Management')

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

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-primary">Testimonials</h2>
        <button id="openModalBtn" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
            <i class="fas fa-plus-circle mr-2"></i> Add testimonial
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="testimonialsTable" class="w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($testimonials as $testimonial)
                <tr>
                    <td class="px-4 py-3 whitespace-normal">
                        <div class="font-medium text-gray-900">{{ $testimonial->name }}</div>
                        <div class="text-sm text-gray-500">{{ $testimonial->slug }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if ($testimonial->avatar)
                        <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="Testimonial Avatar" class="h-16 w-16 object-cover rounded-md shadow-sm">
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-500">
                        {!! Str::limit(strip_tags($testimonial->testimony), 100) !!}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        {{ $testimonial->name }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        {{ $testimonial->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button type="button" class="text-yellow-600 hover:text-yellow-900 transition" onclick="toggleModal('editModal{{ $testimonial->id }}')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                                <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST" class="inline delete-testimonial-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition delete-testimonial-btn" onclick="return confirm('Are you sure you want to delete this testimonial?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div id="editModal{{ $testimonial->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleModal('editModal{{ $testimonial->id }}')"></div>

                        <!-- Modal panel -->
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                            <div class="bg-blue-700 px-4 py-3 sm:px-6 sm:flex sm:items-center sm:justify-between">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">Edit Testimonial</h3>
                                <button type="button" class="text-white hover:text-gray-200" onclick="toggleModal('editModal{{ $testimonial->id }}')">
                                    <span class="sr-only">Close</span>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="mb-4">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="name" id="name" value="{{ $testimonial->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-700 focus:ring focus:ring-blue-700 focus:ring-opacity-50" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="avatar" class="block text-sm font-medium text-gray-700">Image</label>
                                        <div class="mt-1 flex items-center">
                                            @if ($testimonial->avatar)
                                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="Current Avatar" class="h-16 w-16 object-cover rounded-md mr-4">
                                            @endif
                                            <input type="file" name="avatar" id="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="testimony" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="testimony" id="testimony{{ $testimonial->id }}" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-700 focus:ring focus:ring-blue-700 focus:ring-opacity-50 summernote" required>{{ $testimonial->testimony }}</textarea>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-700 text-base font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save Changes
                                    </button>
                                    <button type="button" onclick="toggleModal('editModal{{ $testimonial->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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

<!-- Modal Backdrop -->
<div id="testimonialModalBackdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 z-40 hidden"></div>

<!-- Modal -->
<div id="testimonialModal" class="fixed inset-0 z-50 overflow-y-auto hidden">

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl sm:w-full sm:max-w-3xl">
            <div class="bg-blue-700 px-4 py-3 flex items-center justify-between">
                <h3 class="text-lg font-medium text-white">Add New Testimonials</h3>
                <button id="closeModalBtn" class="text-white hover:text-blue-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="add_name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="add_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-700 focus:ring focus:ring-blue-700 focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-4">
                        <label for="add_avatar" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="avatar" id="add_avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
                    </div>
                    <div class="mb-4">
                        <label for="add_testimony" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="testimony" id="add_testimony" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-700 focus:ring focus:ring-blue-700 focus:ring-opacity-50 summernote" required></textarea>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" id="closeModalBtn2" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-700 hover:bg-blue-800">
                            Save Testimonial
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
        const modal = document.getElementById('testimonialModal');
        const backdrop = document.getElementById('testimonialModalBackdrop');

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
        // Prevent double submission of delete testimonial form
        $('.delete-testimonial-form').on('submit', function(e) {
            var btn = $(this).find('.delete-testimonial-btn');
            btn.prop('disabled', true);
        });

        // Initialize Summernote
        $('.summernote').summernote({
            placeholder: 'Enter testimonial description here...'
            , tabsize: 2
            , height: 300
            , toolbar: [
                ['style', ['style']]
                , ['font', ['bold', 'underline', 'clear']]
                , ['color', ['color']]
                , ['para', ['ul', 'ol', 'paragraph']]
                , ['table', ['table']]
                , ['insert', ['link', 'picture', 'video']]
                , ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

</script>
@endsection
