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


<form method="post" action="{{ route('exams.scores') }}">

    @csrf
    <label for="student_exam_id">Select Student Exam:</label>
    <select name="online_exam_id" id="student_exam_id">
        <!-- Loop through student exams to populate the dropdown -->
        @foreach($studentExams as $studentExam)
            <option value="{{ $studentExam->id }}">{{ $studentExam->title }}</option>
        @endforeach
    </select>

    <label for="student_id">Select Student:</label>
    <select name="student_id" id="student_id">
        <!-- Loop through students to populate the dropdown -->
        @foreach($students as $student)
            <option value="{{ $student->id }}">{{ $student->name }}</option>
        @endforeach
    </select>
    <input type="hidden" name="tutor_id" value="{{ Auth::user()->id }}">

    <label for="score">Score:</label>
    <input type="number" name="score" id="score" min="0" max="100">

    <button type="submit">Submit Score</button>
</form>
@endsection
