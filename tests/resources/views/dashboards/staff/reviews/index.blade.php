@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Reviews Management')

@section('content')
<!-- Error Messages -->
@if($errors->any())
    $(document).ready(function() {
        // Initialize DataTable with preferred options
        $('#studentsTable').DataTable({
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
                    title: 'Student_Records_Export',
                    titleAttr: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Student Records - Hewitt and Bennet International College',
                    titleAttr: 'Export to PDF',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Print',
                    className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Student Records - Hewitt and Bennet International College',
                    titleAttr: 'Print table'
                }
            ],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
            ],
            pageLength: 25,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
            }
        });
    });
                @foreach($review as $reviews)
                <tr>
                    <td class="px-4 py-3 whitespace-normal">{{ $reviews->name }}</td>
                    <td class="px-4 py-3 whitespace-normal">{{ $reviews->message }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++) @if($i <=$reviews->rate)
                                <i class="fas fa-star text-yellow-400"></i>
                                @else
                                <i class="far fa-star text-yellow-400"></i>
                                @endif
                                @endfor
                                <span class="ml-2">({{ $reviews->rate }})</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full {{ $reviews->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $reviews->status == 1 ? 'Approved' : 'Not Approved' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex space-x-2">
                            <form action="{{ route('reviews.destroy', $reviews->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition" onclick="return confirm('Are you sure you want to delete this review?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @if($reviews->status == 0)
                            <form action="{{ route('reviews.approved', $reviews->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-500 hover:text-green-700 transition" title="Approve">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                            @endif
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
        $('#reviewsTable').DataTable({
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
                    , title: 'Reviews_Export'
                    , titleAttr: 'Export to Excel'
                }
                , {
                    extend: 'pdfHtml5'
                    , text: '<i class="fas fa-file-pdf mr-1"></i> PDF'
                    , className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                    , title: 'Reviews - Hewitt and Bennet International College'
                    , titleAttr: 'Export to PDF'
                }
                , {
                    extend: 'print'
                    , text: '<i class="fas fa-print mr-1"></i> Print'
                    , className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm'
                    , title: 'Reviews - Hewitt and Bennet International College'
                    , titleAttr: 'Print table'
                }
            ]
            , columnDefs: [{
                    responsivePriority: 1
                    , targets: 0
                }, // Name
                {
                    responsivePriority: 2
                    , targets: -1
                }, // Actions
                {
                    responsivePriority: 3
                    , targets: 1
                }, // Message
                {
                    responsivePriority: 4
                    , targets: 2
                }, // Rating
                {
                    responsivePriority: 5
                    , targets: 3
                } // Status
            ]
            , language: {
                search: "_INPUT_"
                , searchPlaceholder: "Search reviews..."
            , }
        });
    });

</script>
@endsection
