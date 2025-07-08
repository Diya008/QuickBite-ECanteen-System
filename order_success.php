<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        session_start(); 
        include("conn_db.php");
        
        if(!isset($_SESSION["cid"]) || !isset($_GET["orh"])){
            header("location: restricted.php");
            exit(1);
        }
        include('head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
    <style>
        body {
            background-color: #FFF5E4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .success-container {
            max-width: 600px;
            margin: 80px auto;
            padding: 40px 20px; 
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .order-number {
            color: #CD5C08;
            font-size: 1.2rem;
            margin: 15px 0;
        }

        .message {
            color: #666;
            line-height: 1.6;
            margin: 20px 0;
        }

        .btn-container {
            margin: 30px 0;
            gap: 15px;
            display: flex;
            justify-content: center;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-home {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-history {
            background-color: #CD5C08;
            color: white;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            .success-container {
                margin: 40px 20px;
            }
        }
    </style>
</head>

<body>
    <?php include('nav_header.php')?>
    
    <div class="success-container">
        <i class="bi bi-cart-check success-icon"></i>
        <h2>Order Successful!</h2>
        <?php 
            $orh_id = $_GET["orh"];
            $orh_query = "SELECT orh_refcode FROM order_header WHERE orh_id = {$orh_id} LIMIT 0,1;";
            $orh_arr = $mysqli -> query($orh_query) -> fetch_array();
            $orh_refcode = $orh_arr["orh_refcode"];
        ?>
        <div class="order-number">
            Order #<?php echo $orh_refcode;?>
        </div>
        <p class="message">
            Thank you for your order! We've notified the shop and they'll start preparing your items soon.<br>
            You can track your order status in the order history menu.
        </p>
        <div class="btn-container">
            <a href="index.php" class="btn btn-home">Return Home</a>
            <a href="cust_order_history.php" class="btn btn-history">View Order History</a>
        </div>
    </div>

    <div class="navbar fixed-bottom navbar-expand-lg text-center p-2 mb-0" style="background-color: #CD5C08; color: #FFF5E4">
  <div class="container-fluid justify-content-center">
   
        <p> CEC </p>
        </div>
        
  </div>
</body>
</html>