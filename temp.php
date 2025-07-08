<?php
include 'conn_db.php'; // Replace with your actual connection file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentQuantity=$_POST['$currentQuantity'];
    echo $currentQuantity;
}
?>
