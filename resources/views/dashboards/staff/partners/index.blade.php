@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Partnership Management')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Partner Organizations</h2>
        <button id="addPartnerBtn" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Partner
        </button>
    </div>

    <!-- Partners Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200" id="partnersTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($partners as $partner)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-10 w-10 rounded-full object-cover">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $partner->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500 line-clamp-2">{{ $partner->description }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button data-partner='{{ json_encode($partner) }}' class="edit-btn text-primary hover:text-primary-dark mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button data-id="{{ $partner->id }}" class="delete-btn text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Create Partner Modal -->
<div id="createModal" class="fixed inset-0 overflow-y-auto z-50 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div id="createModalContent" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <form method="POST" action="{{ route('partners.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Add New Partner</h3>

                    <div class="mb-4">
                        <label for="partner_name" class="block text-sm font-medium text-gray-700">Partner Name</label>
                        <input type="text" name="partner_name" id="partner_name" required
                               class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="partner_logo" class="block text-sm font-medium text-gray-700">Logo</label>
                        <input type="file" name="partner_logo" id="partner_logo" accept="image/*" required
                               class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="partner_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="partner_description" id="partner_description" rows="3" required
                                  class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button type="button" id="cancelCreateBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Partner Modal -->
<div id="editModal" class="fixed inset-0 overflow-y-auto z-50 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div id="editModalContent" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <form method="POST" id="editForm" action="partners.update"    enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Partner</h3>

                    <div class="mb-4">
                        <label for="edit_partner_name" class="block text-sm font-medium text-gray-700">Partner Name</label>
                        <input type="text" name="partner_name" id="edit_partner_name" required
                               class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Current Logo</label>
                        <img id="currentLogo" src="" alt="" class="h-16 w-16 object-contain">
                    </div>

                    <div class="mb-4">
                        <label for="edit_partner_logo" class="block text-sm font-medium text-gray-700">New Logo (Leave blank to keep current)</label>
                        <input type="file" name="partner_logo" id="edit_partner_logo" accept="image/*"
                               class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="edit_partner_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="partner_description" id="edit_partner_description" rows="3" required
                                  class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Update
                    </button>
                    <button type="button" id="cancelEditBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 overflow-y-auto z-50 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div id="deleteModalContent" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Partner</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Are you sure you want to delete this partner? This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form method="POST" action="partners.destroy" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                </form>
                <button type="button" id="cancelDeleteBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal elements
        const createModal = document.getElementById('createModal');
        const editModal = document.getElementById('editModal');
        const deleteModal = document.getElementById('deleteModal');
        
        // Buttons
        const addPartnerBtn = document.getElementById('addPartnerBtn');
        const cancelCreateBtn = document.getElementById('cancelCreateBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        
        // Forms
        const editForm = document.getElementById('editForm');
        const deleteForm = document.getElementById('deleteForm');
        
        // Edit form elements
        const editNameInput = document.getElementById('edit_partner_name');
        const editDescInput = document.getElementById('edit_partner_description');
        const currentLogoImg = document.getElementById('currentLogo');
        
        // Show create modal
        addPartnerBtn.addEventListener('click', function() {
            createModal.classList.remove('hidden');
        });
        
        // Hide create modal
        cancelCreateBtn.addEventListener('click', function() {
            createModal.classList.add('hidden');
        });
        
        // Hide edit modal
        cancelEditBtn.addEventListener('click', function() {
            editModal.classList.add('hidden');
        });
        
        // Hide delete modal
        cancelDeleteBtn.addEventListener('click', function() {
            deleteModal.classList.add('hidden');
        });
        
        // Edit button click handlers
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const partnerData = JSON.parse(this.getAttribute('data-partner'));
                
                // Populate form with partner data
                editForm.action = `/partners/${partnerData.id}`;
                editNameInput.value = partnerData.name;
                editDescInput.value = partnerData.description;
                currentLogoImg.src = `/storage/${partnerData.logo}`;
                currentLogoImg.alt = partnerData.name;
                
                // Show modal
                editModal.classList.remove('hidden');
            });
        });
        
        // Delete button click handlers
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const partnerId = this.getAttribute('data-id');
                
                // Set form action
                deleteForm.action = `/partners/${partnerId}`;
                
                // Show modal
                deleteModal.classList.remove('hidden');
            });
        });
        
        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target === createModal) {
                createModal.classList.add('hidden');
            }
            if (event.target === editModal) {
                editModal.classList.add('hidden');
            }
            if (event.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });

        // Initialize DataTable
        $('#partnersTable').DataTable({
            responsive: true,
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"l><"flex space-x-2"Bf>>rt<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"i><"flex space-x-2"p>>',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fas fa-copy mr-1"></i> Copy',
                    className: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                    className: 'bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Print',
                    className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search partners..."
            }
        });
    });
</script>
@endsection
