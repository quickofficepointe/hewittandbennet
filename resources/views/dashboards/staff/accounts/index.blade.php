@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Payment Receipts')

@section('content')
<!-- Error Messages -->
@if($errors->any())
<div x-data="{ show: true }"
     x-show="show"
     x-transition
     class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <i class="fas fa-exclamation-circle mr-2"></i>
                <strong>Error!</strong>
            </div>
            <button @click="show = false" class="text-red-700 hover:text-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="mt-2 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<!-- Success Message -->
@if(session('success'))
<div x-data="{ show: true }"
     x-show="show"
     x-transition
     x-init="setTimeout(() => show = false, 3000)"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Payment Receipts</h2>
        <button @click="openModal = true"
                class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Create Receipt
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-800">All Receipts</h4>
        </div>
        <div class="overflow-x-auto">
            <table id="myDataTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ReceiptNo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment For</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Served By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Print</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">View</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($paymentReceipts as $receipt)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->ReceiptNo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->student_no }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->Name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->contact }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->Amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->paymentfor }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->feesStatement->remaining_amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->servedBy->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $receipt->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800">
                                <a href="#" class="print-link" data-receipt-id="{{ $receipt->id }}">Print</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800">
                                <a href="#">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Receipt Modal -->
<div x-data="{ openModal: false }" x-cloak>
    <!-- Modal Backdrop -->
    <div x-show="openModal"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Modal Content -->
    <div x-show="openModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="openModal = false">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-blue-700 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-white">Create Receipt</h3>
                        <button @click="openModal = false" class="text-white hover:text-blue-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('payment-receipts.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="student_no" class="block text-sm font-medium text-gray-700 mb-1">Student Number</label>
                            <div class="flex space-x-2">
                                <input type="text" id="student_no" name="student_no"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                       required>
                                <button type="button" id="searchStudent"
                                        class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition">
                                    Search
                                </button>
                            </div>
                        </div>

                        <!-- Student Information -->
                        <div id="studentInfo" class="hidden mb-4 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-800 mb-2">Student Information</h3>
                            <p class="text-sm text-gray-600"><span class="font-medium">Name:</span> <span id="studentName"></span></p>
                            <p class="text-sm text-gray-600"><span class="font-medium">Course:</span> <span id="studentCourse"></span></p>
                            <p class="text-sm text-gray-600"><span class="font-medium">Total Fee:</span> <span id="studentTotalFee"></span></p>
                        </div>

                        <div class="mb-4">
                            <label for="Name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="Name"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="number" name="contact"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="Amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                            <input type="number" name="Amount" step="0.01"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="paymentfor" class="block text-sm font-medium text-gray-700 mb-1">Payment For</label>
                            <input type="text" name="paymentfor"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                   required list="paymentOptions" placeholder="Enter or select an option">
                            <datalist id="paymentOptions">
                                <option value="Uniform">Uniform</option>
                                <option value="School Id">School ID</option>
                                <option value="Registration Fees">Registration Fee</option>
                                <option value="School Fees">School Fees</option>
                                <option value="Uniform  Registration Fee">Uniform, Registration Fee</option>
                                <option value="Uniform  School Fees">Uniform, School Fees</option>
                                <option value="Registration Fee  school_fees">Registration Fee, School Fees</option>
                                <option value="Uniform + Registration Fee  School Fees">Uniform, Registration Fee, School Fees</option>
                            </datalist>
                        </div>

                        <div class="mb-4">
                            <label for="modeofpayment" class="block text-sm font-medium text-gray-700 mb-1">Mode of Payment</label>
                            <select name="modeofpayment"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                    required>
                                <option value="Cash">Cash</option>
                                <option value="M-pesa">M-Pesa</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>

                        <input type="hidden" name="served_by" value="{{ Auth::id() }}">

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openModal = false"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Add Receipt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Student search functionality
    document.getElementById('searchStudent').addEventListener('click', function () {
        const studentNumber = document.getElementById('student_no').value;

        if (studentNumber) {
            fetch(`/get-student-info/${studentNumber}`)
                .then(response => response.json())
                .then(data => {
                    const studentInfo = document.getElementById('studentInfo');
                    if (data.success) {
                        document.getElementById('studentName').textContent = data.student.name;
                        document.getElementById('studentCourse').textContent = data.student.course;
                        document.getElementById('studentTotalFee').textContent = data.student.course_fee;

                        document.getElementsByName('Name')[0].value = data.student.name;
                        document.getElementsByName('contact')[0].value = data.student.phone_number;

                        studentInfo.classList.remove('hidden');
                    } else {
                        document.getElementById('studentName').textContent = '';
                        document.getElementById('studentCourse').textContent = '';
                        document.getElementById('studentTotalFee').textContent = '';

                        document.getElementsByName('Name')[0].value = '';
                        document.getElementsByName('contact')[0].value = '';

                        studentInfo.classList.add('hidden');
                        alert('Student not found.');
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            const studentInfo = document.getElementById('studentInfo');
            document.getElementById('studentName').textContent = '';
            document.getElementById('studentCourse').textContent = '';
            document.getElementById('studentTotalFee').textContent = '';

            document.getElementsByName('Name')[0].value = '';
            document.getElementsByName('contact')[0].value = '';

            studentInfo.classList.add('hidden');
        }
    });

    // Print receipt functionality
    document.addEventListener("DOMContentLoaded", function () {
        const printLinks = document.querySelectorAll('.print-link');

        printLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const receiptId = this.getAttribute('data-receipt-id');
                printReceipt(receiptId);
            });
        });

        function printReceipt(receiptId) {
            const url = "{{ route('payment-receipts.print', ['id' => ':id']) }}".replace(':id', receiptId);
            const printWindow = window.open(url, '_blank');
            printWindow.onload = function () {
                printWindow.print();
            };
        }
    });
</script>
@endsection
