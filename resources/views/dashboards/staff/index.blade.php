@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Dashboard - Staff')

@section('content')

<div class="container-fluid">
    <!-- Row for Summary Cards -->
    <div class="row">
        <!-- Student Registrations by Month -->
        <div class="col-lg-3 col-6">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Student Registrations ({{ now()->format('F Y') }})</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-center">
                        {{ $registrationsThisMonth }} <!-- Replace with dynamic count -->
                    </h5>
                    <p class="text-center">Students Registered</p>
                </div>
            </div>
        </div>

        <!-- News & Events Count -->
        <div class="col-lg-3 col-6">
            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title">News & Events Added</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-center">
                        {{ $newsEventsCount }} <!-- Replace with dynamic count -->
                    </h5>
                    <p class="text-center">Total News & Events</p>
                </div>
            </div>
        </div>

        <!-- Total Registered Users -->
        <div class="col-lg-3 col-6">
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title">Total Registered Users</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-center">
                        {{ $totalRegisteredUsers }} <!-- Replace with dynamic count -->
                    </h5>
                    <p class="text-center">Total Users</p>
                </div>
            </div>
        </div>

        <!-- Receipts Generated -->
        <div class="col-lg-3 col-6">
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title">Receipts Generated</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-center">
                        {{ $receiptsGenerated }} <!-- Replace with dynamic count -->
                    </h5>
                    <p class="text-center">Total Receipts</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Row for Total Online Registrations -->
    <div class="row">
        <!-- Online Registrations Forms Count -->
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Online Registration Forms</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-center">
                        {{ $onlineRegistrationForms }} <!-- Replace with dynamic count -->
                    </h5>
                    <p class="text-center">Total Forms Submitted</p>
                </div>
            </div>
        </div>

        <!-- Total Online Registrations -->
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h3 class="card-title">Total Online Registrations</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-center">
                        {{ $totalOnlineRegistrations }} <!-- Replace with dynamic count -->
                    </h5>
                    <p class="text-center">Total Online Registrations</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Student Registrations Comparison</h3>
                </div>
                <div class="card-body">
                    <canvas id="registrationsComparisonChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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
                    data: {{ json_encode($registrationsLastMonth) }}, // Replace with data for last month
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'This Month',
                    data: {{ json_encode($registrationsThisMonth) }}, // Replace with data for this month
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Same Period Last Year',
                    data: {{ json_encode($registrationsLastYear) }}, // Replace with data for the same period last year
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'This Year',
                    data: {{ json_encode($registrationsThisYear) }}, // Replace with data for this year
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Registrations'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Months'
                    }
                }
            }
        }
    });
</script>
@endsection
