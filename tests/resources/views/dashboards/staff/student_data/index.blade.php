@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Student Management')

@section('content')
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 classy-alert" role="alert" style="z-index: 9999; font-size: small;">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.classy-alert').remove();
    }, 3000);
</script>
@endif

@if(session('success'))
<div class="position-fixed top-0 start-50 translate-middle-x mt-3 classy-alert" style="z-index: 9999;">
    <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
</div>
<script>
    setTimeout(function() {
        document.querySelector('.classy-alert').remove();
    }, 3000);
</script>
@endif

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-xl font-bold text-primary mb-4">Create New Student</h2>
    <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
            </div>
            <div class="form-group">
                <label for="student_no" class="block text-sm font-medium text-gray-700">Student No</label>
                <input type="text" name="student_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
            </div>
            <div class="form-group">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="tel" name="phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
            </div>
            <div class="form-group">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
            </div>
            <div class="form-group">
                <label for="id_number" class="block text-sm font-medium text-gray-700">ID Number / Birth Certificate Number</label>
                <input type="text" name="id_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
            </div>
            <div class="form-group">
                <label for="guardian_name" class="block text-sm font-medium text-gray-700">Guardian Name</label>
                <input type="text" name="guardian_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
            </div>
            <div class="form-group">
                <label for="guardian_phone_number" class="block text-sm font-medium text-gray-700">Guardian Phone Number</label>
                <input type="tel" name="guardian_phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
            </div>
            <div class="form-group">
                <label for="guardian_email" class="block text-sm font-medium text-gray-700">Guardian Email</label>
                <input type="email" name="guardian_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
            </div>
            <div class="form-group">
                <label for="passport_photo" class="block text-sm font-medium text-gray-700">Passport Photo</label>
                <input type="file" name="passport_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-lighter file:text-primary hover:file:bg-primary-light" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="course" class="block text-sm font-medium text-gray-700">Course They Are Taking</label>
                <select name="course" id="course" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
                    <option value="" disabled selected>Select a course</option>
                    @foreach($coursese as $course)
                        <option value="{{ $course->name }}" data-fees="{{ $course->registration_fees + $course->school_fees + $course->school_uniform_fee }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="course_fee" class="block text-sm font-medium text-gray-700">Fees for the Course</label>
                <input type="number" name="course_fee" id="course_fee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-gray-100" step="0.01" required readonly>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                Create Student
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-primary">Student Records</h2>
    </div>

    <div class="overflow-x-auto">
        <table id="studentsTable" class="w-full table-auto border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Email</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Contact</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Number</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guardian Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guardian Email</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Passport Photo</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Fee</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($students as $student)
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $student->name }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $student->email }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $student->phone_number }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $student->id_number }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $student->guardian_name }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $student->guardian_email }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">
                        <img src="{{ asset($student->passport_photo) }}" alt="Passport Photo" class="h-10 w-10 rounded-full object-cover">
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $student->course }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ number_format($student->course_fee, 2) }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">
                        <a href="{{ route('students.edit', ['student' => $student->id]) }}" class="text-primary hover:text-primary-dark mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Update course_fee based on selected course
    document.addEventListener('DOMContentLoaded', function () {
        const courseSelect = document.getElementById('course');
        const courseFeeInput = document.getElementById('course_fee');

        courseSelect.addEventListener('change', function () {
            const selectedOption = courseSelect.options[courseSelect.selectedIndex];
            const courseFees = selectedOption.getAttribute('data-fees');
            courseFeeInput.value = courseFees;
        });

        // Initialize DataTable
        $('#studentsTable').DataTable({
            responsive: true,
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"l><"flex space-x-2"Bf>>rt<"flex flex-col md:flex-row md:items-center md:justify-between p-4"<"mb-4 md:mb-0"i><"flex space-x-2"p>>',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fas fa-copy mr-1"></i> Copy',
                    className: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    titleAttr: 'Copy to clipboard'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                    className: 'bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Student_Records_Export',
                    titleAttr: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Student Records - Hewitt and Bennet International College',
                    titleAttr: 'Export to PDF',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Print',
                    className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Student Records - Hewitt and Bennet International College',
                    titleAttr: 'Print table'
                }
            ],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
            ],
            pageLength: 25,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
            }
        });
    });
</script>
@endsection
