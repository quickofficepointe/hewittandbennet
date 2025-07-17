
@extends('dashboards.staff.layouts.stafflayout')

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
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#receiptModal">
    Create Receipts
</button>
<div class="content-body">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        <h4>All Receipts</h4>

                    </div>
                    <div class="card-body">

                        <table id="myDataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ReceiptNo</th>
                                    <th>Student Number</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Amount</th>
                                    <th>Payment For</th>
                                    <th>Fees Balance</th>
                                    <th>Served By</th>
                                    <th>Date</th>
                                    <th>Print</th>
                                    <th>View</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($paymentReceipts as $receipt)
                                    <tr>
                                        <td>{{ $receipt->id }}</td>
                                        <td>{{ $receipt->ReceiptNo }}</td>
                                        <td>{{ $receipt->student_no }}</td>
                                        <td>{{ $receipt->Name }}</td>
                                        <!-- Assuming you have a Phone Number column in your payment_receipts table -->
                                        <td>{{ $receipt->contact }}</td>
                                        <td>{{ $receipt->Amount }}</td>
                                        <td>{{ $receipt->paymentfor }}</td>
                                        <td>{{ $receipt->feesStatement->remaining_amount }}</td>
                                        <td>{{ $receipt->servedBy->name }} </td>
                                        <td>{{ $receipt->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td><a href="#" class="print-link" data-receipt-id="{{ $receipt->id }}">Print</a></td>
                                        <td><a href="#">View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payment-receipts.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="student_no">Student Number</label>
                            <input type="text" id="student_no" name="student_no" class="form-control" required>
                            <button type="button" class="btn btn-primary mt-2" id="searchStudent">Search Student</button>
                        </div>

                        <!-- Display student information here -->
                        <div id="studentInfo" style="display: none;">
                            <h3>Student Information</h3>
                            <p>Name: <span id="studentName"></span></p>
                            <p>Course: <span id="studentCourse"></span></p>
                            <p>Total Fee: <span id="studentTotalFee"></span></p>
                            <!-- You can calculate and display the fee paid and balance here -->
                        </div>

                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input type="text" name="Name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="Amount">Phone Number</label>
                            <input type="number" name="contact" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="Amount">Amount</label>
                            <input type="number" name="Amount" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="paymentfor">Payment For</label>
                            <input type="text" name="paymentfor" class="form-control" required
                                list="paymentOptions" placeholder="Enter or select an option">
                            <datalist id="paymentOptions">
                                <option value="Uniform">Uniform</option>
                                <option value="School Id">School ID</option>
                                <option value="Registration Fees">Registration Fee</option>
                                <option value="School Fees">School Fees</option>
                                <option value="Uniform  Registration Fee">Uniform,  Registration Fee</option>
                                <option value="Uniform  School Fees">Uniform , School Fees</option>
                                <option value="Registration Fee  school_fees">Registration Fee, School Fees</option>
                                <option value="Uniform + Registration Fee  School Fees">Uniform, Registration Fee, School Fees</option>
                                <!-- Add more options as needed -->
                            </datalist>
                        </div>

                        <div class="form-group">
                            <label for="modeofpayment">Mode of Payment</label>
                            <select name="modeofpayment" class="form-control" required>
                                <option value="Cash">Cash</option>
                                <option value="M-pesa">M-Pesa</option>
                                <option value="Bank">Bank</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="served_by">Served By</label>
                            <input type="hidden" name="served_by" value="{{ Auth::id() }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Add Receipt</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Make sure this script block is within a Blade view -->

    <script>
      document.getElementById('searchStudent').addEventListener('click', function () {
        const studentNumber = document.getElementById('student_no').value;

        if (studentNumber) {
            // Send an AJAX request to fetch student information
            fetch(`/get-student-info/${studentNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Populate the student information fields with data from the server
                        document.getElementById('studentName').textContent = data.student.name;
                        document.getElementById('studentCourse').textContent = data.student.course;
                        document.getElementById('studentTotalFee').textContent = data.student.course_fee;

                        // Fill the "Name" and "Phone Number" input fields
                        document.getElementsByName('Name')[0].value = data.student.name;
                        document.getElementsByName('contact')[0].value = data.student.phone_number;

                        // Display the student information div
                        document.getElementById('studentInfo').style.display = 'block';
                    } else {
                        // Clear the student information and hide the div if student is not found
                        document.getElementById('studentName').textContent = '';
                        document.getElementById('studentCourse').textContent = '';
                        document.getElementById('studentTotalFee').textContent = '';

                        // Clear the "Name" and "Phone Number" input fields
                        document.getElementsByName('Name')[0].value = '';
                        document.getElementsByName('contact')[0].value = '';

                        // Hide the student information div
                        document.getElementById('studentInfo').style.display = 'none';

                        alert('Student not found.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            // Clear the student information and hide the div if student number is empty
            document.getElementById('studentName').textContent = '';
            document.getElementById('studentCourse').textContent = '';
            document.getElementById('studentTotalFee').textContent = '';

            // Clear the "Name" and "Phone Number" input fields
            document.getElementsByName('Name')[0].value = '';
            document.getElementsByName('contact')[0].value = '';

            // Hide the student information div
            document.getElementById('studentInfo').style.display = 'none';
        }
    });
        // JavaScript code to handle printing receipts
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
