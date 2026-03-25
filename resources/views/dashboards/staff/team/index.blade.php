@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Teams Management')

@section('content')
@if(session('success'))
<div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50">
    <div class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center justify-between max-w-md">
        <span>{{ session('success') }}</span>
        <button type="button" class="text-white hover:text-gray-200" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.bg-green-500')?.remove();
    }, 3000);
</script>
@endif

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-primary">Teams</h2>
        <button type="button"
                class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition flex items-center"
                onclick="toggleModal('createModal')">
            <i class="fas fa-plus mr-2"></i> Add Team
        </button>
    </div>

    <!-- Team Table -->
    <div class="overflow-x-auto">
        <table id="teamsTable" class="w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($teams as $team)
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($team->image)
                        <img src="{{ asset('storage/' . $team->image) }}" alt="{{ $team->name }}"
                             class="w-12 h-12 rounded-md object-cover shadow-sm">
                        @else
                        <div class="w-12 h-12 bg-gray-100 rounded-md flex items-center justify-center text-gray-400">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-normal">
                        <div class="text-sm font-medium text-gray-900">{{ $team->name }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-500">
                        {{ Str::limit($team->description, 50) }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button type="button"
                                    class="text-yellow-600 hover:text-yellow-900 transition"
                                    onclick="openEditModal('{{ $team->id }}', '{{ addslashes($team->name) }}', '{{ addslashes($team->description) }}', '{{ $team->image }}')"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900 transition"
                                        onclick="return confirm('Are you sure you want to delete this team?')"
                                        title="Delete">
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

<!-- Create Team Modal -->
<div id="createModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleModal('createModal')"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-primary px-4 py-3 sm:px-6 sm:flex sm:items-center sm:justify-between">
                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">Add New Team</h3>
                <button type="button" class="text-white hover:text-gray-200" onclick="toggleModal('createModal')">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="createTeamForm" action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Team Name *</label>
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 summernote"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Team Image</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-lighter file:text-primary hover:file:bg-primary-light">
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Save Team
                    </button>
                    <button type="button" onclick="toggleModal('createModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Team Modal -->
<div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleModal('editModal')"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-primary px-4 py-3 sm:px-6 sm:flex sm:items-center sm:justify-between">
                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">Edit Team</h3>
                <button type="button" class="text-white hover:text-gray-200" onclick="toggleModal('editModal')">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editTeamForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <label for="edit_name" class="block text-sm font-medium text-gray-700">Team Name *</label>
                        <input type="text" name="name" id="edit_name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="edit_description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 summernote-edit"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="edit_image" class="block text-sm font-medium text-gray-700">Team Image</label>
                        <input type="file" name="image" id="edit_image" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-lighter file:text-primary hover:file:bg-primary-light">
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Current Image:</p>
                            <img id="current_image" src="" class="mt-1 rounded-md max-h-24 hidden">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Update Team
                    </button>
                    <button type="button" onclick="toggleModal('editModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
        
        // Reset form when closing create modal
        if (modalId === 'createModal' && modal.classList.contains('hidden')) {
            document.getElementById('createTeamForm').reset();
            if (typeof $('.summernote').summernote === 'function') {
                $('.summernote').summernote('code', '');
            }
        }
    }

    // Open edit modal with data
    function openEditModal(id, name, description, image) {
        // Set form action
        document.getElementById('editTeamForm').action = `/teams/${id}`;

        // Set form values
        document.getElementById('edit_name').value = name;
        
        // Set summernote content
        if (typeof $('.summernote-edit').summernote === 'function') {
            $('.summernote-edit').summernote('code', description);
        } else {
            document.getElementById('edit_description').value = description;
        }

        // Show current image if exists
        const currentImage = document.getElementById('current_image');
        if (image) {
            currentImage.src = `/storage/${image}`;
            currentImage.classList.remove('hidden');
        } else {
            currentImage.classList.add('hidden');
        }

        // Open modal
        toggleModal('editModal');
    }

    $(document).ready(function() {
        // Initialize DataTable
        $('#teamsTable').DataTable({
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
                    title: 'Teams_Export',
                    titleAttr: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Teams - Hewitt and Bennet International College',
                    titleAttr: 'Export to PDF'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Print',
                    className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Teams - Hewitt and Bennet International College',
                    titleAttr: 'Print table'
                }
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 2 }, // Name
                { responsivePriority: 2, targets: -1 }, // Actions
                { responsivePriority: 3, targets: 3 },  // Description
                { responsivePriority: 4, targets: 1 },  // Image
                { responsivePriority: 5, targets: 0 }  // #
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search teams...",
            }
        });

        // Initialize Summernote for create modal
        if (typeof $.fn.summernote !== 'undefined') {
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview', 'help']]
                ]
            });

            // Initialize Summernote for edit modal
            $('.summernote-edit').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview', 'help']]
                ]
            });
        }

        // AJAX form submission for create
        $('#createTeamForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        });

        // AJAX form submission for edit
        $('#editTeamForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>
@endsection