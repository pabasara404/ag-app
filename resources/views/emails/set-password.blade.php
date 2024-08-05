<!DOCTYPE html>
<html>
<head>
    <title>Set Up Your Account Password</title>
</head>
<body>
<h1>Hello, {{ $user->name }}</h1>
<p>Welcome to AG Office Demanhandiya!<br><br>

    We are pleased to inform you that your account has been created. To access your new account, please set up your password by following the instructions below:<br>
<ol><li>Click the link to set your password:
        <a href="{{ url('/password/reset/' . $token) }}">Set Password</a></li>
<li>After Setting up your password you will be able to Log in to the system using your Email and Password.</li></ol>

<p>If you encounter any issues or have any questions, please feel free to reach out to our support team at <a href="mailto:support@agofficedemanhandiya.com">support@agofficedemanhandiya.com</a><br>

    We look forward to having you on board!</p>


    Best regards,<br>
    AG Office Demanhandiya
</body>
</html>
