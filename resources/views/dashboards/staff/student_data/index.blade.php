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
    <h1>Create Student</h1>
    <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="student_no">Student No</label>
            <input type="text" name="student_no" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="id_number">ID Number / Birth Certificate Number</label>
            <input type="text" name="id_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="guardian_name">Guardian Name</label>
            <input type="text" name="guardian_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="guardian_phone_number">Guardian Phone Number</label>
            <input type="tel" name="guardian_phone_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="guardian_email">Guardian Email</label>
            <input type="email" name="guardian_email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="passport_photo">Passport Photo</label>
            <input type="file" name="passport_photo" class="form-control-file" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="course">Course They Are Taking</label>
            <select class="form-select" name="course" id="course" required>
                <option value="" disabled selected>Select a course</option>
                @foreach($coursese as $course)
                    <option value="{{ $course->name }}" data-fees="{{ $course->registration_fees + $course->school_fees + $course->school_uniform_fee }}">{{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="course_fee">Fees for the Course</label>
            <input type="number" name="course_fee" id="course_fee" class="form-control" step="0.01" required readonly>
        </div>

        <button type="submit" class="btn btn-primary">Create Student</button>
    </form>
</div>
<div class="card">
    <div class="card-header">
      <h3 class="card-title">DataTable with default features</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Student Name </th>
            <th>Student Email</th>
            <th>Student Contact</th>
            <th>ID Number / Birth Certificate Number</th>
            <th>Guardian Name </th>
            <th>Guardian Email</th>
            <th>Passport Photo</th>
            <th>Course They Are Taking</th>
            <th>Fees for the Course</th>
            <th>Fees </th>
        </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->phone_number }}</td>
                <td>{{ $student->id_number }}</td>
                <td>{{ $student->guardian_name }}</td>
                <td>{{ $student->guardian_email }}</td>
                <td>
                    <img src="{{ asset($student->passport_photo) }}" alt="Passport Photo" width="50">
                </td>
                <td>{{ $student->course }}</td>
                <td>{{ $student->course_fee }}</td>

           
                <td><a href="{{ route('students.edit', ['student' => $student->id]) }}" class="btn btn-primary btn-sm">Edit</a></td>

            </tr>
        @endforeach
            </tfoot>
      </table>
      <script>
        $(function () {
          $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
          $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
          });
        });
      </script>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</section>
<!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
<script>
    // Add JavaScript to update course_fee based on the selected course
    document.addEventListener('DOMContentLoaded', function () {
        const courseSelect = document.getElementById('course');
        const courseFeeInput = document.getElementById('course_fee');

        // Listen for changes in the course selection
        courseSelect.addEventListener('change', function () {
            const selectedOption = courseSelect.options[courseSelect.selectedIndex];
            const courseFees = selectedOption.getAttribute('data-fees');

            // Set the course_fee input value and make it readonly
            courseFeeInput.value = courseFees;
            courseFeeInput.readOnly = true;
        });
    });
</script>
@endsection





