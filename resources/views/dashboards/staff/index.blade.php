@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Dashboard - Staff')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-8 text-white shadow-lg">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->username }}! 👋</h2>
                <p class="text-primary-100">Here's what's happening with your institution today.</p>
            </div>
            <div class="flex space-x-3">
                <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i>{{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 1 -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Student Registrations Card -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="relative p-6">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primary-50 to-blue-50 rounded-full -mt-10 -mr-10 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-user-graduate text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-primary-600">{{ $registrationsThisMonth }}</span>
                    </div>
                    <h3 class="text-gray-700 font-semibold mb-1">Student Registrations</h3>
                    <p class="text-sm text-gray-500">{{ now()->format('F Y') }}</p>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+12% from last month
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- News & Events Card -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="relative p-6">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-50 to-pink-50 rounded-full -mt-10 -mr-10 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-newspaper text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-purple-600">{{ $newsEventsCount }}</span>
                    </div>
                    <h3 class="text-gray-700 font-semibold mb-1">News & Events</h3>
                    <p class="text-sm text-gray-500">Total published content</p>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <a href="{{ route('newsandevent.index') }}" class="text-xs text-primary-600 hover:text-primary-700">
                            Manage <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Registered Users Card -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="relative p-6">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-teal-50 to-green-50 rounded-full -mt-10 -mr-10 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-teal-600">{{ $totalRegisteredUsers }}</span>
                    </div>
                    <h3 class="text-gray-700 font-semibold mb-1">Registered Users</h3>
                    <p class="text-sm text-gray-500">Total platform users</p>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500">Active accounts</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipts Generated Card -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="relative p-6">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-50 to-red-50 rounded-full -mt-10 -mr-10 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-receipt text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-orange-600">{{ $receiptsGenerated }}</span>
                    </div>
                    <h3 class="text-gray-700 font-semibold mb-1">Receipts Generated</h3>
                    <p class="text-sm text-gray-500">Total payment receipts</p>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <a href="{{ route('Paymentreceipt.index') }}" class="text-xs text-primary-600 hover:text-primary-700">
                            View all <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Online Registration Forms Card -->
        <div class="group bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clipboard-list text-white text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <span class="text-4xl font-bold text-primary-700">{{ $onlineRegistrationForms }}</span>
                        <p class="text-sm text-gray-600 mt-1">Total Forms</p>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Online Registration Forms</h3>
                <p class="text-gray-600 text-sm mb-4">Submitted through website registration portal</p>
                <div class="flex items-center justify-between">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full" style="width: {{ min(($onlineRegistrationForms / ($totalOnlineRegistrations ?: 1)) * 100, 100) }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500 ml-3">{{ round(($onlineRegistrationForms / ($totalOnlineRegistrations ?: 1)) * 100) }}%</span>
                </div>
            </div>
        </div>

        <!-- Total Online Registrations Card -->
        <div class="group bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-600 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-globe text-white text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <span class="text-4xl font-bold text-green-700">{{ $totalOnlineRegistrations }}</span>
                        <p class="text-sm text-gray-600 mt-1">Total Registrations</p>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Online Registrations</h3>
                <p class="text-gray-600 text-sm mb-4">All-time registration submissions</p>
                <div class="flex items-center justify-between">
                    <div class="flex space-x-1">
                        <span class="inline-flex items-center px-2 py-1 rounded-lg bg-green-100 text-green-700 text-xs">
                            <i class="fas fa-check-circle mr-1"></i> Active
                        </span>
                        <span class="inline-flex items-center px-2 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs">
                            <i class="fas fa-chart-line mr-1"></i> +23% growth
                        </span>
                    </div>
                    <a href="{{ route('staff.onlineregister') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        View all <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Student Registrations Overview</h3>
                    <p class="text-sm text-gray-500 mt-1">Monthly comparison across different periods</p>
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition" id="showAllData">All Data</button>
                </div>
            </div>
        </div>
        <div class="p-6">
            <canvas id="registrationsComparisonChart" class="w-full h-96"></canvas>
        </div>
    </div>

    <!-- Recent Activity Section (Optional) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Registrations -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">Recent Registrations</h3>
                <p class="text-sm text-gray-500">Latest student enrollments</p>
            </div>
            <div class="divide-y divide-gray-100">
                @if(isset($recentRegistrations) && count($recentRegistrations) > 0)
                    @foreach($recentRegistrations->take(5) as $registration)
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-primary-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $registration->name ?? 'Student' }}</p>
                                    <p class="text-xs text-gray-500">{{ $registration->created_at->diffForHumans() ?? 'Recently' }}</p>
                                </div>
                            </div>
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">New</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2 opacity-50"></i>
                        <p>No recent registrations</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800">Quick Actions</h3>
                <p class="text-sm text-gray-500">Frequently used tools</p>
            </div>
            <div class="p-6 grid grid-cols-2 gap-4">
                <a href="{{ route('students.create') }}" class="group p-4 bg-gradient-to-br from-primary-50 to-blue-50 rounded-xl hover:shadow-md transition-all text-center">
                    <div class="w-12 h-12 bg-primary-600 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i class="fas fa-user-plus text-white text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Add Student</p>
                </a>
                <a href="{{ route('newsandevent.index') }}" class="group p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl hover:shadow-md transition-all text-center">
                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i class="fas fa-calendar-plus text-white text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Create Event</p>
                </a>
                <a href="{{ route('gallery.index') }}" class="group p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl hover:shadow-md transition-all text-center">
                    <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i class="fas fa-images text-white text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Add to Gallery</p>
                </a>
                <a href="{{ route('Paymentreceipt.index') }}" class="group p-4 bg-gradient-to-br from-orange-50 to-red-50 rounded-xl hover:shadow-md transition-all text-center">
                    <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i class="fas fa-receipt text-white text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Generate Receipt</p>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'This Month',
                        data: {{ json_encode($registrationsThisMonth) }},
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Same Period Last Year',
                        data: {{ json_encode($registrationsLastYear) }},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'This Year',
                        data: {{ json_encode($registrationsThisYear) }},
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#e5e7eb',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw} registrations`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Registrations',
                            color: '#6b7280',
                            font: {
                                weight: '500',
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(229, 231, 235, 0.5)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6b7280',
                            stepSize: 1,
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Months',
                            color: '#6b7280',
                            font: {
                                weight: '500',
                                size: 12
                            }
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    }
                },
                elements: {
                    line: {
                        borderJoin: 'round'
                    }
                }
            }
        });

        // Optional: Add animation on page load
        const cards = document.querySelectorAll('.group');
        cards.forEach((card, index) => {
            card.style.animation = `slideUp 0.4s ease-out ${index * 0.05}s forwards`;
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
        });

        // Add slideUp animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush

@push('styles')
<style>
    /* Additional animations and hover effects */
    .group {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .group:hover {
        transform: translateY(-4px);
    }

    /* Chart container responsive */
    canvas {
        max-height: 400px;
    }

    /* Quick action button hover effects */
    .quick-action-btn {
        transition: all 0.2s ease;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
    }

    /* Gradient text for stats */
    .stat-number {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endpush
@endsection
