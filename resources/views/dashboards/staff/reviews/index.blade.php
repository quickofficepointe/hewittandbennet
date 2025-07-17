
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
<!-- Course Datatable -->
<h2>REVIEWS</h2>
<table id="courseTable" class="table table-bordered">
    <thead>
        <tr>

            <th>NAME</th>
            <th>MESSAGE</th>
            <th>RATING</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        @foreach($review as $reviews)
            <tr>
                <td>{{ $reviews->name }}</td>
                <td>{{ $reviews->message }}</td>
                <td>{{ $reviews->rate }}</td>
                <td>{{ $reviews->status }}</td>
                <td>
                    <a href="" class="btn btn-sm btn-primary">Edit</a>
                    <form action="" method="POST" style="display: inline-block;">
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

    <script>
        $(document).ready(function() {
            $('#departmentTable').DataTable();
            $('#courseTable').DataTable();
        });
    </script>
@endsection
