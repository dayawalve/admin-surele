<!DOCTYPE html>
<html lang="en">
@php
    $company = DB::table('company_settings')->first();
@endphp

<head>
    <meta charset="UTF-8">
    <title>Invitation to Join {{ $company->company_name ?? 'Surele' }} Industrial Program</title>

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
                    <h1>🎓 Training Program Invitation</h1>
                </td>
            </tr>

            <!-- CONTENT -->
            <tr>
                <td class="content">

                    <p>
                        Hello <strong>{{ $student->name }}</strong>,
                    </p>

                    <p>
                        Greetings from <span class="highlight">{{ $company->company_name }}</span>!
                    </p>

                    @if ($student->job_assurance)
                        <p>
                            We would like to invite you to join our
                            <strong>{{ $company->company_name ?? 'Surele' }} Industrial Program</strong> in
                            <strong>{{ $student->preferred_technology ?? 'IT Technologies' }}</strong>,
                            designed with real-time projects, expert mentorship, and
                            <span class="highlight">placement & career support</span> to help you start your IT career.
                        </p>
                    @else
                        <p>
                            We would like to invite you to join our
                            <strong>{{ $company->company_name ?? 'Surele' }} Industrial Program</strong> in
                            <strong>{{ $student->preferred_technology ?? 'IT Technologies' }}</strong>,
                            focused on <span class="highlight">practical training and real-time industry projects</span>
                            to build strong technical skills.
                        </p>
                    @endif

                    <div class="details-box">
                        <p>✔ Hands-on real-time projects</p>
                        <p>✔ Industry-experienced trainers</p>
                        <p>✔ Career guidance and mentorship</p>
                        @if (strtolower($student->job_assurance) === 'yes')
                            <p>✔ Placement assistance</p>
                        @endif
                    </div>

                    <p>
                        Our admissions team will contact you shortly to share batch details and guide you through the
                        next steps.
                    </p>

                    <div class="cta">
                        <a href="{{ $company->company_website }}">Visit {{ $company->company_name }}</a>
                    </div>

                    <p>
                        If you have any questions, feel free to contact us at
                        <a href="mailto:{{ $company->company_email ?? 'contact@surele.in' }}" style="color:#640da3; text-decoration:none;">
                            {{ $company->company_email ?? 'contact@surele.in' }}
                        </a>
                        — we’ll be happy to assist you.
                    </p>

                    <p style="margin-top:22px;">
                        Warm regards,<br>
                        <strong style="color:#640da3;">{{ $company->company_name }}</strong><br>
                        <span style="color:#777777;">Training & Career Support Team</span>
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
