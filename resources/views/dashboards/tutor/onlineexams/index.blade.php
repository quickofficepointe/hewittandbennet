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
<div class="container">
    <h2>Create Online Exam</h2>
    <form method="POST" action="{{ route('online_exams.store') }}">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="duration">Duration (minutes)</label>
            <input type="number" class="form-control" id="duration" name="duration">
        </div>

        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="datetime-local" class="form-control" id="start_time" name="start_time">
        </div>

        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="datetime-local" class="form-control" id="end_time" name="end_time">
        </div>

        <div class="form-group">
            <label hidden for="user_id">Tutor/User ID</label>
            <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ auth()->id() }}" required>
        </div>


        <div class="form-group">
            <label for="course_id">Course</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <option value="" disabled selected>Select a course</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="hidden">Hidden</option>
            </select>
        </div>

        <!-- Add more form fields for other exam attributes -->

        <button type="submit" class="btn btn-primary">Create Exam</button>
    </form>
</div>

<div class="container">
    <h2>Add Question</h2>
    <form method="POST" action="{{ route('questions.store') }}">
        @csrf

        <div class="form-group">
            <label for="online_exam_id">Online Exam</label>
            <select class="form-control" id="online_exam_id" name="online_exams_id" required>
                @foreach ($onlineExams as $onlineExam)
                    <option value="{{ $onlineExam->id }}">{{ $onlineExam->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="text">Question Text</label>
            <textarea class="form-control" id="text" name="text" rows="4" required></textarea>
        </div>

        <!-- Add more form fields for question attributes as needed -->

        <button type="submit" class="btn btn-primary">Add Question</button>
    </form>
</div>






@endsection
