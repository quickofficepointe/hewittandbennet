@extends('dashboards.student.layouts.studentlayouts')

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

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Fee Statement</div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(isset($feeStructures) && count($feeStructures) > 0)
                        <h3>Welcome, {{ $feeStructures[0]->student->name }}</h3>
                        <p>Course: {{ $feeStructures[0]->student->course }}</p>
                        <hr>
                        <h4>Fee Statement</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Course Fee</th>
                                    <th>Paid Amount</th>
                                    <th>Remaining Amount</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feeStructures as $feeStructure)
                                    <tr>
                                        <td>{{ $feeStructure->course_fee }}</td>
                                        <td>{{ $feeStructure->paid_amount }}</td>
                                        <td>{{ $feeStructure->remaining_amount }}</td>
                                        <td>{{ $feeStructure->payment_date }}</td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No fee structures found for this student.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
