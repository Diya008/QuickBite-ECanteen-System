<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>
    <style>
        body {
            background-color: #FFF5E4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .error-container {
            max-width: 500px;
            margin: 80px auto;
            padding: 40px 20px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .error-icon {
            font-size: 64px;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .error-title {
            color: #dc3545;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .error-message {
            color: #666;
            line-height: 1.6;
            margin: 20px 0;
        }

        .btn-retry {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            background-color: #dc3545;
            color: white;
            border: none;
            width: 200px;
        }

        .btn-retry:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #c82333;
        }

        footer {
            background-color: #CD5C08;
            color: #FFF5E4;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .error-container {
                margin: 40px 20px;
            }
        }
    </style>
</head>

<body>
    <?php include('nav_header.php')?>
    <br><br>
    
    <div class="error-container">
        <i class="bi bi-database-x error-icon"></i>
        <h2 class="error-title">Database Connection Error</h2>
        <p class="error-message">
            We're having trouble connecting to our database.<br>
            Please try again in a few moments.
        </p>
        <a href="index.php" class="btn-retry">
            <i class="bi bi-arrow-clockwise me-2"></i>
            Try Again
        </a>
    </div>

    <div class="navbar fixed-bottom navbar-expand-lg text-center p-2 mb-0" style="background-color: #CD5C08; color: #FFF5E4">
  <div class="container-fluid justify-content-center">
   
        <p> CEC </p>
        </div>
        
  </div>
</body>
</html>