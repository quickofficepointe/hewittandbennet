<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('assets/img/hbiclogo.jpeg') }}" type="image/png">
  <title>Hewitt and Bennet International College | Staff Dashboard</title>

  <!-- Google Font: Playfair Display & Source Sans Pro for classic academic feel -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Custom CSS for a cleaner layout and typography -->
  <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- AdminLTE theme -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-blue">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
          <a href="/" class="nav-link text-dark">Home</a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-dark" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="/" class="brand-link text-center">
        <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC Logo" class="brand-image img-circle elevation-3">
        <h4 class="text-white font-weight-bold">{{ Auth::user()->username }}</h4>
      </a>

      <div class="sidebar">
        <nav class="mt-4">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <li class="nav-item">
              <a href="{{ route('staff.dashboard') }}" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('staff.onlineregister') }}" class="nav-link">
                  <i class="nav-icon fas fa-user-plus"></i>
                  <p>Online Registrations</p>
                </a>
              </li>
            <li class="nav-item">
              <a href="{{ route('Paymentreceipt.index') }}" class="nav-link">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>Payments</p>
              </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('gallery.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-credit-card"></i>
                  <p>Gallery</p>
                </a>
              </li>
            <li class="nav-item">
              <a href="{{ route('hewitt_banners.index') }}" class="nav-link">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p>Marketing</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('index.cdpert') }}" class="nav-link">
                <i class="nav-icon fas fa-book-open"></i>
                <p>Courses</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('students.create') }}" class="nav-link">
                <i class="nav-icon fas fa-user-graduate"></i>
                <p>Student Data</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('registrationforms.index') }}" class="nav-link">
                <i class="nav-icon fas fa-pencil-alt"></i>
                <p>Registration Forms</p>
              </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('newsandevent.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-pencil-alt"></i>
                  <p>News and Events</p>
                </a>
              </li>
            <li class="nav-item">
              <a href="{{ route('index.review') }}" class="nav-link">
                <i class="nav-icon fas fa-comments"></i>
                <p>Reviews</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

   <!-- Content Wrapper -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@yield('pageTitle', 'Dashboard')</h1>
                </div>
                <div class="col-sm-6">
                    <!-- Add Breadcrumbs or Navigation links -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <footer class="main-footer text-center">
      <strong>&copy; <span id="current-year"></span> <a href="https://hewittandbenet.edu">Hewett and Benet International College</a>.</strong> All rights reserved.
    </footer>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <!-- Bootstrap Bundle -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#content, #content1').summernote({
          placeholder: '',
          tabsize: 2,
          height: 100
      });
    });
  </script>
  <script>
    // Update current year in footer
    document.getElementById('current-year').textContent = new Date().getFullYear();

    // Initialize DataTable with responsive design, export buttons, etc.
    $(document).ready(function() {
        $('#example1', ).DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(document).ready(function() {
    $('#publishednewsandevent').DataTable({
        responsive: true,  // Enable responsive table for smaller screens
        lengthChange: false,
        autoWidth: false,
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
        dom: '<"top"iB>rt<"bottom"flp><"clear">',  // Position buttons
    }).buttons().container().appendTo('#publishednewsandevent_wrapper .col-md-6:eq(0)');
});
  </script>


</body>
</html>
