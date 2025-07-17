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
            <p class="sub-title">Payment Receipt</p>
        </div>
        <div class="row bill-details">

            <div class="col-md-6 text-left">
                <p class="font-weight-bold">Location:</p>
                <p class="contact-info">OUTERING ROAD</p>
                <p class="contact-info">P.O BOX 24999-00100</p>
                <p class="contact-info">TEL: 0728541323, 0713490768</p>
            </div>
            <div class="col-md-6 text-right">
                <p class="invoice-no font-weight-bold">Receipt NO: {{ $paymentReceipt->ReceiptNo }}</p>
                <p class="date">Date: {{ $paymentReceipt->created_at->format('Y-m-d H:i:s') }}</p>
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
                    <td class="left-align"><strong>Student Name:</strong>{{ $paymentReceipt->student->name }}</td>
                    <td class="center-align"><strong>Course:</strong>{{ $paymentReceipt->student->course }}</td>
                    <td class="right-align"><strong>Registration Number:</strong>{{ $paymentReceipt->student_no }}</td>
                </tr>
                <!-- Other table rows here -->
            </tbody>
        </table>


        <table class="info-table">
            <thead>
                <tr>
                    <th>Paid By</th>
                    <th>Phone Number</th>
                    <th>Mode of Payment</th>
                    <th>Payment For</th>
                    <th>Total Amount Paid</th>
                    <th>Total Fees Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $paymentReceipt->Name }}</td>
                    <td>{{ $paymentReceipt->contact }}</td>
                    <td>{{ $paymentReceipt->modeofpayment }}</td>
                    <td>{{ $paymentReceipt->paymentfor }}</td>
                    <td>KSH: {{ $paymentReceipt->Amount }}</td>
                    <td>KSH: {{ $paymentReceipt->feesStatement->remaining_amount }}</td>
                </tr>
            </tbody>
        </table>
        <div class="gradient-line"></div>
        <div class="footer">
            <div class="left-section">
                <p class="served-by">Served by: {{ $paymentReceipt->servedBy->name }}</p>
                <p>Thank you and Best regards</p>
            </div>
            <div class="right-section">
                <div class="terms">
                    <p class="font-weight-bold">Terms & Conditions Apply</p>
                    <p>Money once receipted shall not be refunded.</p>
                </div>
            </div>
        </div>

        </div>

</div>
</body>
</html>
