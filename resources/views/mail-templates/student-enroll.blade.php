<!DOCTYPE html>

<html lang="en">
@php
    $company = DB::table('company_settings')->first();
@endphp
<head>
    <meta charset="UTF-8">
    <title>Student Enrollment Confirmation</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 100%;
            padding: 20px 0;
            background-color: #f4f4f4;
        }

        .email-card {
            width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .header {
            background-color: #640da3;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 24px;
        }

        .content {
            padding: 30px;
            color: #333333;
        }

        .content p {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .highlight {
            color: #640da3;
            font-weight: bold;
        }

        .details-box {
            background-color: #f8f5fc;
            border-left: 4px solid #640da3;
            padding: 15px;
            margin: 20px 0;
        }

        .details-box p {
            margin: 6px 0;
            font-size: 14px;
        }

        .cta {
            text-align: center;
            margin: 30px 0;
        }

        .cta a {
            background-color: #640da3;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 26px;
            border-radius: 4px;
            font-size: 15px;
            display: inline-block;
        }

        .footer {
            background-color: #f1eafa;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #666666;
        }

        @media (max-width: 620px) {
            .email-card {
                width: 95%;
            }
        }
    </style>


</head>

<body>

    <div class="wrapper">

        <table class="main" align="center" cellpadding="0" cellspacing="0">

            <!-- HEADER -->
            <tr>
                <td class="header">
                    <h1>🎓 Enrollment Successful</h1>
                </td>
            </tr>

            <!-- CONTENT -->
            <tr>
                <td class="content">

                    <p>
                        Hello <strong>{{ $student->fname }} {{ $student->lname }}</strong>,
                    </p>

                    <p>
                        Congratulations! 🎉
                        Your enrollment has been
                        <span class="highlight">successfully done</span>.
                    </p>

                    <div class="details">
                        <p><strong>Name:</strong> {{ $student->fname }} {{ $student->lname }}</p>
                        <p><strong>Email:</strong> {{ $student->email }}</p>
                        <p><strong>Phone:</strong> {{ $student->phone }}</p>
                        <p><strong>Enrollment Type:</strong> {{ ucfirst($student->enrollment_type) }}</p>
                    </div>

                    @if(!empty($paymentData))
                        <div class="details" style="margin-top:25px;">
                            <h3 style="margin:0 0 10px; color:#640da3;">
                                💳 Payment Details
                            </h3>

                            <p><strong>Amount Paid:</strong> ₹{{ number_format($paymentData['amount']) }}</p>
                            <p><strong>Payment Mode:</strong> {{ ucfirst($paymentData['mode']) }}</p>
                            <p><strong>Payment Date:</strong> {{ $paymentData['date'] }}</p>
                        </div>
                    @endif

                    <p>
                        Our team will soon connect with you to guide you through your
                        training journey and share the next steps.
                    </p>

                    <div class="cta">
                        <a href="{{ $company->company_website }}">Explore Our Platform</a>
                    </div>

                    <p>
                        If you have any questions, simply reply to this email — we’re happy to help.
                    </p>

                    <p style="margin-top:22px;">
                        Warm regards,<br>
                        <strong style="color:#640da3;">{{ $company->company_name }}</strong><br>
                        <span style="color:#777777;">Training & Development Team</span>
                    </p>

                </td>
            </tr>

            <!-- FOOTER -->
            <tr>
                <td class="footer">
                    © {{ date('Y') }} {{ $company->company_name }}. All rights reserved.
                </td>
            </tr>

        </table>

    </div>

</body>

</html>
