<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start();
    
    // Check if user is logged in
    if (!isset($_SESSION["cid"])) {
        header("location: restricted.php");
        exit(1);
    }
    
    include("conn_db.php");
    
    // Handle cart update
    if (isset($_POST["upd_item"])) {
        $target_sid = $_POST["s_id"];
        $target_cid = $_SESSION["cid"];
        $target_fid = $_POST["f_id"];
        $amount = $_POST["amount"];
        $request = $_POST["request"];
        
        $cartupdate_query = "UPDATE cart 
                            SET ct_amount = {$amount}, 
                                ct_note = '{$request}' 
                            WHERE c_id = {$target_cid} 
                            AND s_id = {$target_sid} 
                            AND f_id = {$target_fid}";
        
        $cartupdate_result = $mysqli->query($cartupdate_query);
        
        if ($cartupdate_result) {
            header("location: cust_cart.php?up_crt=1");
        } else {
            header("location: cust_cart.php?up_crt=0");
        }
        exit(1);
    }

    include('head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
    <script type="text/javascript" src="js/input_number.js"></script>
    <style>
        body {
            background-color: #FFF5E4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .rounded-25 {
            border-radius: 25px;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5em 1em;
            margin-right: 0.5em;
        }

        .form-amount {
            max-width: 400px;
        }

        .input-group .btn {
            border-color: #CD5C08;
            color: #CD5C08;
        }

        .input-group .btn:hover {
            background-color: #CD5C08;
            color: #FFF5E4;
        }

        .form-control:focus {
            border-color: #CD5C08;
            box-shadow: 0 0 0 0.2rem rgba(205, 92, 8, 0.25);
        }

        .btn-success {
            background-color: #6A9C89;
            border-color: #6A9C89;
            margin-right: 0.5rem;
        }

        .btn-success:hover {
            background-color: #5a8b78;
            border-color: #5a8b78;
        }

        .btn-outline-danger {
            color: #CD5C08;
            border-color: #CD5C08;
        }

        .btn-outline-danger:hover {
            background-color: #CD5C08;
            border-color: #CD5C08;
        }

        footer {
            margin-top: auto;
        }
    </style>
    <title>Food Item Details</title>
</head>

<body>
    <?php 
    include('nav_header.php');?>
    <br>
    <br>
    <br>

    <?php
    $s_id = $_GET["s_id"];
    $f_id = $_GET["f_id"];
    $query = "SELECT * FROM food WHERE s_id = {$s_id} AND f_id = {$f_id} LIMIT 0,1";
    $result = $mysqli->query($query);
    $food_row = $result->fetch_array();
    ?>

    <div class="container px-4 py-5" id="shop-body" style="background-color: white; border-radius: 20px;">
        <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
            <div class="col">
                <img 
                    <?php
                    if (is_null($food_row["f_pic"])) {
                        echo "src='img/default.png'";
                    } else {
                        echo "src=\"img/{$food_row['f_pic']}\"";
                    }
                    ?> 
                    class="product-image rounded-25" 
                    alt="<?php echo htmlspecialchars($food_row["f_name"])?>">
            </div>
            <div class="col">
                <h1 class="fw-light mb-3"><?php echo htmlspecialchars($food_row["f_name"])?></h1>
                <h3 class="fw-light mb-4"><?php echo number_format($food_row["f_price"], 2)?> Rs.</h3>
                
                <div class="mb-4">
                    <?php if($food_row["f_todayavail"]==1) { ?>
                        <span class="badge bg-success">Available</span>
                    <?php } else { ?>
                        <span class="badge bg-danger">Out of Order</span>
                    <?php }
                    if($food_row["f_preorderavail"]==1) { ?>
                        <span class="badge bg-success">Pre-order Available</span>
                    <?php } else { ?>
                        <span class="badge bg-danger">Pre-order Unavailable</span>
                    <?php } ?>
                </div>

                <?php
                $ci_query = "SELECT ct_amount, ct_note FROM cart 
                            WHERE c_id = {$_SESSION['cid']} 
                            AND f_id = {$f_id} 
                            AND s_id = {$s_id}";
                $ci_arr = $mysqli->query($ci_query)->fetch_array();
                ?>

                <form method="POST" action="cust_update_cart.php">
                    <div class="form-amount">
                        <div class="input-group mb-4">
                            <button class="btn btn-outline-secondary" type="button" 
                                    onclick="sub_amt('amount')">
                                <i class="bi bi-dash-lg"></i>
                            </button>
                            <input type="number" 
                                   class="form-control text-center" 
                                   id="amount"
                                   name="amount" 
                                   value="<?php echo $ci_arr["ct_amount"]?>" 
                                   min="1" 
                                   max="99">
                            <button class="btn btn-outline-secondary" type="button" 
                                    onclick="add_amt('amount')">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>

                        <input type="hidden" name="s_id" value="<?php echo $s_id?>">
                        <input type="hidden" name="f_id" value="<?php echo $f_id?>">

                        <div class="d-grid gap-2 d-md-flex">
                            <button class="btn btn-success" type="submit" name="upd_item">
                                <i class="bi bi-cart me-2"></i>Update item
                            </button>
                            <button class="btn btn-outline-danger" type="submit" 
                                    formaction="remove_cart_item.php?rmv=1&s_id=<?php echo $s_id?>&f_id=<?php echo $f_id?>" 
                                    name="rmv_item">
                                <i class="bi bi-cart-x me-2"></i>Remove item
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<br><br>
    <footer class="text-center text-white">
        <div class="p-3" style="background-color: #CD5C08">
            <p class="mb-0">CEC</p>
        </div>
    </footer>
</body>
</html>