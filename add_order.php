<?php
// Ensure comprehensive error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/your/php-error.log');

// Include database connection
require_once('conn_db.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate user login
    if (!isset($_SESSION['cid'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not logged in',
            'redirect' => 'login.php'
        ]);
        exit();
    }
    
    // Sanitize and validate inputs
    $c_id = filter_var($_SESSION['cid'], FILTER_VALIDATE_INT);
    
    // Validate pay amount (handle potential decimal conversion)
    $p_amount = isset($_POST['payamount']) 
        ? filter_var($_POST['payamount'], FILTER_VALIDATE_FLOAT) 
        : null;
    
    // Validate pickup time format
    $orh_pickuptime = $_POST['orh_pickuptime'];
    
    // Decode and validate cart items
    $cartdetail_query = "SELECT ct.ct_amount, ct.f_id, f_pic, f.f_name, f.f_price, ct.ct_note, f_todayavail, f_preorderavail 
                         FROM cart ct 
                         INNER JOIN food f ON ct.f_id = f.f_id 
                         WHERE ct.c_id = ?";                                 
    $stmt = $mysqli->prepare($cartdetail_query);
    $stmt->bind_param("i", $_SESSION['cid']);
    $stmt->execute();
    $cartdetail_result = $stmt->get_result();
    $cart_items = $cartdetail_result->fetch_all(MYSQLI_ASSOC);

    $s_id = $_POST['s_id'];

    // Comprehensive input validation
    if (!$c_id || !$p_amount || empty($cart_items) || !$s_id || !$orh_pickuptime) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid or missing order information',
            'details' => [
                'customer_id' => $c_id,
                'pay_amount' => $p_amount,
                'cart_items_count' => count($cart_items),
                's_id' => $s_id,
                'pickup_time' => $orh_pickuptime
            ]
        ]);
        exit();
    }

    // Begin transaction with enhanced error handling
    try {
        // Disable autocommit
        $mysqli->autocommit(FALSE);

        // Insert payment record
        $payment_query = "INSERT INTO payment (c_id, p_type, p_amount, p_detail) VALUES (?, 'offline', ?, '')";
        $payment_stmt = $mysqli->prepare($payment_query);
        if (!$payment_stmt) {
            throw new Exception("Payment preparation error: " . $mysqli->error);
        }
        $payment_stmt->bind_param("id", $c_id, $p_amount);
        $payment_stmt->execute();
        $p_id = $payment_stmt->insert_id;
        $payment_stmt->close();

        // Generate unique reference code with more entropy
        $orh_refcode = bin2hex(random_bytes(12));

        // Insert order header
        $order_header_query = "INSERT INTO order_header 
            (c_id, s_id, p_id, orh_ordertime, orh_pickuptime, orh_orderstatus, orh_refcode, orh_finishedtime) 
            VALUES (?, ?, ?, NOW(), ?, 'ACPT', ?, NULL)";
        $order_header_stmt = $mysqli->prepare($order_header_query);
        if (!$order_header_stmt) {
            throw new Exception("Order header preparation error: " . $mysqli->error);
        }
        $order_header_stmt->bind_param("iisss", $c_id, $s_id, $p_id, $orh_pickuptime, $orh_refcode);
        $order_header_stmt->execute();
        $ord_id = $order_header_stmt->insert_id;
        $order_header_stmt->close();

        // Convert datetime-local input to MySQL datetime format
        $orh_pickuptime = $_POST['orh_pickuptime'];
        if (empty($orh_pickuptime)) {
            throw new Exception('Pickup time is required');
        }

        // Convert from YYYY-MM-DDTHH:MM to YYYY-MM-DD HH:MM:SS
        $pickup_datetime = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $orh_pickuptime)));

        // Prepare order detail statement
        $order_detail_query = "INSERT INTO order_detail 
            (orh_id, f_id, ord_amount, ord_buyprice, ord_note) 
            VALUES (?, ?, ?, ?, '')";
        $order_detail_stmt = $mysqli->prepare($order_detail_query);
        if (!$order_detail_stmt) {
            throw new Exception("Order detail preparation error: " . $mysqli->error);
        }

        // Process each cart item
        foreach ($cart_items as $item) {
            $f_id = filter_var($item['f_id'], FILTER_VALIDATE_INT);
            $quantity = filter_var($item['ct_amount'], FILTER_VALIDATE_INT);
            $price = filter_var($item['f_price'], FILTER_VALIDATE_FLOAT);

            if (!$f_id || !$quantity || !$price) {
                throw new Exception("Invalid cart item details for food ID: $f_id");
            }

            // Check and update inventory before processing order
            $inventory_check_stmt = $mysqli->prepare("SELECT f_quantity FROM food WHERE f_id = ?");
            if (!$inventory_check_stmt) {
                throw new Exception("Inventory check preparation error: " . $mysqli->error);
            }
            $inventory_check_stmt->bind_param("i", $f_id);
            $inventory_check_stmt->execute();
            $inventory_result = $inventory_check_stmt->get_result();
            
            if ($inventory_result->num_rows === 0) {
                throw new Exception("Invalid food ID or food not found.");
            }
            
            $inventory_row = $inventory_result->fetch_assoc();
            $current_quantity = $inventory_row['f_quantity'];
            
            if ($current_quantity < $quantity) {
                throw new Exception("Insufficient quantity for food ID: $f_id");
            }
            
            // Calculate and update new quantity
            $new_quantity = $current_quantity - $quantity;
            $update_inventory_stmt = $mysqli->prepare("UPDATE food SET f_quantity = ? WHERE f_id = ?");
            if (!$update_inventory_stmt) {
                throw new Exception("Inventory update preparation error: " . $mysqli->error);
            }
            $update_inventory_stmt->bind_param("ii", $new_quantity, $f_id);
            if (!$update_inventory_stmt->execute()) {
                throw new Exception("Error updating food quantity: " . $update_inventory_stmt->error);
            }
            
            $inventory_check_stmt->close();
            $update_inventory_stmt->close();

            // Insert order detail
            $order_detail_stmt->bind_param("iiid", $ord_id, $f_id, $quantity, $price);
            if (!$order_detail_stmt->execute()) {
                throw new Exception("Failed to insert order detail for food ID $f_id: " . $order_detail_stmt->error);
            }
        }
        $order_detail_stmt->close();

        

        // Clear cart for this customer and shop
        $cart_clear_query = "DELETE FROM cart WHERE c_id = ? AND s_id = ?";
        $cart_clear_stmt = $mysqli->prepare($cart_clear_query);
        if (!$cart_clear_stmt) {
            throw new Exception("Cart clearing preparation error: " . $mysqli->error);
        }
        $cart_clear_stmt->bind_param("ii", $c_id, $s_id);
        $cart_clear_stmt->execute();
        $cart_clear_stmt->close();

        // Commit transaction
        $mysqli->commit();

        
        echo json_encode([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'order_id' => $ord_id,
            'reference_code' => $orh_refcode,
            'redirect' => 'order_success.php?orh=' . $ord_id  // Using $ord_id instead of $orh_id
        ]);

        header("location: order_success.php?orh=" . $ord_id);
        
        

    } catch (Exception $e) {
        // Rollback transaction
        $mysqli->rollback();

        // Detailed error logging
        error_log("Order Placement Error: " . $e->getMessage());
        error_log("Trace: " . $e->getTraceAsString());

        // Return error response with minimal details to client
        echo json_encode([
            'status' => 'error',
            'message' => 'Order placement failed',
            'code' => $e->getCode()
        ]);

        header("location: order_failed.php");
        exit();
    } finally {
        // Reset autocommit and close connection
        $mysqli->autocommit(TRUE);
        $mysqli->close();
        
    }
}
?>