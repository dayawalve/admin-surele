<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Internship Selection Letter</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            font-size: 13px;
        }

        .container {
            width: 700px;
            margin: 0 auto;
            padding: 30px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: top;
        }

        .logo img {
            width: 90px;
        }

        .company-info {
            text-align: right;
            line-height: 1.5;
            font-size: 12.5px;
        }

        .company-info .contact {
            color: #640da3;
            font-weight: bold;
        }

        .date {
            text-align: right;
            margin-top: 25px;
            font-size: 12.5px;
        }

        .content {
            margin-top: 30px;
            line-height: 1.8;
        }

        .signature {
            margin-top: 35px;
        }

        .signature img {
            width: 90px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td class="logo">
                <img src="{{ $offerMailData['company_logo'] }}" alt="{{ $offerMailData['company_name'] }}">
            </td>
            <td class="company-info">
                {!! $offerMailData['company_address1'] !!}
                {{ $offerMailData['company_city'] }} - {{ $offerMailData['company_pincode'] }}<br>
                <span class="contact">Contact No.</span>
                <strong> {{ $offerMailData['company_phone'] }}</strong>
            </td>
        </tr>
    </table>

    <!-- DATE -->
    <div class="date">
        Date: {{ $offerMailData['date'] }}
    </div>

    <!-- CONTENT -->
    <div class="content">
        Dear <strong>{{ $offerMailData['student_name'] }}</strong>,<br><br>

        We are pleased to inform you that you have been selected for a
        <strong>{{ $offerMailData['program_name'] }}</strong> Internship Program at
        <strong>{{ $offerMailData['company_name'] }}</strong>, commencing from
        <strong>{{ $offerMailData['start_date'] }}</strong>.<br><br>

        We wish you a productive and enriching learning experience with
        {{ $offerMailData['company_name'] }}.
    </div>

    <!-- SIGNATURE -->
    <div class="signature">
        <strong>Best Regards,</strong><br><br>

        <strong>Authorized By:</strong><br>
        <img src="{{ $offerMailData['company_seal'] }}" alt="Seal"><br>
        <strong>{{ $offerMailData['company_name'] }}</strong>
    </div>

</div>

</body>
</html>
