<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            padding: 20px 0;
        }
        .verification-code {
            font-size: 28px;
            letter-spacing: 4px;
            text-align: center;
            font-weight: bold;
            color: #4A6CF7;
            padding: 20px;
            margin: 20px 0;
            background-color: #f5f7ff;
            border-radius: 6px;
        }
        .instructions {
            margin: 20px 0;
            line-height: 1.6;
        }
        .footer {
            font-size: 12px;
            text-align: center;
            padding-top: 20px;
            color: #888;
            border-top: 1px solid #f0f0f0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 20px 0;
            background-color: #4A6CF7;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ajira</h1>
        </div>
        <div class="content">
            <h2>Verify Your Email Address</h2>
            
            <p>Hi {{ $user->name }},</p>
            
            <div class="instructions">
                <p>Thank you for signing up for Ajira. Please use the verification code below to complete your registration:</p>
            </div>
            
            <div class="verification-code">
                {{ $code }}
            </div>
            
            <div class="instructions">
                <p>This verification code will expire in 24 hours.</p>
                <p>If you did not create an account, no further action is required.</p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Ajira. All rights reserved.</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>
</html> 