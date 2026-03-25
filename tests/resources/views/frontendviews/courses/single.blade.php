@extends('layouts.app')

@section('title', $course->name)

@section('content')
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-blue-900">{{ $course->name }}</h1>
            <p class="text-gray-600 mt-2">{{ $course->duration }}</p>
        </div>

        <div class="grid md:grid-cols-2 gap-10 items-start">
            <div>
                <img src="{{ asset('storage/' . $course->image) }}" class="w-full rounded-xl shadow-md" alt="{{ $course->name }}">
            </div>
            <div>
                <h2 class="text-2xl font-semibold text-blue-800 mb-4">Course Description</h2>
                <p class="text-gray-700 mb-4">{{ $course->course_description }}</p>

                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-xl font-bold text-blue-900 mb-2">Fees Structure</h3>
                    <p><strong>Registration Fees:</strong> KES {{ number_format($course->registration_fees) }}</p>
                    <p><strong>School Fees:</strong> KES {{ number_format($course->school_fees) }}</p>
                    <p><strong>Uniform Fee:</strong> KES {{ number_format($course->school_uniform_fee) }}</p>
                </div>

                <a href="#enroll-modal" class="mt-6 inline-block bg-blue-700 text-white px-6 py-3 rounded hover:bg-blue-800 font-semibold" data-course="{{ $course->id }}">Apply Now</a>
            </div>
        </div>

        <!-- Apply Now Modal (Single Step) -->
        <div id="enroll-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-auto overflow-y-auto max-h-[90vh] relative">
                <!-- Close Button -->
                <button id="modal-close" class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>

                <form id="enrollment-form" class="p-8 space-y-6" action="{{ route('courseregistration.store') }}" method="POST">
                    @csrf
                    <h2 class="text-2xl font-bold text-blue-900 mb-6">Course Application Form</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4 border-b pb-2">Personal Information</h3>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phoneNumber" id="phoneNumber" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <!-- Course Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4 border-b pb-2">Course Information</h3>
                        </div>

                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700">Select Course</label>
                            <select name="course" id="course_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Select Course --</option>
                                @foreach($coursese as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="campus_id" class="block text-sm font-medium text-gray-700">Select Campus</label>
                            <select name="campus_id" id="campus_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Select Campus --</option>
                                @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="startMonth" class="block text-sm font-medium text-gray-700">Start Month</label>
                            <select name="startMonth" id="startMonth" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Select Month --</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>

                        <div>
                            <label for="startYear" class="block text-sm font-medium text-gray-700">Start Year</label>
                            <select name="startYear" id="startYear" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Select Year --</option>
                                @for($year = date('Y'); $year <= date('Y') + 5; $year++) <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="modeOfLearning" class="block text-sm font-medium text-gray-700">Mode of Learning</label>
                            <select name="modeOfLearning" id="modeOfLearning" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Select Mode --</option>
                                <option value="On-Campus">On-Campus</option>
                                <option value="Online">Online</option>
                                <option value="Hybrid">Hybrid</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="button" id="cancel-btn" class="mr-4 bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition">Cancel</button>
                        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
<script>
    const enrollButtons = document.querySelectorAll('a[href="#enroll-modal"]');
    const enrollModal = document.getElementById('enroll-modal');
    const modalCloseBtn = document.getElementById('modal-close');
    const enrollmentForm = document.getElementById('enrollment-form');
    const cancelBtn = document.getElementById('cancel-btn');

    enrollButtons.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            enrollModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    });

    modalCloseBtn.addEventListener('click', closeEnrollModal);
    cancelBtn.addEventListener('click', closeEnrollModal);
    enrollModal.addEventListener('click', e => {
        if (e.target === enrollModal) closeEnrollModal();
    });

    function closeEnrollModal() {
        enrollModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        enrollmentForm.reset();
    }

    enrollmentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Success!'
            , text: 'Your application has been submitted successfully.'
            , icon: 'success'
            , confirmButtonText: 'OK'
            , customClass: {
                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded'
            }
            , buttonsStyling: false
        }).then(() => {
            // Submit the form programmatically
            this.submit();
            closeEnrollModal();
        });
    });

</script>

@endsection
