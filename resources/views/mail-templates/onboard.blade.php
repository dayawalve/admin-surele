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
                    <h1>🎉 Welcome to {{ $company->company_name ?? 'Surele' }}</h1>
                </td>
            </tr>

            <!-- CONTENT -->
            <tr>
                <td class="content">

                    <p>
                        Hello <strong>{{ $student->name }}</strong>,
                    </p>

                    <p>
                        You have been successfully <span class="highlight">onboarded</span> to the system.
                    </p>

                    <!-- Login Details -->
                    <div class="details" style="margin-top:25px;">
                        <h3 style="margin:0 0 10px; color:#640da3;">
                            🔐 Login Details
                        </h3>

                        <p><strong>Email:</strong> {{ $student->email }}</p>
                        <p><strong>Password:</strong> {{ $plainPassword }}</p>
                    </div>

                    <p style="margin-top:22px;">
                        Regards,<br>
                        <strong style="color:#640da3;">
                            {{ $company->company_name ?? 'Surele' }}
                        </strong><br>
                        <span style="color:#777777;">Team</span>
                    </p>

                </td>
            </tr>

            <!-- FOOTER -->
            <tr>
                <td class="footer">
                    © {{ date('Y') }} {{ $company->company_name ?? 'Surele' }}. All rights reserved.
                </td>
            </tr>

        </table>
    </div>

</body>

</html>
