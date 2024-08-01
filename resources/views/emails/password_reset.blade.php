<!-- resources/views/emails/password_reset.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <p>Hello {{ $name }},</p>
    <p>Welcome to our platform! To complete your registration, please reset your password using the link below:</p>
    <p><a href="{{ $resetUrl }}">Reset Password</a></p>
    <p>Thank you!</p>
</body>
</html>
