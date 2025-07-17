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

<!-- Course Datatable -->
<h2>Registration Forms</h2>
<table id="registrationform" class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Date of Birth</th>
            <th>Citizenship</th>
            <th>Religion</th>
            <th>City of Residence</th>
            <th>Phone Number</th>
            <th>Email Address</th>
            <th>Home Contact</th>
            <th>Highest Level of Education:</th>
            <th>Profession:</th>
            <th>Other Skills Acquired:</th>
            <th>Gurdian Name</th>
            <th>Phone Number</th>
            <th>Id Number</th>
            <th>Gurdian Residence</th>
            <th>Any Medical Condition</th>
            <th>Medical Condition Explanation</th>
            <th>Reason for Training</th>
            <th>Expected Gain From training</th>
            <th>Confirmation</th>
            <th>PDF</th> <!-- Added PDF column -->
        </tr>
    </thead>
    <tbody>
        @foreach ($registrationform as $registrationform)
        <tr>
            <td>{{ $registrationform->id }}</td>
            <td>{{ $registrationform->student_name }}</td>
            <td>{{ $registrationform->dob }}</td>
            <td>{{ $registrationform->citizenship }}</td>
            <td>{{ $registrationform->religion }}</td>
            <td>{{ $registrationform->cityofresidence }}</td>
            <td>{{ $registrationform->mobile }}</td>
            <td>{{ $registrationform->emailadress }}</td>
            <td>{{ $registrationform->homephone }}</td>
            <td>{{ $registrationform->education }}</td>
            <td>{{ $registrationform->otherskills }}</td>
            <td>{{ $registrationform->profession }}</td>
            <td>{{ $registrationform->gurdianname }}</td>
            <td>{{ $registrationform->phonenumber }}</td>
            <td>{{ $registrationform->idnumber }}</td>
            <td>{{ $registrationform->gresidence }}</td>
            <td>{{ $registrationform->medical_info_yes }}</td>
            <td>{{ $registrationform->medical_info_explanation }}</td>
            <td>{{ $registrationform->reasonfortraining }}</td>
            <td>{{ $registrationform->gainfortraining }}</td>
            <td>{{ $registrationform->data_is_true }}</td>
            <td>
                @if ($registrationform->file_name)
                    <a href="{{ asset('storage/application_documents/' . $registrationform->file_name) }}" target="_blank">View PDF</a>
                @else
                    No PDF
                @endif
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
    $('#registrationform').DataTable();
});


</script>
@endsection
