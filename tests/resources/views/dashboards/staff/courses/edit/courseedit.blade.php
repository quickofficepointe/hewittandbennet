@extends('dashboards.staff.layouts.stafflayout')

@section('content')
{{-- Alerts --}}
@if($errors->any())
<div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg min-w-[320px]">
    <ul class="list-disc pl-5 mb-0 text-sm">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-xl">&times;</button>
</div>
<script>
    setTimeout(function() {
        let alert = document.querySelector('.bg-red-100');
        if (alert) alert.remove();
    }, 3000);

</script>
@endif

@if(session('success'))
<div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded-lg shadow-lg min-w-[320px] flex items-center gap-2">
    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
    </svg>
    <span>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800 text-xl">&times;</button>
</div>
<script>
    setTimeout(function() {
        let alert = document.querySelector('.bg-green-100');
        if (alert) alert.remove();
    }, 3000);

</script>
@endif

<div class="max-w-3xl mx-auto my-10">
    <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-8 py-6">
            <h2 class="text-2xl md:text-3xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-edit"></i>
                Edit Course: <span class="truncate">{{ $course->name }}</span>
            </h2>
        </div>
        <div class="p-8">
            <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="department_id" class="block font-semibold mb-2">Department</label>
                        <select name="department_id" id="department_id" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" required>
                            <option value="" disabled>Select Department</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ $course->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="name" class="block font-semibold mb-2">Course Name</label>
                        <input type="text" name="name" id="name" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" value="{{ $course->name }}" required>
                    </div>
                    <div>
                        <label for="school_fees" class="block font-semibold mb-2">School Fees</label>
                        <input type="number" name="school_fees" id="school_fees" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" step="0.01" value="{{ $course->school_fees }}" required>
                    </div>
                    <div>
                        <label for="registration_fees" class="block font-semibold mb-2">Registration Fees</label>
                        <input type="number" name="registration_fees" id="registration_fees" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" step="0.01" value="{{ $course->registration_fees }}" required>
                    </div>
                    <div>
                        <label for="school_uniform_fee" class="block font-semibold mb-2">School Uniform Fee</label>
                        <input type="number" name="school_uniform_fee" id="school_uniform_fee" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" step="0.01" value="{{ $course->school_uniform_fee }}" required>
                    </div>
                    <div>
                        <label for="duration" class="block font-semibold mb-2">Duration</label>
                        <input type="text" name="duration" id="duration" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" value="{{ $course->duration }}" required>
                    </div>
                </div>

                <div>
                    <label for="course_description" class="block font-semibold mb-2">Course Description</label>
                    <textarea name="course_description" id="course_description" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" rows="4" required>{{ $course->course_description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <div>
                        <label class="block font-semibold mb-2">Current Image</label>
                        @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="Current Image" class="rounded-xl shadow mb-2 max-h-40 object-contain bg-gray-50 border">
                        @else
                        <p class="text-gray-400 italic">No image available.</p>
                        @endif
                    </div>
                    <div>
                        <label for="image" class="block font-semibold mb-2">Change Course Image</label>
                        <input type="file" name="image" id="image" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <span class="text-xs text-gray-400">Leave blank to keep current image.</span>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <a href="{{ route('index.cdpert') }}" class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold px-8 py-3 rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                        <i class="fas fa-list"></i>
                        Manage Course
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-8 py-3 rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <i class="fas fa-save"></i>
                        Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
