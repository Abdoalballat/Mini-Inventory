<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your OTP Code</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f5; padding: 20px;">
    <div style="max-width: 500px; margin: auto; background: #ffffff; padding: 30px; border-radius: 12px;">
        <h2 style="color: #18181b; text-align: center;">NiceShop</h2>
        <p style="color: #555;">Hello,</p>
        <p style="color: #555;">Use the following verification code to reset your password:</p>
        <div style="text-align: center; margin: 25px 0;">
            <span style="font-size: 28px; font-weight: bold; letter-spacing: 5px; color: #18181b; background: #f4f4f5; padding: 10px 20px; border-radius: 8px; display: inline-block;">
                {{ $otp }}
            </span>
        </div>
        <p style="color: #777; font-size: 13px;">This code will expire in 5 minutes. If you did not request this, please ignore this email.</p>
    </div>
</body>
</html>