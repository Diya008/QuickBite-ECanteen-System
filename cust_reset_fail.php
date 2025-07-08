<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start(); 
    include("conn_db.php"); 
    include('head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/login.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .error-container {
            max-width: 500px;
            margin: 3rem auto;
            padding: 2.5rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .error-icon {
            color: #CD5C08;
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .error-title {
            color: #333;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .error-message {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .error-code {
            background-color: #f8f9fa;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            border-left: 4px solid #CD5C08;
            color: #666;
            font-family: monospace;
            margin: 1.5rem 0;
            display: inline-block;
        }

        .btn-return {
            background-color: #CD5C08;
            border-color: #CD5C08;
            color: #FFF5E4;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-return:hover {
            background-color: #B54F07;
            border-color: #B54F07;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(205, 92, 8, 0.2);
        }

        footer {
            margin-top: auto;
            background-color: #CD5C08;
            color: #FFF5E4;
            padding: 1rem 0;
        }

        footer p {
            margin: 0;
        }
    </style>
    <title>Reset Password Failed</title>
</head>

<body>
    <?php include('nav_header.php')?>

    <div class="container">
        <div class="error-container">
            <i class="bi bi-exclamation-triangle-fill error-icon"></i>
            
            <h3 class="error-title">
                Unable to Reset Your Password
            </h3>
            
            <p class="error-message">
                We encountered an error while trying to reset your password.<br>
                Please try again or contact support if the problem persists.
            </p>

            

            <a class="btn btn-return" href="index.php">
                Return to Home
            </a>
        </div>
    </div>

    <footer class="text-center">
        <div class="container">
            <p>CEC</p>
        </div>
    </footer>
</body>
</html>