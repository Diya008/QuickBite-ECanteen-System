<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("../conn_db.php"); include('../head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/login.css" rel="stylesheet">

    <title>Canteen / Mess Log In</title>
</head>

<body class="d-flex flex-column h-100" style="background-color: #FFF5E4">
<header class="navbar navbar-expand-md navbar-contrast fixed-top shadow-sm mb-auto" style="background-color: #FFF5E4;">
    <div class="container-fluid mx-3">
        <a href="../index.php">
            <img src="../img/logo.png" width="75" class="me-2" >
        </a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link px-2 text-dark" href="../index.php" style="font-family: Verdana, sans-serif;">Home</a>
                </li>
                
                <?php if(isset($_SESSION['cid'])){ ?>
                    <li class="nav-item">
                    <a href="shop_list.php" class="nav-link px-2 text-dark font-weight-bold">Shop List</a>
                </li>
                
                <?php } ?>
            </ul>
            <div class="d-flex">
                <?php if(!isset($_SESSION['cid'])){ ?>
               
                <?php }else{ ?>


                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a type="button" class="btn " style="background-color: #FFF5E4" href="cust_cart.php">
                        <img src="img/cart.png" width="25" class="me-2" >
                            <?php
                                $incart_query = "SELECT SUM(ct_amount) AS incart_amt FROM cart WHERE c_id = {$_SESSION['cid']}";
                                $incart_result = $mysqli -> query($incart_query) -> fetch_array(); 
                                $incart_amt = $incart_result["incart_amt"];
                                if($incart_amt>0){
                            ?>
                            <span class="ms-1 ">
                                <?php echo $incart_amt;?>
                            </span>
                            <?php }else{ ?>
                                <span class="ms-1 ">0</span>
                            <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cust_profile.php" class="nav-link px-2 text-dark">
                            Welcome, <?=$_SESSION['firstname']?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="mx-2 mt-1 mt-md-0 btn " style="background-color: #CD5C08; color: white " href="logout.php">Log Out</a>
                    </li>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</header>
    
    <div class="container form-signin">
        <form method="POST" action="check_shop_login.php" class="form-floating">
        <div style="background-color: #F1F1E6; width: 115%; margin: 0 auto; padding: 17px; border-radius: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi  me-2"></i>Canteen / Mess Log In</h2>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pwd">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn  mb-3" style="background-color: #CD5C08" type="submit">Log In</button>
            </div>
        </form>
    </div>

    <footer class="text-center text-white">
  <!-- Copyright -->
  <div class="text-center p-2 p-2 mb-1 " style="background-color: #CD5C08; color: #FFF5E4">
  
        <p> CEC </p>
  </div>
  <!-- Copyright -->
</footer>
</body>

</html>