<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DataForSEO Balance Alert</title>
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
            background-color: #fef2f2;
            border-left: 4px solid #640da3;
            padding: 15px;
            margin: 20px 0;
        }
        .details-box p {
            margin: 6px 0;
            font-size: 14px;
        }
        .footer {
            background-color: #f9fafb;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-card">
            <div class="header">
                <h1>DataForSEO Balance Alert</h1>
            </div>
            <div class="content">
                <p>Hello Sumit,</p>
                <p>This is an automated notification to alert you that the available credits on your <span class="highlight">DataForSEO</span> account have dropped below the threshold of <strong>$5.00</strong>.</p>
                
                <div class="details-box">
                    <p><strong>Current Balance:</strong> ${{ number_format($balance, 4) }}</p>
                    <p><strong>Account:</strong> {{ $login }}</p>
                    <p><strong>Status:</strong> Low Balance</p>
                </div>

                <p>Please recharge your account balance in the DataForSEO dashboard to ensure uninterrupted services.</p>
            </div>
            <div class="footer">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
