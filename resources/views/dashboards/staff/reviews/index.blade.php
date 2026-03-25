@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Reviews Management')

@section('content')
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 classy-alert" role="alert" style="z-index: 9999;">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.classy-alert').remove();
    }, 3000);
</script>
@endif

@if(session('success'))
<div class="position-fixed top-0 start-50 translate-middle-x mt-3 classy-alert" style="z-index: 9999;">
    <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.classy-alert').remove();
    }, 3000);
</script>
@endif

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-primary">Reviews</h2>
    </div>

    <div class="overflow-x-auto">
        <table id="reviewsTable" class="w-full table-auto border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($review as $reviews)
                <tr>
                    <td class="px-4 py-3 whitespace-normal">{{ $reviews->name }}</td>
                    <td class="px-4 py-3 whitespace-normal">{{ $reviews->message }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $reviews->rate)
                                    <i class="fas fa-star text-yellow-400"></i>
                                @else
                                    <i class="far fa-star text-yellow-400"></i>
                                @endif
                            @endfor
                            <span class="ml-2">({{ $reviews->rate }})</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full {{ $reviews->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($reviews->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex space-x-2">
                            <a href="{{ route('reviews.edit', $reviews->id) }}"
                               class="text-primary hover:text-primary-dark transition"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('reviews.destroy', $reviews->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-500 hover:text-red-700 transition"
                                        onclick="return confirm('Are you sure you want to delete this review?')"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @if($reviews->status !== 'approved')
                            <form action="{{ route('reviews.approve', $reviews->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-green-500 hover:text-green-700 transition"
                                        title="Approve">
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
                    title: 'Reviews_Export',
                    titleAttr: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Reviews - Hewitt and Bennet International College',
                    titleAttr: 'Export to PDF'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Print',
                    className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Reviews - Hewitt and Bennet International College',
                    titleAttr: 'Print table'
                }
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 0 }, // Name
                { responsivePriority: 2, targets: -1 }, // Actions
                { responsivePriority: 3, targets: 1 }, // Message
                { responsivePriority: 4, targets: 2 }, // Rating
                { responsivePriority: 5, targets: 3 }  // Status
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search reviews...",
            }
        });
    });
</script>
@endsection
