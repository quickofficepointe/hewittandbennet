@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Payment Receipts')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold mb-2">Payment Receipts</h2>
                <p class="text-primary-100">Manage and track all student payment transactions</p>
            </div>
            <div class="flex space-x-3">
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <i class="fas fa-receipt mr-2"></i>
                    <span class="font-semibold">{{ isset($paymentReceipts) ? $paymentReceipts->count() : 0 }}</span>
                    <span class="text-sm">Total Receipts</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    <span class="font-semibold">KES {{ number_format(isset($paymentReceipts) ? $paymentReceipts->sum('Amount') : 0, 2) }}</span>
                    <span class="text-sm">Total Amount</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Receipts -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-receipt text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-primary-600">{{ isset($paymentReceipts) ? $paymentReceipts->count() : 0 }}</span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Total Receipts</h3>
            <p class="text-sm text-gray-500">All time transactions</p>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-money-bill-wave text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">KES {{ number_format(isset($paymentReceipts) ? $paymentReceipts->sum('Amount') : 0, 0) }}</span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Total Revenue</h3>
            <p class="text-sm text-gray-500">Total amount collected</p>
        </div>

        <!-- This Month -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-calendar-week text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-purple-600">
                    KES {{ number_format(isset($paymentReceipts) ? $paymentReceipts->where('created_at', '>=', now()->startOfMonth())->sum('Amount') : 0, 0) }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">This Month</h3>
            <p class="text-sm text-gray-500">{{ now()->format('F Y') }}</p>
        </div>

        <!-- Average Transaction -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-orange-600">
                    KES {{ number_format(isset($paymentReceipts) && $paymentReceipts->count() > 0 ? $paymentReceipts->sum('Amount') / $paymentReceipts->count() : 0, 0) }}
                </span>
            </div>
            <h3 class="text-gray-700 font-semibold mb-1">Average Transaction</h3>
            <p class="text-sm text-gray-500">Per receipt</p>
        </div>
    </div>

    <!-- Alerts -->
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
            setTimeout(() => { if(alert) alert.remove(); }, 5000);
        }, 300);
    </script>
    @endif

    <!-- Receipts Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">All Payment Receipts</h3>
                    <p class="text-sm text-gray-500 mt-1">Complete transaction history</p>
                </div>
                <div class="flex space-x-2">
                    <button id="createReceiptBtn" class="px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl transition shadow-md hover:shadow-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>Create Receipt
                    </button>
                    <button onclick="window.location.reload()" class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table id="paymentReceiptsTable" class="min-w-full" style="width:100%">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Receipt No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payment For</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mode</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Balance</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Served By</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if(isset($paymentReceipts) && $paymentReceipts->count() > 0)
                            @foreach($paymentReceipts as $receipt)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-medium text-gray-800">{{ $receipt->id }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                        #{{ $receipt->ReceiptNo }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $receipt->student_no }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-primary-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $receipt->Name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-gray-600">{{ $receipt->contact }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-semibold text-green-600">KES {{ number_format($receipt->Amount, 2) }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $receipt->paymentfor }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $modeColors = [
                                            'Cash' => 'bg-green-100 text-green-800',
                                            'M-pesa' => 'bg-purple-100 text-purple-800',
                                            'Bank' => 'bg-orange-100 text-orange-800'
                                        ];
                                        $modeColor = $modeColors[$receipt->modeofpayment] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $modeColor }}">
                                        <i class="fas {{ $receipt->modeofpayment == 'M-pesa' ? 'fa-mobile-alt' : ($receipt->modeofpayment == 'Bank' ? 'fa-university' : 'fa-money-bill-wave') }} mr-1 text-xs"></i>
                                        {{ $receipt->modeofpayment }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-gray-600">KES {{ number_format($receipt->feesStatement->remaining_amount ?? 0, 2) }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-check text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-gray-600">{{ $receipt->servedBy->name ?? 'System' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-gray-400 mr-2 text-sm"></i>
                                        <span class="text-gray-600">{{ $receipt->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <button onclick="printReceipt({{ $receipt->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-primary-50 hover:bg-primary-100 text-primary-600 rounded-lg transition group">
                                            <i class="fas fa-print text-sm group-hover:scale-110 transition"></i>
                                            <span class="ml-1 text-sm">Print</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 opacity-50"></i>
                                    <p>No payment receipts found</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Receipt Modal -->
<div id="receiptModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50 hidden">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-gradient-to-r from-primary-600 to-primary-800 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white">Create New Receipt</h3>
                        <p class="text-primary-100 text-sm mt-1">Generate payment receipt for student</p>
                    </div>
                    <button id="closeModalBtn" class="text-white hover:text-primary-200 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('payment-receipts.store') }}" method="POST" id="receiptForm">
                    @csrf
                    <!-- Student Search -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Student Number *</label>
                        <div class="flex space-x-2">
                            <input type="text" id="student_no" name="student_no"
                                   class="flex-1 rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2 border"
                                   placeholder="Enter student number" required>
                            <button type="button" id="searchStudentBtn"
                                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-xl transition shadow-sm">
                                <i class="fas fa-search mr-2"></i>Search
                            </button>
                        </div>
                    </div>

                    <!-- Student Information Card -->
                    <div id="studentInfoCard" class="hidden mb-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user-graduate text-primary-600"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800">Student Information</h4>
                        </div>
                        <div class="space-y-2 text-sm">
                            <p><span class="font-medium text-gray-600">Name:</span> <span id="studentName" class="text-gray-800"></span></p>
                            <p><span class="font-medium text-gray-600">Course:</span> <span id="studentCourse" class="text-gray-800"></span></p>
                            <p><span class="font-medium text-gray-600">Total Fee:</span> <span id="studentTotalFee" class="text-primary-600 font-semibold"></span></p>
                            <p><span class="font-medium text-gray-600">Paid Amount:</span> <span id="studentPaidAmount" class="text-green-600 font-semibold"></span></p>
                            <p><span class="font-medium text-gray-600">Balance:</span> <span id="studentBalance" class="text-orange-600 font-semibold"></span></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Student Name *</label>
                        <input type="text" name="Name" id="studentNameInput"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2 border"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input type="tel" name="contact" id="studentPhone"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2 border"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amount (KES) *</label>
                        <input type="number" name="Amount" id="amount" step="0.01"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2 border"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment For *</label>
                        <input type="text" name="paymentfor" id="paymentfor"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2 border"
                               required list="paymentOptions" placeholder="Enter or select an option">
                        <datalist id="paymentOptions">
                            <option value="Uniform">Uniform</option>
                            <option value="School Id">School ID</option>
                            <option value="Registration Fees">Registration Fee</option>
                            <option value="School Fees">School Fees</option>
                            <option value="Uniform, Registration Fee">Uniform, Registration Fee</option>
                            <option value="Uniform, School Fees">Uniform, School Fees</option>
                            <option value="Registration Fee, School Fees">Registration Fee, School Fees</option>
                            <option value="Uniform, Registration Fee, School Fees">Uniform, Registration Fee, School Fees</option>
                        </datalist>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mode of Payment *</label>
                        <select name="modeofpayment" id="modeofpayment"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 p-2 border"
                                required>
                            <option value="Cash">💵 Cash</option>
                            <option value="M-pesa">📱 M-Pesa</option>
                            <option value="Bank">🏦 Bank Transfer</option>
                        </select>
                    </div>

                    <input type="hidden" name="served_by" value="{{ Auth::id() }}">

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" id="cancelModalBtn"
                                class="px-4 py-2 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl shadow-sm hover:shadow-md transition">
                            <i class="fas fa-save mr-2"></i>Create Receipt
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        if ($.fn.DataTable && $('#paymentReceiptsTable').length) {
            $('#paymentReceiptsTable').DataTable({
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
                        title: 'Payment_Receipts_' + new Date().toISOString().slice(0,10)
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
                order: [[0, 'desc']],
                pageLength: 25,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search receipts...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ receipts"
                },
                initComplete: function() {
                    $('.dt-buttons').addClass('flex flex-wrap gap-2');
                    $('.dataTables_filter input').addClass('border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary-500');
                    $('.dataTables_length select').addClass('border border-gray-300 rounded-xl px-3 py-2');
                }
            });
        }

        // Modal functionality
        const modal = document.getElementById('receiptModal');
        const createBtn = document.getElementById('createReceiptBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelModalBtn = document.getElementById('cancelModalBtn');

        function openModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            document.getElementById('receiptForm').reset();
            document.getElementById('studentInfoCard').classList.add('hidden');
        }

        if(createBtn) createBtn.addEventListener('click', openModal);
        if(closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if(cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', function(e) {
            if(e.target === modal) closeModal();
        });

        // Student search functionality
        const searchBtn = document.getElementById('searchStudentBtn');
        const studentNoInput = document.getElementById('student_no');

        if(searchBtn) {
            searchBtn.addEventListener('click', function() {
                const studentNumber = studentNoInput.value.trim();

                if(studentNumber) {
                    fetch(`/get-student-info/${studentNumber}`)
                        .then(response => response.json())
                        .then(data => {
                            const infoCard = document.getElementById('studentInfoCard');
                            if(data.success) {
                                document.getElementById('studentName').textContent = data.student.name;
                                document.getElementById('studentCourse').textContent = data.student.course;
                                document.getElementById('studentTotalFee').textContent = 'KES ' + numberFormat(data.student.course_fee);
                                document.getElementById('studentPaidAmount').textContent = 'KES ' + numberFormat(data.student.paid_amount || 0);
                                document.getElementById('studentBalance').textContent = 'KES ' + numberFormat((data.student.course_fee || 0) - (data.student.paid_amount || 0));

                                document.getElementById('studentNameInput').value = data.student.name;
                                document.getElementById('studentPhone').value = data.student.phone_number;

                                infoCard.classList.remove('hidden');
                            } else {
                                infoCard.classList.add('hidden');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Student Not Found',
                                    text: 'No student found with this number.',
                                    confirmButtonColor: '#DC2626'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to fetch student information.',
                                confirmButtonColor: '#DC2626'
                            });
                        });
                } else {
                    document.getElementById('studentInfoCard').classList.add('hidden');
                }
            });
        }

        function numberFormat(num) {
            return num.toLocaleString('en-KE', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        // Animate cards
        const cards = document.querySelectorAll('.bg-white.rounded-2xl');
        cards.forEach((card, index) => {
            card.style.animation = `slideUp 0.4s ease-out ${index * 0.05}s forwards`;
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
        });

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

    // Print receipt function
    function printReceipt(receiptId) {
        const url = "{{ route('payment-receipts.print', ['id' => ':id']) }}".replace(':id', receiptId);
        const printWindow = window.open(url, '_blank');
        printWindow.onload = function() {
            printWindow.print();
        };
    }
</script>
@endpush

@push('styles')
<style>
    /* DataTables custom styling */
    .dataTables_wrapper .dataTables_filter input {
        width: 250px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: 0.75rem;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin: 0 0.25rem;
        border-radius: 0.5rem;
        background: #f3f4f6;
        color: #374151 !important;
        border: none;
        transition: all 0.2s;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e5e7eb;
        transform: translateY(-1px);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #3b82f6;
        color: white !important;
    }

    #paymentReceiptsTable tbody tr {
        transition: all 0.2s ease;
    }

    #paymentReceiptsTable tbody tr:hover {
        background-color: #f9fafb;
    }

    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_filter input {
            width: 100%;
        }

        .dt-buttons {
            overflow-x: auto;
            padding-bottom: 0.5rem;
            flex-wrap: nowrap !important;
        }
    }
</style>
@endpush
@endsection
