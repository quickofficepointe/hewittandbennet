@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Student Management')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Alerts with Modern Design -->
    @if($errors->any())
    <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 animate-slide-down" id="error-alert">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-lg p-4 max-w-md">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">Please fix the following errors:</p>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.closest('#error-alert').remove()" class="ml-auto text-red-400 hover:text-red-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('error-alert');
            if(alert) alert.style.opacity = '0';
            setTimeout(() => { if(alert) alert.remove(); }, 300);
        }, 5000);
    </script>
    @endif

    @if(session('success'))
    <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 animate-slide-down" id="success-alert">
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-lg p-4 max-w-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('#success-alert').remove()" class="ml-auto text-green-400 hover:text-green-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if(alert) alert.style.opacity = '0';
            setTimeout(() => { if(alert) alert.remove(); }, 300);
        }, 5000);
    </script>
    @endif

    <!-- Create Student Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-600 to-primary-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Create New Student</h2>
                    <p class="text-primary-100 text-sm mt-1">Add a new student to the system</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-plus text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Personal Information Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user text-primary-600 text-sm"></i>
                        </div>
                        Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student Number *</label>
                            <input type="text" name="student_no" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" name="phone_number" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">ID / Birth Certificate Number *</label>
                            <input type="text" name="id_number" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Passport Photo *</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary-500 transition cursor-pointer" id="photo-upload-area">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="passport_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="passport_photo" name="passport_photo" type="file" class="sr-only" accept="image/*" required>
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guardian Information Section -->
                <div class="pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user-friends text-purple-600 text-sm"></i>
                        </div>
                        Guardian Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Guardian Name *</label>
                            <input type="text" name="guardian_name" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Guardian Phone Number *</label>
                            <input type="tel" name="guardian_phone_number" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Guardian Email *</label>
                            <input type="email" name="guardian_email" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" required>
                        </div>
                    </div>
                </div>

                <!-- Course Information Section -->
                <div class="pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-green-600 text-sm"></i>
                        </div>
                        Course Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Course *</label>
                            <select name="course" id="course" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" required>
                                <option value="" disabled selected>Select a course</option>
                                @foreach($coursese as $course)
                                    <option value="{{ $course->name }}" data-fees="{{ $course->registration_fees + $course->school_fees + $course->school_uniform_fee }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course Fee (KES) *</label>
                            <input type="number" name="course_fee" id="course_fee" class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" step="0.01" required readonly>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-medium rounded-xl hover:from-primary-700 hover:to-primary-800 transition shadow-md hover:shadow-lg">
                        <i class="fas fa-save mr-2"></i>Create Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Student Records Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Student Records</h2>
                    <p class="text-sm text-gray-500 mt-1">Manage and view all student information</p>
                </div>
                <div class="flex space-x-2">
                    <div class="bg-white rounded-xl px-4 py-2 shadow-sm">
                        <i class="fas fa-users text-primary-600 mr-2"></i>
                        <span class="font-semibold text-gray-700">{{ $students->count() }}</span>
                        <span class="text-sm text-gray-500">Total Students</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table id="studentsTable" class="min-w-full" style="width:100%">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student Contact</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Number</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Guardian Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Guardian Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Passport Photo</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Course</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Course Fee</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $student)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-primary-600 text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-600">{{ $student->email }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-600">{{ $student->phone_number }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-gray-600">{{ $student->id_number }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-user-friends text-gray-400 mr-2 text-sm"></i>
                                    <span class="text-gray-600">{{ $student->guardian_name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-gray-600">{{ $student->guardian_email }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <img src="{{ asset($student->passport_photo) }}" alt="Passport" class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-200">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $student->course }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="font-semibold text-primary-600">KES {{ number_format($student->course_fee, 2) }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a href="{{ route('students.edit', ['student' => $student->id]) }}" class="inline-flex items-center px-3 py-1.5 bg-primary-50 hover:bg-primary-100 text-primary-600 rounded-lg transition group">
                                    <i class="fas fa-edit text-sm group-hover:scale-110 transition"></i>
                                    <span class="ml-1 text-sm">Edit</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Course fee calculation
        const courseSelect = document.getElementById('course');
        const courseFeeInput = document.getElementById('course_fee');

        if(courseSelect) {
            courseSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const fees = selectedOption.getAttribute('data-fees');
                if(fees) {
                    courseFeeInput.value = fees;
                } else {
                    courseFeeInput.value = '';
                }
            });
        }

        // Initialize DataTable
        if ($.fn.DataTable) {
            $('#studentsTable').DataTable({
                responsive: true,
                dom: '<"flex flex-col md:flex-row md:items-center md:justify-between mb-6"<"mb-4 md:mb-0"l>B<"mt-4 md:mt-0"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between mt-6"<"mb-4 md:mb-0"i><p>>',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy mr-2"></i>Copy',
                        className: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl transition'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel mr-2"></i>Excel',
                        className: 'bg-green-50 hover:bg-green-100 text-green-700 px-4 py-2 rounded-xl transition',
                        title: 'Student_Records_' + new Date().toISOString().slice(0,10)
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv mr-2"></i>CSV',
                        className: 'bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-xl transition'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf mr-2"></i>PDF',
                        className: 'bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-xl transition',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print mr-2"></i>Print',
                        className: 'bg-purple-50 hover:bg-purple-100 text-purple-700 px-4 py-2 rounded-xl transition'
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns mr-2"></i>Columns',
                        className: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl transition'
                    }
                ],
                lengthMenu: [[10, 25, 50, 100, -1], ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']],
                pageLength: 25,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search students...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>'
                    }
                },
                order: [[0, 'asc']],
                initComplete: function() {
                    $('.dt-buttons').addClass('flex flex-wrap gap-2');
                    $('.dataTables_filter input').addClass('border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-transparent');
                    $('.dataTables_length select').addClass('border border-gray-300 rounded-xl px-3 py-2');
                }
            });
        }

        // Photo upload area styling
        const uploadArea = document.getElementById('photo-upload-area');
        const fileInput = document.getElementById('passport_photo');

        if(uploadArea && fileInput) {
            uploadArea.addEventListener('click', () => fileInput.click());
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('border-primary-500', 'bg-primary-50');
            });
            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('border-primary-500', 'bg-primary-50');
            });
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('border-primary-500', 'bg-primary-50');
                fileInput.files = e.dataTransfer.files;
            });
        }

        // Animate cards
        const cards = document.querySelectorAll('.bg-white.rounded-2xl');
        cards.forEach((card, index) => {
            card.style.animation = `slideUp 0.4s ease-out ${index * 0.1}s forwards`;
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
        });

        // Add animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translate(-50%, -100%);
                }
                to {
                    opacity: 1;
                    transform: translate(-50%, 0);
                }
            }
            .animate-slide-down {
                animation: slideDown 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush

@push('styles')
<style>
    /* Form input focus effects */
    input:focus, select:focus {
        outline: none;
        ring: 2px solid #3b82f6;
    }

    /* File upload area hover effect */
    #photo-upload-area:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    /* Table styling */
    #studentsTable tbody tr {
        transition: all 0.2s ease;
    }
    
    #studentsTable tbody tr:hover {
        background-color: #f9fafb;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dt-buttons {
            overflow-x: auto;
            padding-bottom: 0.5rem;
            flex-wrap: nowrap !important;
        }

        .dt-buttons button {
            white-space: nowrap;
        }
    }
</style>
@endpush
@endsection
