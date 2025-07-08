<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); include("conn_db.php"); include('head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Failed</title>
    <style>
        :root {
            --primary-color: #CD5C08;
            --bg-color: #FFF5E4;
            --card-bg: #F1F1E6;
            --danger-color: #dc3545;
            --success-color: #6A9C89;
            --nav-btn-color: #C1D8C3;
            --text-color: #333;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: var(--bg-color);
            padding: 1rem 0;
            box-shadow: var(--shadow);
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .btn {
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-login {
            background-color: var(--nav-btn-color);
        }

        .btn-signup {
            background-color: var(--success-color);
            color: white;
        }

        .btn-logout {
            background-color: var(--primary-color);
            color: white;
        }

        .error-container {
            background-color: var(--card-bg);
            max-width: 500px;
            margin: 6rem auto 2rem;
            padding: 2.5rem;
            border-radius: 25px;
            box-shadow: var(--shadow);
            text-align: center;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-icon {
            color: var(--danger-color);
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: shake 0.5s ease-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .error-title {
            color: var(--text-color);
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .error-message {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.5;
        }

        .cart-button {
            background-color: var(--bg-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            display: flex;
            align-items: center;
            transition: transform 0.2s ease;
        }

        .cart-button:hover {
            transform: scale(1.05);
        }

        .cart-count {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.9rem;
        }

        footer {
            background-color: var(--primary-color);
            color: var(--bg-color);
            padding: 1rem;
            margin-top: auto;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 1rem;
        }

        .error-code {
            background-color: rgba(220, 53, 69, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-family: monospace;
            color: var(--danger-color);
            margin: 1rem 0;
            display: inline-block;
        }

        .home-button {
            background-color: var(--danger-color);
            color: white;
            padding: 0.8rem 2rem;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
            width: 50%;
        }

        .home-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <?php include('nav_header.php')?>

    <div class="error-container">
        <i class="bi bi-x-circle error-icon"></i>
        <h3 class="error-title">Unable to Register</h3>
        <p class="error-message">
            Sorry, we have encountered an error.<br/>
            
        </p>
        <a class="btn home-button" href="index.php">Return to Home</a>
    </div>

    <footer>
        <p>CEC</p>
    </footer>
</body>
</html>