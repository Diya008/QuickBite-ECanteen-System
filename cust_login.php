<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("conn_db.php"); include('head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="css/login.css" rel="stylesheet">
    <style>
    i:hover{
        color:#CD5C08;
    }
</style>
    <title>Log in </title>
</head>

<body class="d-flex flex-column h-100" style="background-color: #FFF5E4">
<?php include('nav_header.php')?>
<br>

    <div class="container form-signin mt-auto" style="background-color: #FFF5E4">
        <form method="POST" action="check_login.php" class="form-floating">
        <div style="background-color: #F1F1E6; width: 110%; margin: 0 auto; padding: 20px; border-radius: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i ></i>Log In</h2>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pwd" required>
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn mb-3" style="background-color: #CD5C08; color: #FFF5E4" type="submit">Log In</button>
            <a class="nav nav-item text-decoration-none text-muted mb-2 small" href="cust_forgot_pwd.php">
                <i class="bi  me-2" ></i>Forgot password?
            </a>
            <a class="nav nav-item text-decoration-none text-muted mb-2 small" href="cust_regist.php">
                <i class="bi  me-2"></i>Register
            </a>
            <a class="nav nav-item text-decoration-none text-muted mb-2 small" href="shop/shop_login.php">
                <i class="bi  me-2"></i>Canteen / Mess Log In
            </a>
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