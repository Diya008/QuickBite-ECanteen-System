<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        session_start(); 
        include("../conn_db.php"); 
        include('../head.php');
        if($_SESSION["utype"]!="shopowner"){
            header("location: ../restricted.php");
            exit(1);
        }
        $s_id = $_SESSION["sid"];
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/menu.css" rel="stylesheet">
    <!-- Add Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Add custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .order-container {
            background-color: #FFF5E4;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .order-header {
            border-bottom: 2px solid #CD5C08;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
        }

        .menu-item {
            background-color: white;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: transform 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .menu-item:hover {
            transform: translateY(-2px);
        }

        .menu-item img {
            border-radius: 10px;
            object-fit: cover;
        }

        .action-buttons .btn {
            margin-right: 0.5rem;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .grand-total {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .footer {
            background-color: #CD5C08;
            padding: 1rem;
            color: #FFF5E4;
            font-weight: 500;
        }

        /* Custom status colors */
        .status-accepted { background-color: #17a2b8; }
        .status-preparing { background-color: #ffc107; }
        .status-ready { background-color: #007bff; }
        .status-completed { background-color: #28a745; }
    </style>
    <title>Order Detail</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_shop.php')?>

    <?php
        $orh_id = $_GET["orh_id"];
        $orh_query = "SELECT * FROM order_header WHERE orh_id = {$orh_id}";
        $orh_arr = $mysqli -> query($orh_query) -> fetch_array();
    ?>

    <div class="container order-container">
        <div class="order-header">
            <h2 class="display-5 mb-4">Order #<?php echo $orh_arr["orh_refcode"];?></h2>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="mb-4">
                        <?php if($orh_arr["orh_orderstatus"]=="ACPT"){ ?>
                            <span class="status-badge status-accepted">Accepted</span>
                        <?php }else if($orh_arr["orh_orderstatus"]=="PREP"){ ?>
                            <span class="status-badge status-preparing">Preparing</span>
                        <?php }else if($orh_arr["orh_orderstatus"]=="RDPK"){ ?>
                            <span class="status-badge status-ready">Ready to pick up</span>
                        <?php }else if($orh_arr["orh_orderstatus"]=="FNSH"){?>
                            <span class="status-badge status-completed">Completed</span>
                        <?php } ?>
                    </div>
                    <p class="mb-2">Order by:
                        <?php
                            $cust_query = "SELECT c_firstname,c_lastname FROM customer WHERE c_id = {$orh_arr['c_id']};";
                            $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                            echo "{$cust_arr['c_firstname']} {$cust_arr['c_lastname']} ";
                        ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <?php 
                        $od_placedate = (new Datetime($orh_arr["orh_ordertime"])) -> format("F j, Y H:i"); 
                        $od_pickupdate = (new Datetime($orh_arr["orh_pickuptime"])) -> format("F j, Y H:i");
                    ?>
                    <p class="mb-2">Placed on: <?php echo $od_placedate;?></p>
                    <p class="mb-2">Pick-up time: <?php echo $od_pickupdate;?></p>
                    <?php if($orh_arr["orh_orderstatus"]!="FNSH"){ ?>
                        <p class="mb-2">Status: In Progress</p>
                    <?php }else{
                        $od_finishtime = (new Datetime($orh_arr["orh_finishedtime"])) -> format("F j, Y H:i");
                    ?>
                        <p class="mb-2">Finished on: <?php echo $od_finishtime;?></p>
                    <?php } ?>
                </div>
            </div>

            <?php if($orh_arr["orh_orderstatus"]!='FNSH'){ ?>
            <div class="action-buttons mt-4">
                <a class="btn btn-warning" href="shop_order_forward.php?orh_id=<?php echo $_GET["orh_id"]?>&cur_stage=1">
                    Mark as Preparing
                </a>
                <a class="btn btn-primary" href="shop_order_forward.php?orh_id=<?php echo $_GET["orh_id"]?>&cur_stage=2">
                    Mark as Ready for pick-up
                </a>
                <a class="btn btn-success" href="shop_order_forward.php?orh_id=<?php echo $_GET["orh_id"]?>&cur_stage=3">
                    Mark as Finished
                </a>
            </div>
            <?php }?>
        </div>

        <div class="menu-section">
            <h5 class="mb-4">Order Items</h5>
            <div class="row">
                <?php 
                    $ord_query = "SELECT f.f_id,f.f_name,f.f_pic,ord.ord_amount,ord.ord_buyprice,ord_note FROM order_detail ord INNER JOIN food f ON ord.f_id = f.f_id WHERE ord.orh_id = {$orh_id}";
                    $ord_result = $mysqli -> query($ord_query);
                    while($ord_row = $ord_result -> fetch_array()){
                ?>
                <div class="col-md-6 mb-3">
                    <div class="menu-item">
                        <div class="d-flex align-items-center">
                            <img <?php
                                if(is_null($ord_row["f_pic"])){echo "src='../img/default.png'";}
                                else{echo "src=\"../img/{$ord_row['f_pic']}\"";}
                            ?> class="img-fluid" style="width: 100px; height:100px; object-fit:cover;" alt="<?php echo $ord_row["f_name"]?>">
                            <div class="ms-3">
                                <h6 class="mb-1"><?php echo $ord_row["f_name"]?></h6>
                                <p class="mb-1">
                                    <span class="h6"><?php echo $ord_row["ord_amount"]?>x</span>
                                    <?php printf("Rs. %.2f <small class='text-muted'>(Rs. %.2f each)</small>",$ord_row["ord_buyprice"]*$ord_row["ord_amount"],$ord_row["ord_buyprice"]);?>
                                </p>
                                <?php if($ord_row["ord_note"]) { ?>
                                    <small class="text-muted"><?php echo $ord_row["ord_note"]?></small>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="grand-total">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h6 mb-0">Grand Total</span>
                    <span class="h4 mb-0">
                        <?php
                            $gt_query = "SELECT SUM(ord_amount*ord_buyprice) AS gt FROM order_detail WHERE orh_id = {$orh_id}";
                            $gt_arr = $mysqli -> query($gt_query) -> fetch_array();
                            printf("Rs. %.2f ",$gt_arr["gt"]);
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer text-center mt-auto">
        <p class="mb-0">CEC</p>
    </footer>
</body>
</html>