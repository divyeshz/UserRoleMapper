<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Access Denied - 403 Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
            color: #f44336;
        }

        p {
            color: #555;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #2196f3;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0e81ce;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Access Denied - 403 Error</h1>
        <p>Oops! You don't have permission to access this page.</p>
        <p><button onclick="window.history.go(-1);" class="back-button">Go Back</button> </p>
    </div>
</body>

</html>
