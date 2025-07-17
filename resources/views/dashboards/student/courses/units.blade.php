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
    <div class="container">
        <h1>Units for {{ $selectedCourse->name }}</h1>
        <ul class="list-group">
            @foreach ($units as $unit)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $unit->name }}
                    @if ($unit->students->contains(Auth::user()->id))
                        <span class="badge bg-success">Enrolled</span>
                    @else
                        <form action="{{ route('student.enroll', $unit->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">Enroll Me</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection
