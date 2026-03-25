@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Registered Users')

@section('content')

<!-- Success/Error Messages -->
@if($errors->any())
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
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
<div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-primary">Registered Users</h2>
    </div>

    <div class="overflow-x-auto">
        {{-- Enhanced table with DataTables.js --}}
        <table id="usersTable" class="w-full table-auto border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Course</th>
                    <th class="px-4 py-3">Applied</th>
                    <th class="px-4 py-3">Month</th>
                    <th class="px-4 py-3">Year</th>
                    <th class="px-4 py-3">Mode</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($courseapplications as $index => $application)
                <tr class="hover:bg-blue-50">
                    <td class="px-4 py-3 text-center font-semibold">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">{{ $application->name }}</td>
                    <td class="px-4 py-3">{{ $application->email }}</td>
                    <td class="px-4 py-3">{{ $application->location }}</td>
                    <td class="px-4 py-3">{{ $application->phoneNumber }}</td>
                    <td class="px-4 py-3">{{ $application->course }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($application->timestamp)->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3">{{ $application->startMonth }}</td>
                    <td class="px-4 py-3">{{ $application->startYear }}</td>
                    <td class="px-4 py-3">{{ $application->modeOfLearning }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex gap-2 justify-center">
                            <form action="{{ route('studentregistration.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs font-semibold" title="Delete">
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

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
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
                    , title: 'Student_Records_Export'
                    , titleAttr: 'Export to Excel'
                }
                , {
                    extend: 'pdfHtml5'
                    , text: '<i class="fas fa-file-pdf mr-1"></i> PDF'
                    , className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                    , title: 'Student Records - Hewitt and Bennet International College'
                    , titleAttr: 'Export to PDF'
                    , orientation: 'landscape'
                    , pageSize: 'A4'
                }
                , {
                    extend: 'print'
                    , text: '<i class="fas fa-print mr-1"></i> Print'
                    , className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                    , title: 'Student Records - Hewitt and Bennet International College'
                    , titleAttr: 'Print table'
                }
            ]
            , lengthMenu: [
                [10, 25, 50, 100, -1]
                , ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
            ]
            , pageLength: 25
            , language: {
                search: "_INPUT_"
                , searchPlaceholder: "Search..."
            , }
        });
    });

</script>

@endsection
