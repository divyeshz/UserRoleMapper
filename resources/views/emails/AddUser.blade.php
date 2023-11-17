<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to User Role Mapper!</title>
    <style>
        /* Add some styling to your email */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to User Role Mapper!</h1>
        <p>Hello {{ $data['fname'] }} {{ $data['lname'] }},</p>
        <p>Welcome to User Role Mapper! We've created a temporary password for you to get started.</p>
        <p>Your temporary password: <strong>{{ $data['password'] }}</strong></p>
        <p>Please log in using the temporary password and then change it to something secure.</p>
        <p>
            <a href="{{ route('loginForm') }}" class="button">Login Here</a>
        </p>
        <p>Best regards,<br> Zignuts</p>
    </div>
</body>

</html>
