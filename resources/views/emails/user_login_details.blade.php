<!DOCTYPE html>
<html>
<head>
    <title>User Login Details</title>
</head>
<body>
    <h1>Hello {{ $name }},</h1>
    <p>Thank you for registering. Here are your login details:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please change your password after logging in.</p>
</body>
</html>
