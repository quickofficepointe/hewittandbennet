@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Teams Management')

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

<div x-data="{ openTeamModal: false, openEditTeamModal: false, editTeam: { id: '', name: '', description: '', image: '' } }" x-cloak class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Teams</h2>
        <button @click="openTeamModal = true" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Team
        </button>
    </div>

    <!-- Add Team Modal -->
    <div x-show="openTeamModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openTeamModal = false"></div>
        <div class="relative z-10 w-full max-w-lg mx-auto">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all">
                <div class="bg-blue-700 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-white">Add Team</h3>
                        <button @click="openTeamModal = false" class="text-white hover:text-blue-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form id="addTeamForm" action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="team_name" class="block text-sm font-medium text-gray-700 mb-1">Team Name *</label>
                                <input type="text" id="team_name" name="name" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border" placeholder="Enter team name">
                            </div>
                            <div>
                                <label for="team_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="team_description" name="description" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border" rows="4" placeholder="Enter team description"></textarea>
                            </div>                            
                            <div>
                                <label for="team_image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                                <input type="file" id="team_image" name="image" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openTeamModal = false" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Save Team
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Team Modal -->
    <div x-show="openEditTeamModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openEditTeamModal = false"></div>
        <div class="relative z-10 w-full max-w-lg mx-auto">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all">
                <div class="bg-blue-700 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-white">Edit Team</h3>
                        <button @click="openEditTeamModal = false" class="text-white hover:text-blue-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form id="editTeamForm" :action="'/teams/' + editTeam.id" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="edit_team_name" class="block text-sm font-medium text-gray-700 mb-1">Team Name *</label>
                                <input type="text" id="edit_team_name" name="name" x-model="editTeam.name" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border" placeholder="Enter team name">
                            </div>
                            <div>
                                <label for="edit_team_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="edit_team_description" name="description" x-model="editTeam.description" class="summernote w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border" rows="4"></textarea>
                            </div>                            
                            <div>
                                <label for="edit_team_image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                                <input type="file" id="edit_team_image" name="image" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openEditTeamModal = false" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Team
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                        <img src="{{ asset('storage/' . $team->image) }}" alt="{{ $team->name }}" class="w-12 h-12 rounded-md object-cover shadow-sm">
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
                            <button type="button" class="text-yellow-600 hover:text-yellow-900 transition" @click="editTeam = { id: '{{ $team->id }}', name: '{{ $team->name }}', description: `{{ addslashes($team->description) }}`, image: '{{ $team->image }}' }; openEditTeamModal = true" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition" onclick="return confirm('Are you sure you want to delete this team?')" title="Delete">
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

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#teamsTable').DataTable({
            responsive: true
            , dom: '<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"l><"flex space-x-2"Bf>>rt<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"i><"flex space-x-2"p>>'
            , buttons: [{
                    extend: 'copyHtml5'
                    , text: '<i class="fas fa-copy mr-1"></i> Copy'
                    , className: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                    , titleAttr: 'Copy to clipboard'
                }
                , {
                    extend: 'excelHtml5'
                    , text: '<i class="fas fa-file-excel mr-1"></i> Excel'
                    , className: 'bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                    , title: 'Teams_Export'
                    , titleAttr: 'Export to Excel'
                }
                , {
                    extend: 'pdfHtml5'
                    , text: '<i class="fas fa-file-pdf mr-1"></i> PDF'
                    , className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                    , title: 'Teams - Hewitt and Bennet International College'
                    , titleAttr: 'Export to PDF'
                }
                , {
                    extend: 'print'
                    , text: '<i class="fas fa-print mr-1"></i> Print'
                    , className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                    , title: 'Teams - Hewitt and Bennet International College'
                    , titleAttr: 'Print table'
                }
            ]
            , columnDefs: [{
                    responsivePriority: 1
                    , targets: 2
                }, // Name
                {
                    responsivePriority: 2
                    , targets: -1
                }, // Actions
                {
                    responsivePriority: 3
                    , targets: 3
                }, // Description
                {
                    responsivePriority: 4
                    , targets: 1
                }, // Image
                {
                    responsivePriority: 5
                    , targets: 0
                } // #
            ]
            , language: {
                search: "_INPUT_"
                , searchPlaceholder: "Search teams..."
            }
        });
    });
</script>
@endsection
