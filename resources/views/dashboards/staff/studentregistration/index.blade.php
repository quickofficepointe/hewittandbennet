@extends('dashboards.staff.layouts.stafflayout')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Registered Users</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <!-- Responsive Table Wrapper -->
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Student Email</th>
                    <th>Location</th>
                    <th>Phone Number</th>
                    <th>Course</th>
                    <th>Application Date</th>
                    <th>Start Month</th>
                    <th>Start Year</th>
                    <th>Mode Of Learning</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($courseapplications as $courseapplications)
                    <tr>
                        <td>{{ $courseapplications->name }}</td>
                        <td>{{ $courseapplications->email }}</td>
                        <td>{{$courseapplications->location }}</td>
                        <td>{{ $courseapplications->phoneNumber }}</td>
                        <td>{{ $courseapplications->course }}</td>
                        <td>{{ \Carbon\Carbon::parse($courseapplications->timestamp)->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $courseapplications->startMonth }}</td>
                        <td>{{ $courseapplications->startYear }}</td>
                        <td>{{ $courseapplications->modeOfLearning }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

@endsection
