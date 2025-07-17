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
<h1>Edit Unit</h1>

<form action="{{ route('units.update', $unit->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id" id="course_id" class="form-control">
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ $unit->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
            @error('course_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">Unit Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $unit->name) }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="unit_code">Unit Code</label>
            <input type="text" name="unit_code" id="unit_code" class="form-control" value="{{ old('unit_code', $unit->unit_code) }}">
            @error('unit_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="tutor_id">Tutor</label>
            <select name="tutor_id" id="tutor_id" class="form-control">
                @foreach ($tutors as $tutor)
                    <option value="{{ $tutor->id }}" {{ $unit->tutor_id == $tutor->id ? 'selected' : '' }}>
                        {{ $tutor->name }}
                    </option>
                @endforeach
            </select>
            @error('tutor_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    @endsection
