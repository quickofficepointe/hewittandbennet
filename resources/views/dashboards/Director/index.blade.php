
@extends('dashboards.Director.layouts.directorlayout')
@section('content')

    <!-- Main content -->
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box for staff -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $staffCount }}</h3>
                        <p>Number of Staff</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i> <!-- Descriptive icon for staff -->
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-6">
                <!-- small box for students -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $studentCount }}</h3>
                        <p>Number of Students</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-graduation-cap"></i> <!-- Descriptive icon for students -->
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-6">
                <!-- small box for tutors -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $tutorCount }}</h3>
                        <p>Number of Tutors</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chalkboard-teacher"></i> <!-- Descriptive icon for tutors -->
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-6">
                <!-- small box for registered students -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $registeredStudentCount }}</h3>
                        <p>Number of Registered Students</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i> <!-- Descriptive icon for registered students -->
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div>



              <!-- /.card -->
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
                        <th>location</th>
                        <th>phone Number </th>
                        <th>course</th>
                        <th>Start Month</th>
                        <th>start Year</th>
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
                          <td> {{ $courseapplications->course }}</td>
                          <td> {{ $courseapplications->startMonth }}</td>
                          <td> {{ $courseapplications->startYear }}</td>
                          <td> {{ $courseapplications->modeOfLearning }}</td>



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

@endsection

