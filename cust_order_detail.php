<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        session_start();
        if(!isset($_SESSION["cid"])||!isset($_GET["orh_id"])){
            header("location: restricted.php");
            exit(1);
        }
        include("conn_db.php");
        include('head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .order-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 1200px;
        }

        .order-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .menu-item {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: transform 0.2s;
        }

        .menu-item:hover {
            transform: translateY(-2px);
        }

        .menu-image {
            border-radius: 10px;
            object-fit: cover;
            width: 120px;
            height: 120px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .grand-total {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .footer {
            background-color: #CD5C08;
            color: #FFF5E4;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
    <title>Order Detail</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include('nav_header.php')?>
    <br>

    <div class="order-container">
        <div class="order-header">
            <h2 class="display-6 mb-4">Order Detail</h2>

            <?php
                $orh_id = $_GET["orh_id"];
                $orh_query = "SELECT * FROM order_header WHERE orh_id = {$orh_id}";
                $orh_arr = $mysqli -> query($orh_query) -> fetch_array();
            ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <?php if($orh_arr["orh_orderstatus"]=="ACPT"){ ?>
                            <span class="status-badge bg-info text-dark">Accepted</span>
                        <?php }else if($orh_arr["orh_orderstatus"]=="PREP"){ ?>
                            <span class="status-badge bg-warning text-dark">Preparing</span>
                        <?php }else if($orh_arr["orh_orderstatus"]=="RDPK"){ ?>
                            <span class="status-badge bg-primary text-white">Ready to pick up</span>
                        <?php }else if($orh_arr["orh_orderstatus"]=="FNSH"){?>
                            <span class="status-badge bg-success text-white">Completed</span>
                        <?php } ?>
                    </div>
                    <p class="mb-2">Order #<?php echo $orh_arr["orh_refcode"];?></p>
                    <p>From 
                        <?php
                            $shop_query = "SELECT s_name FROM shop WHERE s_id = {$orh_arr['s_id']};";
                            $shop_arr = $mysqli -> query($shop_query) -> fetch_array();
                            echo $shop_arr["s_name"];
                        ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <?php 
                        $od_placedate = (new Datetime($orh_arr["orh_ordertime"])) -> format("F j, Y H:i"); 
                        $od_pickupdate = (new Datetime($orh_arr["orh_pickuptime"])) -> format("F j, Y H:i");
                    ?>
                    <p class="mb-2">Placed on <?php echo $od_placedate;?></p>
                    <?php if($orh_arr["orh_orderstatus"]!="FNSH"){ ?>
                        <p>Will be pick-up on <?php echo $od_pickupdate;?></p>
                    <?php }else{
                        $od_finishtime = (new Datetime($orh_arr["orh_finishedtime"])) -> format("F j, Y H:i");
                    ?>
                        <p>Finished on <?php echo $od_finishtime;?></p>
                    <?php } ?>
                </div>
            </div>
        </div>

        <h5 class="fw-light mb-4">Menu Items</h5>
        <div class="row">
            <?php 
                $ord_query = "SELECT f.f_name,f.f_pic,ord.ord_amount,ord.ord_buyprice,ord_note FROM order_detail ord INNER JOIN food f ON ord.f_id = f.f_id WHERE ord.orh_id = {$orh_id}";
                $ord_result = $mysqli -> query($ord_query);
                while($ord_row = $ord_result -> fetch_array()){
            ?>
            <div class="col-md-6">
                <div class="menu-item d-flex align-items-center">
                    <img 
                        <?php
                            if(is_null($ord_row["f_pic"])){echo "src='img/default.png'";}
                            else{echo "src=\"img/{$ord_row['f_pic']}\"";}
                        ?>
                        class="menu-image"
                        alt="<?php echo $ord_row["f_name"]?>"
                    >
                    <div class="ms-3">
                        <h5 class="mb-1">
                            <span class="text-primary"><?php echo $ord_row["ord_amount"]?>x</span> 
                            <?php echo $ord_row["f_name"]?>
                        </h5>
                        <p class="mb-1">
                            <?php printf("%.2f Rs. <small class='text-muted'>(%.2f Rs. each)</small>",$ord_row["ord_buyprice"]*$ord_row["ord_amount"],$ord_row["ord_buyprice"]);?>
                        </p>
                        <?php if($ord_row["ord_note"]) { ?>
                            <small class="text-muted"><?php echo $ord_row["ord_note"]?></small>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="grand-total">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Grand Total</h5>
                    <small class="text-muted">Pay by Cash</small>
                </div>
                <h3 class="mb-0">
                    <?php
                        $gt_query = "SELECT SUM(ord_amount*ord_buyprice) AS gt FROM order_detail WHERE orh_id = {$orh_id}";
                        $gt_arr = $mysqli -> query($gt_query) -> fetch_array();
                        printf("%.2f Rs.",$gt_arr["gt"]);
                    ?>
                </h3>
            </div>
        </div>
    </div>
    <br><br>

    <footer class="footer mt-auto">
        <p class="mb-0">CEC</p>
    </footer>
</body>
</html>