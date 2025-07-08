<?php
session_start();
include('../conn_db.php');

// Use prepared statement for secure login
$query = "SELECT s_id, s_username, s_name FROM shop WHERE s_username = ? AND s_pwd = ?";

// Prepare statement
$stmt = $mysqli->prepare($query);

// Check if preparation was successful
if ($stmt === false) {
    die("Prepare failed: " . $mysqli->error);
}

// Bind parameters
$stmt->bind_param("ss", $username, $pwd);

// Get POST values
$username = $_POST["username"];
$pwd = $_POST["pwd"];

// Execute query
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 1){
    // Successful login
    $row = $result->fetch_array();
    $_SESSION["sid"] = $row["s_id"];
    $_SESSION["username"] = $username;
    $_SESSION["shopname"] = $row["s_name"];
    $_SESSION["utype"] = "shopowner";
    header("location: shop_home.php");
    exit();
} else {
    // Failed login
    ?>
    <script>
        alert("Wrong username and/or password!");
        history.back();
    </script>
    <?php
}

$stmt->close();
?>