
@extends('dashboards.staff.layouts.stafflayout')

@section('content')
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" role="alert" style="z-index: 9999; font-size: small;">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.alert').remove();
    }, 3000);
</script>
@endif



@if(session('success'))
<div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
<div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
</div>
</div>
<script>
setTimeout(function() {
    document.querySelector('.alert').remove();
}, 3000);
</script>
@endif
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#departmentModal">
    Create Department
</button>
<div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Department Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Department</button>
                </form>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#courseModal">
    Create Course
</button>
<div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="department_id">Department:</label>
                        <select class="form-control" id="department_id" name="department_id" required>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Course Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="school_fees">School Fees:</label>
                        <input type="number" class="form-control" id="school_fees" name="school_fees" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="school_uniform_fee">School Uniform Fee:</label>
                        <input type="number" class="form-control" id="school_uniform_fee" name="school_uniform_fee" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="registration_fees">Registration Fees:</label>
                        <input type="number" class="form-control" id="registration_fees" name="registration_fees" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration:</label>
                        <input type="text" class="form-control" id="duration" name="duration" required>
                    </div>
                    <div class="form-group">
                        <label for="course_description">Course Description:</label>
                        <textarea class="form-control" id="course_description" name="course_description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Course Image:</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>

                    <button type="submit" class="btn btn-primary">Create Course</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Course Datatable -->
<h2>Courses</h2>
<table id="courseTable" class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Department</th>
            <th>Name</th>
            <th>School Fees</th>
            <th>Registration Fees</th>
            <th>Duration</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->department->name }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->school_fees }}</td>
                <td>{{ $course->registration_fees }}</td>
                <td>{{ $course->duration }}</td>
                <td><img src="{{ asset($course->image) }}" alt="{{ $course->name }}" width="100"></td>
                <td>
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>

                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="container">
    <!-- Department Datatable -->
    <h2>Departments</h2>
    <table id="departmentTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->id }}</td>
                    <td>{{ $department->name }}</td>
                    <td>
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>

                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#departmentTable').DataTable();
            $('#courseTable').DataTable();
        });
    </script>
@endsection
