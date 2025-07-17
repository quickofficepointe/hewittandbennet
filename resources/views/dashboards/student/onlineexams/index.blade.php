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
    <h2>Available Exams</h2>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Duration (minutes)</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($exams as $exam)
            <tr>
                <td>{{ $exam->title }}</td>
                <td>{{ $exam->description }}</td>
                <td>{{ $exam->duration }}</td>
                <td>{{ $exam->start_time }}</td>
                <td>{{ $exam->end_time }}</td>
                <td>
                    @if (now() >= $exam->start_time && now() <= $exam->end_time)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#examInstructionsModal">
                        Start
                    </button>
                    @else
                        <!-- Display a message with the date and time when the exam becomes available -->
                        <span class="text-muted">
                            Available from {{ $exam->start_time->format('l, F j, Y \a\t h:i A') }}
                            to {{ $exam->end_time->format('l, F j, Y \a\t h:i A') }}
                        </span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Button to trigger the modal -->


<!-- The modal -->
<!-- The modal -->

<!-- The modal -->
<!-- The modal -->
<div class="modal fade" id="examInstructionsModal" tabindex="-1" role="dialog" aria-labelledby="examInstructionsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="examInstructionsModalLabel">Exam Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('exams.store') }}">
                @csrf
                 <!-- Hidden input fields for user_id and exam_id, populated using Blade -->
                 <input type="hidden" id="user_id_input" name="user_id" value="{{ auth()->user()->id }}">
                 <input type="hidden" id="exam_id_input" name="online_exam_id" value="{{ $exam->id }}">
                <div class="modal-body">
                    <!-- Add your exam instructions here -->
                    <p>Read the instructions carefully before starting the exam.</p>
                </div>
                <div class="modal-footer">
                    <!-- "Start Exam" button that submits the form -->
                    <button type="submit" class="btn btn-primary" onclick="startExam({{ $exam->id }})">Start Exam</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript function to handle the "Start Exam" action
    function startExam(examId) {
        // Disable right-click on the page
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // Disable keyboard shortcuts for taking screenshots
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'c' || e.key === 'u' || e.key === 'i' || e.key === 'j' || e.key === 's')) {
                e.preventDefault();
            }
        });

        // Fetch the logged-in user's ID from the server (you may need to make an AJAX request)
        var userId = "{{ auth()->user()->id }}";

        // Populate the hidden input fields with user and exam IDs
        document.getElementById('user_id_input').value = userId;
        document.getElementById('exam_id_input').value = examId;

        // Show the modal
        $('#examInstructionsModal').modal('show');
    }
</script>



@endsection
