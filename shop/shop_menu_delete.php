<?php
session_start();

// Check if the user is a shop owner
if (!isset($_SESSION["utype"]) || $_SESSION["utype"] != "shopowner") {
    header("location: ../restricted.php");
    exit();
}

// Include database connection
include('../conn_db.php');

// Check if the connection is successful
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Validate the f_id parameter from GET
if (!isset($_GET["f_id"]) || !filter_var($_GET["f_id"], FILTER_VALIDATE_INT)) {
    header("location: shop_menu_list.php?dsb_fdt=0");
    exit();
}

$f_id = $_GET["f_id"];

// Prepare the DELETE query
$delete_query = "DELETE FROM food WHERE f_id = ?";
$stmt = $mysqli->prepare($delete_query);

// Check if the statement preparation is successful
if (!$stmt) {
    error_log("Prepare failed: " . $mysqli->error);
    header("location: shop_menu_list.php?dsb_fdt=0");
    exit();
}

// Bind the parameter and execute
$stmt->bind_param("i", $f_id);
if ($stmt->execute()) {
    // Redirect on successful deletion
    header("location: shop_menu_list.php?dsb_fdt=1");
} else {
    // Log error and redirect on failure
    error_log("Execute failed: " . $stmt->error);
    header("location: shop_menu_list.php?dsb_fdt=0");
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
?>
