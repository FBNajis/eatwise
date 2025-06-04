<!DOCTYPE html>
<html>
<head>
    <title>eatwise</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
</head>
<body>
    <h2>Reset Password Request</h2>
    <p>Hello,</p>
    <p>You have requested to reset your password. Use the OTP code below to proceed:</p>
    
    <h1 style="letter-spacing: 2px;">{{ $otp }}</h1>

    <p>This OTP is valid for a limited time. Please do not share it with anyone.</p>
    
    <br>
    <p>Thank you,<br>
    eatwise Team</p>
</body>
</html>
