<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); include("conn_db.php"); include('head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Successfully Registered</title>
    <style>
        :root {
            --primary-color: #CD5C08;
            --bg-color: #FFF5E4;
            --success-color: #28a745;
            --text-color: #333;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-container {
            display: flex;
            align-items: center;
            padding: 0 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
            font-family: Verdana, sans-serif;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .success-container {
            max-width: 500px;
            margin: auto;
            padding: 2rem;
            text-align: center;
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin-top: 8rem;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            color: var(--success-color);
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .success-title {
            color: var(--text-color);
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .success-message {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .home-button {
            background-color: var(--success-color);
            color: white;
            text-decoration: none;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-weight: 500;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: inline-block;
            border: none;
        }

        .home-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
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

        .logo {
            height: 75px;
            width: auto;
            transition: transform 0.2s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="navbar-container">
            <a href="index.php">
                <img src="img/logo.png" alt="Logo" class="logo">
            </a>
            <nav>
                <a class="nav-link" href="index.php">Home</a>
            </nav>
        </div>
    </header>

    <div class="success-container">
        <i class="bi bi-check-circle success-icon"></i>
        <h3 class="success-title">Your account is ready!</h3>
        <p class="success-message">Welcome and enjoy your food with QuickBite</p>
        <a class="home-button" href="index.php">Return to Home</a>
    </div>

    <footer>
        <p>CEC</p>
    </footer>
</body>
</html>