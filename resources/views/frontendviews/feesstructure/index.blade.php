@extends('layouts.welcomelayout')

@section('content')
    <div class="container">
        <div class="header">
            <div class="school-name">Hewitt and Bennet International College</div>
            <div class="contact-info">
                <div>
                    <p class="contact-info">OUTERING ROAD</p>
                    <p class="contact-info">P.O BOX 24999-00100</p>
                    <p class="contact-info">TEL: 0728541323, 0713490768</p>
                </div>
                <div>
                    <p class="contact-info">Email: <a href="mailto:info@hewittbennet.co.ke">info@hewittbennet.co.ke</a></p>
                    <p class="contact-info">Website: <a href="https://www.hewittbennet.co.ke">www.hewittbennet.co.ke</a></p>
                </div>
            </div>
        </div>
        <h2 style="text-align: center;">Course Fees Structure</h2>
        <table id="courseTable" class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Duration</th>
                    <th>Mode of Learning</th>
                    <th>Registration Fee</th>
                    <th>School Fees</th>
                    <th>Uniform Fees</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="courseTableBody">
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->duration }}</td>
                        <td>{{ $course->learning_mode }}</td>
                        <td>{{ $course->registration_fees }}</td>
                        <td>{{ $course->school_fees }}</td>
                        <td>{{ $course->school_uniform_fee }}</td>
                        <td>{{ $course->registration_fees + $course->school_fees + $course->school_uniform_fee }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            © 2023 Hewitt and Bennet International College | All payments are made through M-Pesa Till Number 5543035 or Paybill Number 400200. Account Number: 8116.
        </div>

        <!-- Include DataTables script after your table -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <script>
        $(document).ready(function() {
            $('#courseTable').DataTable();
        });
        </script>


@endsection
