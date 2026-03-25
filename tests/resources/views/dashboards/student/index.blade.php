
@extends('dashboards.student.layouts.studentlayouts')

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
              <!-- /.card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Student Courses</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>NAME</th>
                      <th>Email </th>
                      <th>Location</th>
                      <th>Phone Number</th>
                      <th>course </th>
                      <th>start Month</th>
                      <th>start Year</th>
                      <th>status</th>
                      <th>Mode Of Learning</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                        <tr>
                            <td>{{ $registration->name }}</td>
                            <td>{{ $registration->email }}</td>
                            <td>{{ $registration->location }}</td>
                            <td>{{ $registration->phoneNumber }}</td>
                            <td>{{ $registration->course }}</td>
                            <td>{{ $registration->startMonth }}</td>
                            <td>{{ $registration->startYear }}</td>
                            <td>{{ $registration->status }}</td>
                            <td>{{ $registration->modeOfLearning }}</td>
                        </tr>
                        @endforeach
                    </tbody>
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

@endsection

