<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    session_start();
    if(!isset($_SESSION["cid"])){
        header("location: restricted.php");
        exit(1);
    }
    include("conn_db.php");
    include('head.php');
    $no_order = false;
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E4;
            font-family: 'Arial', sans-serif;
        }

        .cart-container {
            background: linear-gradient(135deg, #FFF5E4 0%, #FFE5D6 100%);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin: 20px auto;
            max-width: 1200px;
        }

        .cart-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 2px solid #FFD1B3;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .cart-header svg {
            fill: #FF6B6B;
        }

        .cart-item {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s ease;
        }

        .cart-item:hover {
            transform: translateY(-2px);
        }

        .cart-item img {
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .item-price {
            color: #FF6B6B;
            font-weight: bold;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E8E 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            color: white;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 107, 107, 0.2);
        }

        .btn-danger {
            background: linear-gradient(135deg, #FF4646 0%, #FF6B6B 100%);
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            display: inline-block;
            margin-top: 1rem;
        }

        .btn-danger:hover {
            color: white;
            background: linear-gradient(135deg, #FF3636 0%, #FF5B5B 100%);
        }

        .notification {
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .success-notification {
            background: linear-gradient(135deg, #4CAF50 0%, #45A049 100%);
            color: white;
        }

        .error-notification {
            background: linear-gradient(135deg, #FF4646 0%, #FF6B6B 100%);
            color: white;
        }

        .pickup-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .datetime-input {
            border: 2px solid #FFE5D6;
            border-radius: 8px;
            padding: 0.5rem;
            width: 100%;
            margin-top: 0.5rem;
        }

        .datetime-input:focus {
            outline: none;
            border-color: #FF6B6B;
        }

        .grand-total {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.25rem;
        }

        .action-link {
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .edit-link {
            color: #4CAF50;
        }

        .remove-link {
            color: #FF4646;
        }

        .action-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 768px) {
            .cart-container {
                padding: 1rem;
                margin: 10px;
            }
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header.php')?>

    <div class="cart-container">
        <!-- Cart Header -->
        <div class="cart-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
            <h2 class="display-6 mb-0">My Cart</h2>
        </div>

        <?php 
        $ct_query = "SELECT * FROM cart WHERE c_id = {$_SESSION['cid']}";
        $cart_numrow = $mysqli->query($ct_query)->num_rows;
        if($cart_numrow > 0){
            // Get shop information
            $cart_query = "SELECT s_id,s_name,s_openhour,s_closehour,s_status,s_preorderstatus FROM shop s 
                          WHERE s_id = (SELECT s_id FROM cart WHERE c_id = {$_SESSION['cid']} LIMIT 0,1)";
            $cart_result = $mysqli->query($cart_query)->fetch_array();
            $shop_name = $cart_result["s_name"];
            $shop_open = $cart_result["s_openhour"];
            $shop_close = $cart_result["s_closehour"];
        ?>

        <!-- Cart Items Section -->
        <div class="shop-info mb-4">
            <h5>My Order</h5>
            <p class="text-muted">From <?php echo $shop_name; ?></p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 10px;">
    <?php
    $cartdetail_query = "SELECT ct.ct_amount,ct.f_id,f_pic,f.f_name,f.f_price,ct.ct_note,f_todayavail,f_preorderavail
                        FROM cart ct INNER JOIN food f ON ct.f_id = f.f_id 
                        WHERE ct.c_id = {$_SESSION['cid']}";
    $cartdetail_result = $mysqli->query($cartdetail_query);
    
    while($row = $cartdetail_result->fetch_array()){
    ?>
    <div style="background-color: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 15px; width: 100%; box-sizing: border-box;">
        <div style="display: flex; gap: 15px;">
            <div style="flex: 0 0 30%;">
                <img src="<?php echo is_null($row["f_pic"]) ? 'img/default.png' : 'img/'.$row["f_pic"]; ?>" 
                     style="width: 100%; height: auto; border-radius: 4px; object-fit: cover;"
                     alt="Food Image">
            </div>
            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <h5 style="margin: 0; font-size: 1.1em;"><?php echo $row["f_name"]; ?></h5>
                    <span style="font-weight: bold;">
                        <?php printf("%.2f Rs.", $row["f_price"] * $row["ct_amount"]); ?>
                    </span>
                </div>
                <p style="color: #666; margin: 0 0 8px 0;">
                    Quantity: <?php echo $row["ct_amount"]; ?> × 
                    <?php printf("%.2f Rs.", $row["f_price"]); ?>
                </p>
                <?php if(!empty($row["ct_note"])){ ?>
                    <p style="color: #666; font-size: 0.9em; margin: 0 0 8px 0;"><?php echo $row["ct_note"]; ?></p>
                <?php } ?>

                <div style="display: flex; gap: 15px; margin-top: 10px;">
                    <?php if($row["f_todayavail"] == 1 || $row["f_preorderavail"] == 1){ ?>
                        <a href="cust_update_cart.php?s_id=<?php echo $cart_result["s_id"];?>&f_id=<?php echo $row["f_id"];?>" 
                           style="color: #007bff; text-decoration: none;">
                            Edit item
                        </a>
                    <?php } else { ?>
                        <a href="remove_cart_item.php?rmv=1&s_id=<?php echo $cart_result["s_id"];?>&f_id=<?php echo $row["f_id"];?>" 
                           style="color: #dc3545; text-decoration: none;">
                            Remove item
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<!-- Rest of the content should be full width -->
<div style="padding: 10px;">
    <!-- Remove all items link -->
    <a href="remove_cart_all.php?rmv=1&s_id=<?php echo $cart_result["s_id"];?>" 
       style="display: inline-block; padding: 8px 16px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px;">
        Remove all items from cart
    </a>

    <!-- Grand Total -->
    <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: bold;">Grand Total</span>
        <span style="font-weight: bold; font-size: 1.2em;">
            <?php
            $gt_query = "SELECT SUM(ct.ct_amount*f.f_price) AS grandtotal FROM cart ct INNER JOIN food f 
                         ON ct.f_id = f.f_id WHERE ct.c_id = {$_SESSION['cid']} GROUP BY ct.c_id";
            $gt_arr = $mysqli->query($gt_query)->fetch_array();
            $order_cost = $gt_arr["grandtotal"];
            printf("Rs. %.2f", $order_cost);
            ?>
        </span>
    </div>

    <!-- Pickup Details Section -->
    <div style="margin-top: 20px; padding: 20px; background-color: #fff; border: 1px solid #ddd; border-radius: 8px;">
        <h5 style="margin-bottom: 15px;">Pick-Up Details</h5>
        <form method="POST" action="add_order.php">
            <div style="margin-bottom: 15px;">
                <label for="orh_pickuptime" style="display: block; margin-bottom: 8px;">Pick-Up Date and Time</label>
                <input type="datetime-local" 
                       style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;"
                       name="orh_pickuptime" 
                       id="orh_pickuptime"
                       min= "<?php echo $min_datetime; ?>" 
                       max="<?php echo $max_datetime; ?>"
                       value="<?php echo $min_datetime; ?>"
                       <?php if(isset($no_order) && $no_order) echo "disabled"; ?> required>
            </div>

            <input type="hidden" name="payamount" value="<?php echo $order_cost; ?>">
            <input type="hidden" name="s_id" value="<?php echo $cart_result["s_id"]; ?>">

            <button type="submit" 
                    style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1em;"
                    name="place_order" 
                    <?php if(isset($no_order) && $no_order) echo "disabled"; ?>>
                Place Order
            </button>
        </form>
    </div>
</div>

<?php } else { ?>
<!-- Empty Cart Message -->
<div style="padding: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24; display: flex; align-items: center; gap: 10px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
    </svg>
    <span>Your cart is empty</span>
</div>
<?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </div>
<footer class="text-center text-white">
  <!-- Copyright -->
  <div class="text-center p-2 p-2 mb-1 " style="background-color: #CD5C08; color: #FFF5E4 ; ">
    
        <p> CEC </p>
  </div>
  <!-- Copyright -->
</footer>
</body>

<!-- Apply class to omise payment button -->

</html>
