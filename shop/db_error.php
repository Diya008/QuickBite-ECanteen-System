<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../head.php'); ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/login.css" rel="stylesheet">

    <title>Database Error </title>
</head>

<body class="d-flex flex-column h-100">
    <header class="navbar navbar-expand-md navbar-light fixed-top bg-light shadow-sm mb-auto">
        <div class="container-fluid mx-4">
            <a href="../index.php">
                <img src="../img/logo.png" width="75" class="me-2" alt="">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarCollapse">
                <div class="d-flex text-end"></div>
            </div>
        </div>
    </header>
    <div class="mt-5"></div>
    <div class="container form-signin text-center restricted mt-auto">
            <i class="mt-4 bi bi-hdd-network-fill text-danger h1 display-2"></i>
            <h3 class="mt-2 mb-3 fw-normal text-bold">Connection Error</h3>
        
            <a class="btn btn-danger btn-sm w-50" href="../index.php">Try again.</a>
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