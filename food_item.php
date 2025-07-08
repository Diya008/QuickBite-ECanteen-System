<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start();
        include("conn_db.php");
        include('head.php');
        if(!(isset($_GET["s_id"])||isset($_GET["f_id"]))){
            header("location: restricted.php");
            exit(1);
        }
        if(!isset($_SESSION["cid"])){
            header("location: cust_login.php");
            exit(1);
        }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
    <script type="text/javascript" src="js/input_number.js"></script>
    <script type="text/javascript">
        function changeshopcf(){
            return window.confirm("Do you want to change the shop?\nDon't worry we will do it for you automatically.");
        }
    </script>
    <title>Food Item </title>
</head>

<body class="d-flex flex-column h-100" style="background-color: #FFF5E4">
    <?php 
        include('nav_header.php');
        $s_id = $_GET["s_id"];
        $f_id = $_GET["f_id"];
        $query = "SELECT f.*, s.s_status, s.s_preorderstatus FROM food f 
                  INNER JOIN shop s ON f.s_id = s.s_id 
                  WHERE f.s_id = {$s_id} AND f.f_id = {$f_id} LIMIT 0,1";
        $result = $mysqli->query($query);
        $food_row = $result->fetch_array();
    ?>
    <div class="container py-5">
    <div class="card border-0 shadow-lg" style="border-radius: 25px; background-color: white;">
    <div class="row g-0 p-5">
        <!-- Left Column - Image -->
        <div class="col-md-6 pe-md-5">
            <div class="position-relative">
                <img 
                    <?php
                        if(is_null($food_row["f_pic"])){
                            echo "src='img/default.png'";
                        } else {
                            echo "src=\"img/{$food_row['f_pic']}\"";
                        }
                    ?> 
                    class="img-fluid rounded-4 shadow" 
                    style="width: 100%; height: 450px; object-fit: cover; transition: transform 0.3s ease;"
                    alt="<?php echo $food_row["f_name"]?>">
            </div>
        </div>
        
        <!-- Right Column - Content -->
        <div class="col-md-6 d-flex flex-column justify-content-between ps-md-4">
            <div>
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h2 class="display-6 fw-bold mb-0" style="color: #2C3639;"><?php echo $food_row["f_name"]?></h2>
                    <div class="ms-3">
                        <?php if($food_row["veg_nveg"]==0){ ?>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 122.88" style="height: 30px; filter: drop-shadow(0px 2px 2px rgba(0, 0, 0, 0.1));">
                                <path style="fill:#6BBE66;" d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44c0,33.93-27.51,61.44-61.44,61.44C27.51,122.88,0,95.37,0,61.44 C0,27.51,27.51,0,61.44,0L61.44,0z"/>
                            </svg>
                        <?php } else { ?>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 122.88" style="height: 30px; filter: drop-shadow(0px 2px 2px rgba(0, 0, 0, 0.1));">
                                <path style="fill:#ff0000;" d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z"/>
                            </svg>
                        <?php } ?>
                    </div>
                </div>
                
                <!-- Price -->
                <h3 class="fw-bold mb-4" style="color: #6A9C89; font-size: 2rem;">Rs. <?php echo $food_row["f_price"]?></h3>
                
                <!-- Status Badges -->
                <div class="mb-4">
                    <div class="d-flex gap-3 mb-4">
                        <?php if($food_row["f_todayavail"]==1 && $food_row["s_status"]==1) { ?>
                            <span class="badge px-4 py-2" style="background-color: #6A9C89; font-size: 0.9rem; border-radius: 50px; box-shadow: 0 2px 4px rgba(106, 156, 137, 0.2);">Available</span>
                        <?php } else { ?>
                            <span class="badge px-4 py-2" style="background-color: #CD5C08; font-size: 0.9rem; border-radius: 50px; box-shadow: 0 2px 4px rgba(205, 92, 8, 0.2);">Out of Order</span>
                        <?php }
                        if($food_row["f_preorderavail"]==1 && $food_row["s_preorderstatus"]==1) { ?>
                            <span class="badge px-4 py-2" style="background-color: #6A9C89; font-size: 0.9rem; border-radius: 50px; box-shadow: 0 2px 4px rgba(106, 156, 137, 0.2);">Pre-order Available</span>
                        <?php } else { ?>
                            <span class="badge px-4 py-2" style="background-color: #CD5C08; font-size: 0.9rem; border-radius: 50px; box-shadow: 0 2px 4px rgba(205, 92, 8, 0.2);">Pre-order Unavailable</span>
                        <?php } ?>
                    </div>
                    
                    <!-- Quantity Badge -->
                    <div class="d-flex align-items-center">
                        <span class="text-muted fw-medium me-2">Quantity Available:</span>
                        <span class="badge" style="background-color: #2C3639; font-size: 0.9rem; padding: 8px 16px; border-radius: 50px;">
                            <?php echo $food_row["f_quantity"] ?? "Not specified"; ?> units
                        </span>
                    </div>
                </div>
            </div>

            <!-- Add to Cart Section -->
            <div class="form-amount mt-4">
                <form method="POST" action="add_item.php">
                    <div class="input-group mb-4" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <button id="sub_btn" class="btn btn-outline-secondary px-4" type="button" onclick="sub_amt('amount')" style="border-radius: 15px 0 0 15px;">
                            <i class="bi bi-dash-lg"></i>
                        </button>
                        <input type="number" 
                            class="form-control text-center border-secondary" 
                            id="amount"
                            name="amount" 
                            value="0" 
                            min="1" 
                            max="<?php echo $food_row['f_quantity'] ?? 99; ?>" 
                            style="background-color: #FFF5E4; border-left: none; border-right: none;">
                        <button id="add_btn" class="btn btn-outline-secondary px-4" type="button" onclick="add_amt('amount')" style="border-radius: 0 15px 15px 0;">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                    <input type="hidden" name="s_id" value="<?php echo $s_id?>">
                    <input type="hidden" name="f_id" value="<?php echo $f_id?>">
                    <button class="btn w-100 py-3 position-relative overflow-hidden" 
                        type="submit" 
                        name="addtocart"
                        style="background-color: #6A9C89; color: white; border-radius: 15px; font-weight: 600; font-size: 1.1rem; box-shadow: 0 4px 6px rgba(106, 156, 137, 0.2); transition: all 0.3s ease;"
                        onmouseover="this.style.backgroundColor='#5d8a78'"
                        onmouseout="this.style.backgroundColor='#6A9C89'"
                        <?php
                            $cartsearch_query1 = "SELECT COUNT(*) AS cnt FROM cart WHERE c_id = {$_SESSION['cid']}";
                            $cartsearch_row1 = $mysqli->query($cartsearch_query1)->fetch_array();
                            if($cartsearch_row1["cnt"] > 0){
                                $cartsearch_query2 = $cartsearch_query1." AND s_id = {$s_id}";
                                $cartsearch_row2 = $mysqli->query($cartsearch_query2)->fetch_array();
                                if($cartsearch_row2["cnt"] == 0) { ?>
                                    onclick="javascript: return changeshopcf();"<?php 
                                } 
                            }
                        ?>>
                        <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor'
                            class='bi bi-cart-plus me-2' viewBox='0 0 16 16'>
                            <path d='M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z'/>
                            <path d='M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                        </svg>
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
    </div>
    <?php $result->free_result(); ?>
    <footer class="text-center text-white">
    <div class="navbar fixed-bottom navbar-expand-lg text-center p-2 mb-0" style="background-color: #CD5C08; color: #FFF5E4">
  <div class="container-fluid justify-content-center">
    
        <p> CEC </p>
        </div>
        
  </div>
    </footer>
</body>
</html>
