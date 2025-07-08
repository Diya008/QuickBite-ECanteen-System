<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("conn_db.php"); include('head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/login.css" rel="stylesheet">
    <title>Restricted Access</title>
    <style>
        .restricted-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #FFF5E4;
        }

        .header-logo {
            transition: transform 0.3s ease;
        }

        .header-logo:hover {
            transform: scale(1.05);
        }

        .error-card {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            animation: slideIn 0.5s ease-out;
        }

        .error-icon {
            font-size: 5rem;
            color: #CD5C08;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        .error-title {
            color: #2C3639;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .error-message {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .home-button {
            background-color: #CD5C08;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            font-size: 1.1rem;
        }

        .home-button:hover {
            background-color: #B54404;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(205, 92, 8, 0.2);
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .custom-footer {
            background-color: #CD5C08;
            color: #FFF5E4;
            padding: 1rem;
            margin-top: auto;
            text-align: center;
        }

        .custom-footer p {
            margin: 0;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div class="restricted-container">
        <!-- Header -->
        <?php include('nav_header.php')?>

        <!-- Main Content -->
        <main class="container my-auto py-5">
            <div class="error-card text-center">
                <div class="error-icon">
                    <i class="bi bi-exclamation-octagon-fill"></i>
                </div>
                <h3 class="error-title">Restricted Access</h3>
                <p class="error-message">You don't have permission to access this page</p>
                <a href="index.php" class="home-button">
                    Return to Home
                </a>
            </div>
        </main>

        <!-- Footer -->
        <div class="navbar fixed-bottom navbar-expand-lg text-center p-2 mb-0" style="background-color: #CD5C08; color: #FFF5E4">
  <div class="container-fluid justify-content-center">
   
        <p> CEC </p>
        </div>
        
  </div>
    </div>
</body>

</html>