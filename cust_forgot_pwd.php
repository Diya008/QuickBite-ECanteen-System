<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("conn_db.php"); include('head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/login.css" rel="stylesheet">
    <title>Forgot Password </title>
</head>

<body class="d-flex flex-column h-100" style="background-color: #FFF5E4">
<?php include('nav_header.php')?>

    <div class="container form-signin mt-auto">
        
        <form method="POST" action="cust_reset_pwd.php" class="form-floating">
        <div style="background-color: #F1F1E6; width: 110%; margin: 0 auto; padding: 20px; border-radius: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi me-2"></i>Forgot Password?</h2>
            <!--<p class="mt-4 mb-3 fw-normal">Enter your information below.</p>-->
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="fp_username" placeholder="Username" name="fp_username" required>
                <label for="fp_username">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="fp_email" placeholder="Email" name="fp_email" required>
                <label for="fp_email">Email</label>
            </div>
            <button class="w-100 btn mb-3" style="background-color: #CD5C08; color: #FFF5E4" type="submit">Next</button>
            </div>
        </form>
    </div>

    <footer class="text-center text-white">
  <!-- Copyright -->
  <div class="navbar fixed-bottom navbar-expand-lg text-center p-2 mb-0" style="background-color: #CD5C08; color: #FFF5E4">
  <div class="container-fluid justify-content-center">
    
        <p> CEC </p>
        </div>
        
  </div>
  <!-- Copyright -->
</footer>
</body>

</html>