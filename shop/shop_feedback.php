<?php
session_start();
include('../conn_db.php');


// Debugging - show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['sid'])) {
    die("No session found. Please login.");
}

$shop_id = $_SESSION['sid'];

// Detailed query to diagnose
$debug_query = "SELECT * FROM feedback WHERE s_id = '$shop_id'";
$result = $mysqli->query($debug_query);

if (!$result) {
    die("Query failed: " . $mysqli->error);
}

echo "Total rows found: " . $result->num_rows . "<br>";

// Display raw data for diagnostics
//while ($row = $result->fetch_assoc()) {
  //  print_r($row);
    //echo "<hr>";

//}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    error_reporting(0); // Turn off error reporting
    ini_set('display_errors', 0); // Do not display errors
        session_start(); 
        if($_SESSION["utype"]!="shopowner"){
            header("location: ../restricted.php");
            exit(1);
        }
        include("../conn_db.php"); 
        include('../head.php');
        $s_id = $_SESSION["sid"];
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <title>Shop Owner Home </title>
</head>

<body class="d-flex flex-column h-100" style="background-color: #FFF5E4">
    <?php include('nav_header_shop.php'); ?>
    <div class="container mt-5">
        <h2 class="mb-4"><?php 
            echo ($s_id == 1) ? 'Canteen' : 'Mess'; 
        ?> Feedback</h2>
        
        <ul class="">
            
                <h3>Feedback Message</h3>
                    
                
            
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?><div class="" style="padding: 20px; background-color: #ffffe6; text-align: center"><?php
                        
                        echo "" . htmlspecialchars($row['feedback']) . "";
                      ?></div>
                      </br><?php
                        
                    }
                } else {
                    echo "<p>No feedback received yet.</p>";
                }
                ?>
            
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