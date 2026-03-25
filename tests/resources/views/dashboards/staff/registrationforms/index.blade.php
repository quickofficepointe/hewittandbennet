@extends('dashboards.staff.layouts.stafflayout')

@section('pageTitle', 'Registration Forms')

@section('content')
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3"
     role="alert"
     style="z-index: 9999; font-size: small;">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<script>
    setTimeout(() => document.querySelector('.alert')?.remove(), 3000);
</script>
@endif

@if(session('success'))
<div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
    <div class="alert alert-success d-flex align-items-center justify-content-center shadow-md" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
</div>
<script>
    setTimeout(() => document.querySelector('.alert')?.remove(), 3000);
</script>
@endif

<div class="mb-6">
    <h2 class="text-2xl font-bold text-primary mb-4">📄 Registration Forms</h2>
</div>

<div class="bg-white rounded-lg shadow-md p-4 md:p-6">
    <!-- Table wrapper for scroll -->
    <div class="table-responsive" style="max-height: 75vh; overflow-y: auto; overflow-x: auto;">
        <table id="registrationform" class="table table-bordered table-hover table-striped align-middle text-sm">
            <thead class="bg-gray-100 text-gray-700 sticky top-0">
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
                    <th>Highest Level of Education</th>
                    <th>Profession</th>
                    <th>Other Skills Acquired</th>
                    <th>Guardian Name</th>
                    <th>Guardian Phone</th>
                    <th>Guardian ID</th>
                    <th>Guardian Residence</th>
                    <th>Any Medical Condition</th>
                    <th>Medical Condition Explanation</th>
                    <th>Reason for Training</th>
                    <th>Expected Gain From Training</th>
                    <th>Confirmation</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registrationform as $form)
                <tr>
                    <td>{{ $form->id }}</td>
                    <td>{{ $form->student_name }}</td>
                    <td>{{ $form->dob }}</td>
                    <td>{{ $form->citizenship }}</td>
                    <td>{{ $form->religion }}</td>
                    <td>{{ $form->cityofresidence }}</td>
                    <td>{{ $form->mobile }}</td>
                    <td>{{ $form->emailadress }}</td>
                    <td>{{ $form->homephone }}</td>
                    <td>{{ $form->education }}</td>
                    <td>{{ $form->profession }}</td>
                    <td>{{ $form->otherskills }}</td>
                    <td>{{ $form->gurdianname }}</td>
                    <td>{{ $form->phonenumber }}</td>
                    <td>{{ $form->idnumber }}</td>
                    <td>{{ $form->gresidence }}</td>
                    <td>{{ $form->medical_info_yes }}</td>
                    <td>{{ $form->medical_info_explanation }}</td>
                    <td>{{ $form->reasonfortraining }}</td>
                    <td>{{ $form->gainfortraining }}</td>
                    <td>{{ $form->data_is_true }}</td>
                    <td>
                        @if ($form->file_name)
                            <a href="{{ asset('storage/application_documents/' . $form->file_name) }}"
                               target="_blank"
                               class="text-primary hover:text-primary-dark fw-bold">
                                View PDF
                            </a>
                        @else
                            <span class="text-muted">No PDF</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Make table borders more distinct */
    #registrationform th, #registrationform td {
        border: 1px solid #dee2e6 !important;
        vertical-align: middle;
    }

    #registrationform thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        text-align: center;
    }

    #registrationform tbody tr:hover {
        background-color: #f1f5f9; /* light hover effect */
    }
</style>

<script>
    $(document).ready(function () {
        $('#registrationform').DataTable({
            responsive: true,
            scrollX: true,   // horizontal scroll inside DataTables
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
                    title: 'Registration_Forms_Export',
                    titleAttr: 'Export to Excel',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Registration Forms - Hewitt and Bennet International College',
                    titleAttr: 'Export to PDF',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: { columns: ':visible' },
                    customize: function (doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.styles.title = {
                            color: '#1d4ed8',
                            fontSize: 18,
                            alignment: 'center'
                        };
                        doc.styles.tableHeader = {
                            fillColor: '#1d4ed8',
                            color: '#FFFFFF',
                            bold: true
                        };
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Print',
                    className: 'bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-3 rounded-lg flex items-center shadow-sm',
                    title: 'Registration Forms - Hewitt and Bennet International College',
                    titleAttr: 'Print table',
                    exportOptions: { columns: ':visible' }
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
            },
            initComplete: function () {
                $('.dt-button').removeClass('dt-button');
            }
        });
    });
</script>
@endsection
