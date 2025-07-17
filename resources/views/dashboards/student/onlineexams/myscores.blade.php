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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hewitt and Bennet International College</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/stylesinfo.css') }}">
</head>
<body>

<div class="container">
    <div class="invoice-wrapper">
        <div class="text-center">
            <div class="invoice-logo">
                <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="HBIC Logo" class="img-fluid">
            </div>
            <p class="invoice-title">Hewitt and Bennet International College</p>
            <p class="sub-title">Results Slip</p>
        </div>
        <div class="row bill-details">
            <div class="col-md-6 text-left">
                <p class="font-weight-bold">Location:</p>
                <p class="contact-info">OUTERING ROAD</p>
                <p class="contact-info">P.O BOX 24999-00100</p>
                <p class="contact-info">TEL: 0728541323, 0713490768</p>
            </div>
            <div class="col-md-6 text-right">
                <p class="invoice-no font-weight-bold">Exam NO: HBICFE</p>
                <!-- Replace $studentdata with the actual user data, e.g., Auth::user() -->
                <p class="date">Date: {{ date('Y-m-d H:i:s') }}</p>

                <p class="contact-info">Email: <a href="mailto:info@hewittbennet.co.ke">info@hewittbennet.co.ke</a></p>
                <p class="contact-info">Website: <a href="https://www.hewittbennet.co.ke">www.hewittbennet.co.ke</a></p>
            </div>
        </div>
        <table class="info-table">
            <thead>
                <!-- Table headers here -->
            </thead>
            <tbody>
               
                <tr>
                    <td class="left-align"><strong>Student Name:</strong> {{ auth()->user()->name }}</td>

                    <td class="center-align"><strong>Course:</strong> Community Health Assistant Course(CHA)</td>
                    <td class="right-align"><strong>Registration Number:</strong>  {{ auth()->user()->username }}</td>
                </tr>

                <!-- Other table rows here -->
            </tbody>
        </table>
        <table class="info-table">
            <thead>
                <tr>
                    <th>Exam Name</th>
                    <th>Exam Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($myscores as $score)
                <tr>
                    <td>{{ $score->onlineExam->title }}</td>
                    <td>{{ $score->score }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
@endsection
