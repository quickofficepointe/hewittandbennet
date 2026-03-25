@extends('dashboards.student.layouts.studentlayouts')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header -->
    <div class="bg-blue-600 text-white p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC Logo" class="h-16 w-16 mr-4">
                <div>
                    <h1 class="text-2xl font-bold">Hewitt and Bennet International College</h1>
                    <p class="text-blue-100">Results Slip</p>
                </div>
            </div>
            <div class="text-right">
                <p class="font-semibold">Exam NO: HBICFE</p>
                <p class="text-blue-100">Date: {{ now()->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>

    <!-- Contact Info -->
    <div class="bg-gray-50 p-6 border-b border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Location:</h3>
                <p class="text-gray-600">OUTERING ROAD</p>
                <p class="text-gray-600">P.O BOX 24999-00100</p>
                <p class="text-gray-600">TEL: 0728541323, 0713490768</p>
            </div>
            <div class="text-right">
                <p class="text-gray-600">Email: <a href="mailto:info@hewittbennet.co.ke" class="text-blue-600 hover:underline">info@hewittbennet.co.ke</a></p>
                <p class="text-gray-600">Website: <a href="https://www.hewittbennet.co.ke" class="text-blue-600 hover:underline">www.hewittbennet.co.ke</a></p>
            </div>
        </div>
    </div>

    <!-- Student Info -->
    <div class="p-6 border-b border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <strong class="text-gray-700">Student Name:</strong> {{ auth()->user()->name }}
            </div>
            <div class="text-center">
                <strong class="text-gray-700">Course:</strong> Community Health Assistant Course(CHA)
            </div>
            <div class="text-right">
                <strong class="text-gray-700">Registration Number:</strong> {{ auth()->user()->username }}
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Exam Results</h3>
        <div class="overflow-x-auto">
            <table id="resultsTable" class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Taken</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($myscores as $score)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $score->onlineExam->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $score->score >= 70 ? 'bg-green-100 text-green-800' :
                                   ($score->score >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $score->score }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $score->created_at->format('M j, Y g:i A') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                            No exam results available yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-100 p-4 text-center text-sm text-gray-600">
        <p>© {{ date('Y') }} Hewitt and Bennet International College. All rights reserved.</p>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTables for results
        $('#resultsTable').DataTable({
            responsive: true,
            ordering: true,
            searching: false,
            pageLength: 10,
            order: [[2, 'desc']], // Sort by date descending
            language: {
                lengthMenu: "Show _MENU_ results",
                info: "Showing _START_ to _END_ of _TOTAL_ results",
            }
        });
    });
</script>
@endsection
@endsection
