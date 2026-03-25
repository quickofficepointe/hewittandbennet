@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Dashboard - Staff')

@section('content')
<div class="space-y-6">
    <!-- Row for Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Student Registrations by Month -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-700 px-4 py-3">
                <h3 class="text-white font-medium">Student Registrations ({{ now()->format('F Y') }})</h3>
            </div>
            <div class="p-4">
                <h5 class="text-3xl font-bold text-center text-gray-800">
                    {{ $registrationsThisMonth }}
                </h5>
                <p class="text-center text-gray-600 mt-2">Students Registered</p>
            </div>
        </div>

        <!-- News & Events Count -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 px-4 py-3">
                <h3 class="text-white font-medium">News & Events Added</h3>
            </div>
            <div class="p-4">
                <h5 class="text-3xl font-bold text-center text-gray-800">
                    {{ $newsEventsCount }}
                </h5>
                <p class="text-center text-gray-600 mt-2">Total News & Events</p>
            </div>
        </div>

        <!-- Total Registered Users -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-800 px-4 py-3">
                <h3 class="text-white font-medium">Total Registered Users</h3>
            </div>
            <div class="p-4">
                <h5 class="text-3xl font-bold text-center text-gray-800">
                    {{ $totalRegisteredUsers }}
                </h5>
                <p class="text-center text-gray-600 mt-2">Total Users</p>
            </div>
        </div>

        <!-- Receipts Generated -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-900 px-4 py-3">
                <h3 class="text-white font-medium">Receipts Generated</h3>
            </div>
            <div class="p-4">
                <h5 class="text-3xl font-bold text-center text-gray-800">
                    {{ $receiptsGenerated }}
                </h5>
                <p class="text-center text-gray-600 mt-2">Total Receipts</p>
            </div>
        </div>
    </div>

    <!-- Row for Total Online Registrations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Online Registrations Forms Count -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-700 px-4 py-3">
                <h3 class="text-white font-medium">Online Registration Forms</h3>
            </div>
            <div class="p-4">
                <h5 class="text-3xl font-bold text-center text-gray-800">
                    {{ $onlineRegistrationForms }}
                </h5>
                <p class="text-center text-gray-600 mt-2">Total Forms Submitted</p>
            </div>
        </div>

        <!-- Total Online Registrations -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 px-4 py-3">
                <h3 class="text-white font-medium">Total Online Registrations</h3>
            </div>
            <div class="p-4">
                <h5 class="text-3xl font-bold text-center text-gray-800">
                    {{ $totalOnlineRegistrations }}
                </h5>
                <p class="text-center text-gray-600 mt-2">Total Online Registrations</p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-700 px-4 py-3">
            <h3 class="text-white font-medium">Student Registrations Comparison</h3>
        </div>
        <div class="p-4">
            <canvas id="registrationsComparisonChart" class="w-full h-80"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('registrationsComparisonChart').getContext('2d');
        const registrationsComparisonChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($months as $month)
                        "{{ $month }}",
                    @endforeach
                ],
                datasets: [
                    {
                        label: 'Last Month',
                        data: {{ json_encode($registrationsLastMonth) }},
                        borderColor: 'rgba(29, 78, 216, 1)',
                        borderWidth: 2,
                        tension: 0.1,
                        fill: false
                    },
                    {
                        label: 'This Month',
                        data: {{ json_encode($registrationsThisMonth) }},
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.1,
                        fill: false
                    },
                    {
                        label: 'Same Period Last Year',
                        data: {{ json_encode($registrationsLastYear) }},
                        borderColor: 'rgba(147, 197, 253, 1)',
                        borderWidth: 2,
                        tension: 0.1,
                        fill: false
                    },
                    {
                        label: 'This Year',
                        data: {{ json_encode($registrationsThisYear) }},
                        borderColor: 'rgba(30, 64, 175, 1)',
                        borderWidth: 2,
                        tension: 0.1,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Registrations',
                            color: '#374151'
                        },
                        grid: {
                            color: 'rgba(229, 231, 235, 0.5)'
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Months',
                            color: '#374151'
                        },
                        grid: {
                            color: 'rgba(229, 231, 235, 0.5)'
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
