@extends('dashboards.student.layouts.studentlayouts')

@section('content')
<!-- Flash Messages -->
@if($errors->any())
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50">
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <button @click="show = false" class="absolute top-0 right-0 p-2">
            <i class="fas fa-times"></i>
        </button>
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50">
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Available Exams</h2>

    <div class="overflow-x-auto">
        <table id="examsTable" class="w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($exams as $exam)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $exam->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $exam->description }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $exam->duration }} minutes</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $exam->start_time->format('M j, Y g:i A') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $exam->end_time->format('M j, Y g:i A') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if (now() >= $exam->start_time && now() <= $exam->end_time)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @elseif(now() < $exam->start_time)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Upcoming</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if (now() >= $exam->start_time && now() <= $exam->end_time)
                        <button @click="openModal('examModal{{ $exam->id }}')"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                            Start Exam
                        </button>
                        @else
                        <span class="text-gray-400 text-sm">
                            Available from {{ $exam->start_time->format('M j, Y g:i A') }}
                        </span>
                        @endif
                    </td>
                </tr>

                <!-- Modal for each exam -->
                <div x-data="{ open: false }" x-show="open" x-cloak
                     class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
                     x-on:keydown.escape="open = false">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Exam Instructions - {{ $exam->title }}</h3>
                            <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('exams.store') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="online_exam_id" value="{{ $exam->id }}">

                            <div class="px-6 py-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                    <h4 class="font-semibold text-blue-800 mb-2">Important Instructions</h4>
                                    <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                                        <li>Ensure you have a stable internet connection</li>
                                        <li>Do not refresh the page during the exam</li>
                                        <li>All answers are final once submitted</li>
                                        <li>Time limit: {{ $exam->duration }} minutes</li>
                                    </ul>
                                </div>
                                <p class="text-gray-600 mb-4">Are you ready to start the exam?</p>
                            </div>

                            <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end space-x-3">
                                <button type="button" @click="open = false"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition duration-200">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition duration-200">
                                    Start Exam
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                        No exams available at this time.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTables
        $('#examsTable').DataTable({
            responsive: true,
            ordering: true,
            searching: true,
            pageLength: 10,
            language: {
                search: "Search exams:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ exams",
                infoEmpty: "Showing 0 to 0 of 0 exams",
                infoFiltered: "(filtered from _MAX_ total exams)"
            }
        });

        // Modal function
        window.openModal = function(modalId) {
            const modal = document.querySelector(`[x-data][x-show]`);
            if (modal) {
                modal.__x.$data.open = true;
            }
        };
    });
</script>
@endsection
@endsection
