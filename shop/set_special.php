<?php
// Include the database connection
include '../conn_db.php'; // Make sure this path is correct

// Check if required POST data exists
if (isset($_POST['setSpecial'], $_POST['specialItems'], $_POST['s_id']) && !empty($_POST['specialItems'])) {
    // Sanitize inputs
    $specialItems = $_POST['specialItems'];
    $s_id = intval($_POST['s_id']); // Convert to integer for safety

    // Unmark all items as "special" for the specific shop
    $mysqli->query("UPDATE food SET is_special = 0 WHERE s_id = $s_id");

    // Mark selected items as "Today's Special"
    foreach ($specialItems as $item_id) {
        $item_id = intval($item_id); // Sanitize item ID
        $mysqli->query("UPDATE food SET is_special = 1 WHERE f_id = $item_id AND s_id = $s_id");
    }

    // Redirect to the shop menu with a success message
    header("Location: shop_menu_list.php?s_id=$s_id");
    exit;
} else {
    // Redirect with an error if required data is missing
    header("Location: shop_menu_list.php?s_id=$s_id&error=no_items_selected");
    exit;
}
?>
