@extends('dashboards.staff.layouts.stafflayout')

@section('content')
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 classy-alert" role="alert" style="z-index: 9999; font-size: small;">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <ul>
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
<div class="container">

    <h1>Edit Student</h1>
    <form method="POST" action="{{ route('students.update', $student_data->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- You need to specify that this is an update request -->

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $student_data->name }}" required>
        </div>
        <div class="form-group">
            <label for="student_no">Student No</label>
            <input type="text" name="student_no" class="form-control" value="{{ $student_data->student_no }}" required>
        </div>

        <!-- Other form fields for editing student data -->

        <div class="form-group">
            <label for="course">Course They Are Taking</label>
            <select class="form-select" name="course" id="course" required>
                <option value="" disabled>Select a course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->name }}" data-fees="{{ $course->registration_fees + $course->school_fees + $course->school_uniform_fee }}" {{ $student_data->course === $course->name ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" class="form-control" value="{{ $student_data->phone_number }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ $student_data->email }}" >
        </div>

        <div class="form-group">
            <label for="id_number">ID Number / Birth Certificate Number</label>
            <input type="text" name="id_number" class="form-control" value="{{ $student_data->id_number }}" >
        </div>
        <div class="form-group">
            <label for="course_fee">Fees for the Course</label>
            <input type="number" name="course_fee" id="course_fee" class="form-control" step="0.01" value="{{ $student_data->course_fee }}"  readonly>
        </div>
        <div class="form-group">
            <label for="passport_photo">Current Passport Photo</label>
            <div>
                @if($student_data->passport_photo)
                    <img src="{{ asset('storage/' . $student_data->passport_photo) }}" alt="Current Passport Photo" class="img-thumbnail" style="max-width: 200px;">
                @else
                    <p>No current passport photo available.</p>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="new_passport_photo">Update Passport Photo (optional)</label>
            <input type="file" name="new_passport_photo" class="form-control-file" accept="image/*">
        </div>
        <!-- Guardian Name -->
<div class="form-group">
    <label for="guardian_name">Guardian Name</label>
    <input type="text" name="guardian_name" class="form-control" value="{{ $student_data->guardian_name }}" required>
</div>

<!-- Guardian Phone Number -->
<div class="form-group">
    <label for="guardian_phone_number">Guardian Phone Number</label>
    <input type="tel" name="guardian_phone_number" class="form-control" value="{{ $student_data->guardian_phone_number }}" required>
</div>

<!-- Guardian Email -->
<div class="form-group">
    <label for="guardian_email">Guardian Email</label>
    <input type="email" name="guardian_email" class="form-control" value="{{ $student_data->guardian_email }}" required>
</div>


        <button type="submit" class="btn btn-primary">Update Student</button>

</div>
@endsection
