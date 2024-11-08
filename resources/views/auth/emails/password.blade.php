<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            font-size: 16px;
            color: #333333;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #999999;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        <p>You requested a password reset for your account. Click the button below to reset your password:</p>
        <p>
            <a href="{{ $resetUrl }}" class="button">Reset Password</a>
        </p>
        <p>If you did not request this, please ignore this email. The link will expire in {{ config('auth.passwords.users.expire') }} minutes.</p>
    </div>
    <div class="footer">
        <p>Thank you for using our service!</p>
    </div>
</div>

</body>
</html>
