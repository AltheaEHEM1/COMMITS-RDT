<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ env('APP_NAME') }} </title>
</head>
<body>
    <h1>Welcome, {{ ucwords($firstName) }}!</h1>
    <p>Your account have been successfully registered. Below are your login credentials:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please change your password after logging in for better security.</p>
    <p>Best regards,<br> {{ env('APP_NAME') }} Team</p>
</body>
</html>