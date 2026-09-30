<!DOCTYPE html>
<html lang="en">
@php
    $company = DB::table('company_settings')->first();
@endphp
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 30px;
        }

            .container {
                width: 650px;       
                margin: 0 auto;
                background: #ffffff;
            }


        /* HEADER */
        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: top;
        }

        .logo img {
            width: 80px;
        }

        .company-info {
            text-align: right;
            line-height: 1.5;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin: 25px 0 15px;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        /* INFO ROW */
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-table td {
            vertical-align: top;
            padding: 4px 0;
        }

        .info-right {
            text-align: right;
        }

        /* SECTION TITLE */
        .section-title {
            font-weight: bold;
            margin: 12px 0 5px;
        }

        /* DATA TABLES */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
        }

        table.data-table td:first-child {
            text-align: left;
        }

        /* NOTES */
        .notes {
            margin-top: 10px;
        }

        /* FOOTER */
        .footer {
            margin-top: 25px;
        }

        .seal img {
            width: 90px;
        }

        .authorized {
            margin-top: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td class="logo">
                <img src="{{ $company->logo }}" alt="Logo">
            </td>
            <td class="company-info">
                <strong>{{ $company->company_name }}</strong><br>
                {{ $company->address }}<br>
                {{ $company->city }} - {{ $company->pincode }}<br>
                <strong style="color:#640da3;">Contact No:</strong> {{ $company->company_phone }}
            </td>
        </tr>
    </table>

    <div class="title">PAYMENT RECEIPT</div>


    <!-- PAYEE / RECEIPT INFO -->
    <table class="info-table">
        <tr>
            <td>
                <strong>Payee (Received By):</strong> {{ $company->company_name }}<br>
                <strong>Payer (Paid By):</strong> {{ $paymentMailData['student_name'] }}
            </td>
            <td class="info-right">
                <strong>Receipt No:</strong>
                PR-{{ str_pad($paymentMailData['id'], 3, '0', STR_PAD_LEFT) }}<br>
                <strong>Invoice Date:</strong> {{ $paymentMailData['payment_date'] }}
            </td>
        </tr>
    </table>

    <hr>

    <!-- PAYMENT DETAILS -->
    <div class="section-title">Payment Details</div>
    <table class="data-table">
        <tr>
            <th>Description</th>
            <th>Amount (INR)</th>
        </tr>
        <tr>
            <td>{{ $paymentMailData['fee_title'] ?? 'Internship Fee' }}</td>
            <td>₹ {{ number_format($paymentMailData['total_fees']) }}</td>
        </tr>
        <tr>
            <td>Paid</td>
            <td>₹ {{ number_format($paymentMailData['total_paid']) }}</td>
        </tr>
        <tr>
            <td><strong>Pending</strong></td>
            <td><strong>₹ {{ number_format($paymentMailData['pending']) }}</strong></td>
        </tr>
    </table>

    <!-- TRANSACTION INFO -->
    <div class="section-title">Transaction Information</div>
    <table class="data-table">
        <tr>
            <th>Description</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Payment Method</td>
            <td>{{ ucfirst($paymentMailData['payment_mode']) }}</td>
        </tr>
        <tr>
            <td>Payment Status</td>
            <td>{{ $paymentMailData['payment_status'] ?? 'Successful' }}</td>
        </tr>
        <tr>
            <td>Currency</td>
            <td>INR</td>
        </tr>
    </table>

    <!-- NOTES -->
    <div class="notes">
        <strong>Notes:</strong><br>
        {{ $paymentMailData['notes']
            ?? 'Thank you for your payment. This receipt confirms successful payment for the internship fee.' }}
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="seal">
            <img src="{{ $company->digital_signature }}" alt="Seal">
        </div>
        <div class="authorized">
            Authorized By<br>
            {{ $company->company_name }}
        </div>
    </div>

</div>

</body>
</html>
