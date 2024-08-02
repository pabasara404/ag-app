<!DOCTYPE html>
<html>
<head>
    <title>Set Your Password</title>
</head>
<body>
<h1>Hello, {{ $user->name }}</h1>
<p>You have been added to our system. Please set your password by clicking the link below:</p>
<a href="{{ url('/password/reset/' . $token) }}">Set Password</a>
<p>Thank you!</p>
</body>
</html>
