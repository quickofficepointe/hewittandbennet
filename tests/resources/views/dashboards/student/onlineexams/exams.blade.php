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
    <div class="logged-in-user">
        Logged in as: {{ auth()->user()->name }}
    </div>
    <div class="logged-in-user">
        Logged in as: {{ auth()->user()->username }}
    </div>
    <div id="timer" class="float-left"></div>
    <h2>Online Exam</h2>
    <form method="POST" action="{{ route('exams.submit') }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        @foreach ($questions as $question)
        <div class="card mt-3">
            <div class="card-body">
                <input type="hidden" name="question_id[]" value="{{ $question->id }}">

                <h5 class="card-title">Question {{ $questionNumberStart + $loop->index }}</h5>
                <p class="card-text">{{ $question->text }}</p>
                <div class="form-group">
                    <label for="answer{{ $question->id }}">Your Answer:</label>
                    <textarea class="form-control" id="answer{{ $question->id }}" name="answers[{{ $question->id }}]" rows="3" required></textarea>
                </div>
            </div>
        </div>
        @endforeach
        <!-- Timer for time remaining -->
        <div id="timer-countdown"></div>
        <button type="submit" class="btn btn-primary mt-3">Submit Exam</button>
    </form>
</div>

<script>
    // Countdown timer
    const timerElement = document.getElementById('timer-countdown');
    const examEndTime = new Date(); // Set the exam end time here
    examEndTime.setMinutes(examEndTime.getMinutes() + 120); // Add 2 hours for the exam duration

    function updateTimer() {
        const currentTime = new Date();
        const timeRemaining = new Date(examEndTime - currentTime);

        const hours = timeRemaining.getUTCHours();
        const minutes = timeRemaining.getUTCMinutes();
        const seconds = timeRemaining.getUTCSeconds();

        const timerText = `Time Remaining: ${hours}h ${minutes}m ${seconds}s`;

        if (timeRemaining <= 0) {
            timerText = 'Time Expired';
            // Automatically submit the exam when time expires
            document.querySelector('form').submit();
        }

        timerElement.textContent = timerText;
    }

    // Update the timer every second
    setInterval(updateTimer, 1000);

</script>
<script>
    // Disable Print Screen key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'PrintScreen') {
            e.preventDefault();
            showMessage('Copying is not allowed on this page.');
        }
    });

    // Disable context menu on the document
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        showMessage('Right-click context menu is disabled on this page.');
    });

    // Listen for any attempts to copy content using Ctrl+C (Windows) or Command+C (Mac)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'c') {
            e.preventDefault();
            showMessage('Copying is not allowed on this page.');
        }
    });

    // Disable right-click context menu
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        showMessage('Right-click context menu is disabled on this page.');
    });

    // Disable keyboard shortcuts for taking screenshots
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.key === 'c' || e.key === 'u' || e.key === 'i' || e.key === 'j' || e.key === 's')) {
            e.preventDefault();
            showMessage('Keyboard shortcuts for taking screenshots are disabled on this page.');
        }
    });

    // Function to show a message to the user
    function showMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.className = 'alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-3';
        messageElement.style.zIndex = '9999';
        messageElement.style.fontSize = 'small';
        messageElement.innerText = message;

        const closeButton = document.createElement('button');
        closeButton.className = 'btn-close';
        closeButton.setAttribute('data-bs-dismiss', 'alert');
        closeButton.setAttribute('aria-label', 'Close');
        messageElement.appendChild(closeButton);

        document.body.appendChild(messageElement);

        setTimeout(function() {
            messageElement.remove();
        }, 3000);
    }
</script>

@endsection
