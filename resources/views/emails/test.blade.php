<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4338ca;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $subject }}</h2>
    </div>
    
    <div class="content">
        {!! nl2br(e($content)) !!}
    </div>
    
    <div class="footer">
        <p>This is a test email from Ajira Global.</p>
        <p>Sent from: {{ config('mail.from.address') }}</p>
    </div>
</body>
</html> 