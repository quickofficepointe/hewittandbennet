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
  <div class="container">
        <h1>Edit Course: {{ $course->name }}</h1>
        <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="department_id">Department:</label>
                <select name="department_id" id="department_id" class="form-control" required>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ $course->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name">Course Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $course->name }}" required>
            </div>
            <div class="form-group">
                <label for="school_fees">School Fees:</label>
                <input type="number" name="school_fees" id="school_fees" class="form-control" step="0.01" value="{{ $course->school_fees }}" required>
            </div>
            <div class="form-group">
                <label for="registration_fees">Registration Fees:</label>
                <input type="number" name="registration_fees" id="registration_fees" class="form-control" step="0.01" value="{{ $course->registration_fees }}" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration:</label>
                <input type="text" name="duration" id="duration" class="form-control" value="{{ $course->duration }}" required>
            </div>
            <div class="form-group">
                <label for="course_description">Course Description:</label>
                <textarea name="course_description" id="course_description" class="form-control" rows="4" required>{{ $course->course_description }}</textarea>
            </div>
             <!-- Display current image -->
        <div class="form-group">
            <label for="current_image">Current Image:</label>
            @if($course->image)
                <img src="{{ asset($course->image) }}" alt="Current Image" style="max-width: 200px;">
            @else
                <p>No image available.</p>
            @endif
        </div>
            <div class="form-group">
                <label for="image">Course Image:</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="school_uniform_fee">School Uniform Fee:</label>
                <input type="number" name="school_uniform_fee" id="school_uniform_fee" class="form-control" step="0.01" value="{{ $course->school_uniform_fee }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Course</button>
        </form>
    </div>


@endsection
