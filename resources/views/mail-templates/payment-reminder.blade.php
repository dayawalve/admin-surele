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
        <table class="main" align="center">

            <!-- HEADER -->
            <tr>
                <td class="header">
                    <h1>⏰ Payment Reminder</h1>
                </td>
            </tr>

            <!-- CONTENT -->
            <tr>
                <td class="content">

                    <p>Hello <strong>{{ $reminderData['student_name'] }}</strong>,</p>

                    <p>
                        This is a gentle reminder regarding the pending fees for your
                        enrolled training program.
                    </p>

                    <div class="amount-box">
                        <h2>₹{{ number_format($reminderData['pending']) }}</h2>
                        <p>Pending Amount</p>
                    </div>

                    <div class="summary">
                        <p><strong>Program:</strong> {{ $reminderData['program'] }}</p>
                        <p><strong>Total Fees:</strong> ₹{{ number_format($reminderData['total_fees']) }}</p>
                        <p><strong>Amount Paid:</strong> ₹{{ number_format($reminderData['paid']) }}</p>
                        <p><strong>Due Date:</strong> {{ $reminderData['due_date'] }}</p>
                    </div>

                    <p>
                        Kindly complete the payment at the earliest to avoid any
                        interruption in your training.
                    </p>

                    {{-- <div class="cta">
                        <a href="{{ url('/') }}">Make Payment</a>
                    </div> --}}

                    <p>
                        If you have already completed the payment, please ignore this message.
                    </p>

                    <p>
                        Regards,<br>
                        <strong style="color:#640da3;">Surele</strong><br>
                        Accounts Team
                    </p>

                </td>
            </tr>

            <!-- FOOTER -->
            <tr>
                <td class="footer">
                    © {{ date('Y') }} Surele. All rights reserved.
                </td>
            </tr>

        </table>


    </div>

</body>

</html>
