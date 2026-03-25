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

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Questions</th>
                        <th>Answers</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($studentResponses as $studentResponse)
                        <tr>
                            <td>{{ $studentResponse->user->name }}</td>
                            <td>
                                @if ($studentResponse->question)
                                    {{ $studentResponse->question->text }}<br>
                                @endif
                            </td>
                            <td>
                                {{ $studentResponse->answers }}<br>
                            </td>
                            <td>
                                <!-- Add action buttons here (e.g., View Details, Edit, Delete) -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

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

</section>
@endsection
