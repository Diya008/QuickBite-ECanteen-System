<?php
require_once 'conn_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $s_id = $mysqli->real_escape_string($_POST['s_id']);
    $feedback = $mysqli->real_escape_string($_POST['feedback']);

    // Prepare SQL insert statement
    $sql = "INSERT INTO feedback ( s_id, feedback) VALUES ( '$s_id', '$feedback')";

    // Execute query
    if ($mysqli->query($sql) === TRUE) {
        // Redirect with success message
        header("Location: index.php?msg=Feedback submitted successfully");
        exit();
    } else {
        // Redirect with error message
        header("Location: index.php?msg=" . urlencode($mysqli->error));
        exit();
    }
} else {
    // If accessed directly without POST
    header("Location: index.php");
    exit();
}
?>