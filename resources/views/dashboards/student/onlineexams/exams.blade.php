@extends('dashboards.student.layouts.studentlayouts')

@section('content')
<div x-data="{
    timeRemaining: {{ $totalTime * 60 }},
    init() {
        setInterval(() => {
            if (this.timeRemaining > 0) {
                this.timeRemaining--;
            } else {
                document.querySelector('form').submit();
            }
        }, 1000);
    },
    get formattedTime() {
        const hours = Math.floor(this.timeRemaining / 3600);
        const minutes = Math.floor((this.timeRemaining % 3600) / 60);
        const seconds = this.timeRemaining % 60;
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
}">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $exam->title }}</h2>
                <p class="text-gray-600">Logged in as: {{ auth()->user()->name }} ({{ auth()->user()->username }})</p>
            </div>
            <div class="bg-red-100 border border-red-200 rounded-lg px-4 py-2">
                <span class="text-red-800 font-semibold">Time Remaining: </span>
                <span x-text="formattedTime" class="text-red-800 font-mono text-lg"></span>
            </div>
        </div>
    </div>

    <!-- Exam Form -->
    <form method="POST" action="{{ route('exams.submit') }}" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        @foreach ($questions as $index => $question)
        <div class="mb-8 p-6 border border-gray-200 rounded-lg">
            <input type="hidden" name="question_id[]" value="{{ $question->id }}">

            <div class="flex items-start mb-4">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold mr-3">
                    Q{{ $questionNumberStart + $index }}
                </span>
                <h3 class="text-lg font-semibold text-gray-800">{{ $question->text }}</h3>
            </div>

            <div class="ml-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Your Answer:</label>
                <textarea
                    name="answers[{{ $question->id }}]"
                    rows="4"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Type your answer here..."></textarea>
            </div>
        </div>
        @endforeach

        <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
            <div class="text-sm text-gray-500">
                {{ count($questions) }} question(s) total
            </div>
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-semibold transition duration-200">
                Submit Exam
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    // Security measures
    document.addEventListener('DOMContentLoaded', function() {
        // Disable right-click
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            showMessage('Right-click is disabled during the exam.');
        });

        // Disable keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Disable Print Screen, F12, Ctrl+Shift+I, etc.
            if (e.key === 'PrintScreen' || e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && e.key === 'I') ||
                (e.ctrlKey && e.key === 'u') ||
                (e.ctrlKey && e.key === 's')) {
                e.preventDefault();
                showMessage('This action is not allowed during the exam.');
            }
        });

        function showMessage(message) {
            // Create toast message
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg z-50';
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Auto-save functionality (optional)
        setInterval(() => {
            const formData = new FormData(document.querySelector('form'));
            // Save to localStorage or send to server
            localStorage.setItem('exam_autosave', JSON.stringify(Array.from(formData.entries())));
        }, 30000); // Auto-save every 30 seconds
    });
</script>
@endsection
@endsection
