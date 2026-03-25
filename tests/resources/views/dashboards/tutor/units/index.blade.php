
@extends('dashboards.tutor.layouts.tutorlayouts')

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

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#unitModal">
    Create Unit
</button>
    <!-- Main content -->

              <!-- /.card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Units Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Unit Code</th>
                                <th>Tutor</th>
                                <th>Enrollment Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $unit)
                            <tr>
                                <td>{{ $unit->name }}</td>
                                <td>{{ $unit->unit_code }}</td>
                                <td>{{ $unit->tutor->name }}</td>
                                <td>{{ $unit->enroll_count }}</td>
                                <td>
                                    <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Course Units</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


    <form action="{{ route('unit.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id" id="course_id" class="form-control">
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
            @error('course_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">Unit Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="unit_code">Unit Code</label>
            <input type="text" name="unit_code" id="unit_code" class="form-control" value="{{ old('unit_code') }}">
            @error('unit_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="tutor_id">Tutor</label>
            <select name="tutor_id" id="tutor_id" class="form-control">
                @foreach ($tutors as $tutor)
                    <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                @endforeach
            </select>
            @error('tutor_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>


            </div>
        </div>
    </div>
</div>

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

@endsection

