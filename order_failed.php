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
    <title>Order Failed</title>
    <style>
        body {
            background-color: #FFF5E4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .error-container {
            max-width: 600px;
            margin: 80px auto;
            padding: 40px 20px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .error-icon {
            font-size: 80px;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .error-title {
            color: #dc3545;
            font-size: 1.5rem;
            margin: 15px 0;
            font-weight: 600;
        }

        .error-message {
            color: #666;
            line-height: 1.6;
            margin: 20px 0;
        }

        .error-code {
            background-color: #f8f9fa;
            padding: 8px 16px;
            border-radius: 6px;
            font-family: monospace;
            color: #dc3545;
            display: inline-block;
            margin: 10px 0;
        }

        .btn-return {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            background-color: #dc3545;
            color: white;
            border: none;
            margin-top: 20px;
        }

        .btn-return:hover {
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
    
    <div class="error-container">
        <i class="bi bi-exclamation-circle error-icon"></i>
        <h2 class="error-title">Order Failed</h2>
        <?php
            if(isset($_GET["err"])){
                $error_code = $_GET["err"];
                $err_type = 1;
                $display_msg =  "Error Code: {$error_code}";
            }else if(isset($_GET["pmt_err"])){
                $err_type = 2;
                $display_msg = "Message: ".ucfirst($_GET["pmt_err"]);
            }
        ?>
        <p class="error-message">
            <?php 
                echo "An unexpected error occurred in our system.";
                
            ?>
        </p>
        
        <a href="index.php" class="btn-return">Return to Home</a>
    </div>

    <div class="navbar fixed-bottom navbar-expand-lg text-center p-2 mb-0" style="background-color: #CD5C08; color: #FFF5E4">
  <div class="container-fluid justify-content-center">
   
        <p> CEC </p>
        </div>
        
  </div>
</body>
</html>