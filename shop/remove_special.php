<?php
// Include database connection
include '../conn_db.php'; // Update this path based on your directory structure

$mysqli->query("UPDATE food SET is_special = 0 ");
header("Location: shop_menu_list.php?s_id=$s_id");
?>
