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
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        :root {
            --primary-color: #CD5C08;
            --bg-color: #FFF5E4;
            --text-color: #333;
            --success-color: #198754;
            --info-color: #0dcaf0;
            --warning-color: #ffc107;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #shop-body {
            padding: 2rem 0;
            flex-grow: 1;
        }

        .shop-header {
            margin-bottom: 2rem;
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 1.5rem;
        }

        .nav-tabs .nav-link {
            color: var(--text-color);
            border: none;
            padding: 0.8rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-tabs .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-color);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav-tabs .nav-link.active::after {
            transform: scaleX(1);
        }

        .nav-tabs .nav-link:hover {
            color: var(--primary-color);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .status-badge {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .order-info {
            font-size: 0.9rem;
            color: #666;
        }

        .price {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .more-details {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .more-details:hover {
            color: var(--primary-color);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .footer {
            background-color: var(--primary-color);
            color: var(--bg-color);
            padding: 1rem;
            text-align: center;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .nav-tabs .nav-link {
                padding: 0.6rem 1rem;
            }

            .card {
                margin: 0.75rem 0;
            }
        }
    </style>
</head>
<body>
    <?php include('nav_header.php')?>

    <div class="container" id="shop-body">
        <div class="shop-header">
            <h2 class="display-6">Order History</h2>
        </div>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="ongoing-tab" data-bs-toggle="tab" data-bs-target="#nav-ongoing" 
                    type="button" role="tab" aria-controls="nav-ongoing" aria-selected="true">Ongoing</button>
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#nav-completed"
                    type="button" role="tab" aria-controls="nav-completed" aria-selected="false">Completed</button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <!-- Ongoing Orders Tab -->
            <div class="tab-pane fade show active" id="nav-ongoing" role="tabpanel" aria-labelledby="ongoing-tab">
                <?php 
                $ongoing_query = "SELECT * FROM order_header WHERE c_id = {$_SESSION['cid']} AND orh_orderstatus <> 'FNSH';";
                $ongoing_result = $mysqli->query($ongoing_query);
                $ongoing_num = $ongoing_result->num_rows;
                if($ongoing_num > 0){
                ?>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php while($og_row = $ongoing_result->fetch_array()){ ?>
                    <div class="col">
                        <div class="card">
                            <?php 
                            $status_class = '';
                            $status_text = '';
                            switch($og_row["orh_orderstatus"]) {
                                case "ACPT":
                                    $status_class = 'bg-info';
                                    $status_text = 'Accepted your order';
                                    break;
                                case "PREP":
                                    $status_class = 'bg-warning';
                                    $status_text = 'Preparing your order';
                                    break;
                                case "RDPK":
                                    $status_class = 'bg-primary text-white';
                                    $status_text = 'Ready for pick-up';
                                    break;
                                default:
                                    $status_class = 'bg-success text-white';
                                    $status_text = 'Order Finished';
                            }
                            ?>
                            <div class="card-header <?php echo $status_class; ?>">
                                <span class="status-badge"><?php echo $status_text; ?></span>
                            </div>
                            <div class="card-body">
                                <div class="order-info">
                                    <div>Order #<?php echo $og_row["orh_refcode"]; ?></div>
                                    <div class="mb-2">From 
                                        <?php
                                        $shop_query = "SELECT s_name FROM shop WHERE s_id = {$og_row['s_id']};";
                                        $shop_arr = $mysqli->query($shop_query)->fetch_array();
                                        echo $shop_arr["s_name"];
                                        ?>
                                    </div>
                                    <?php 
                                    $ord_query = "SELECT COUNT(*) AS cnt, SUM(ord_amount*ord_buyprice) AS gt FROM order_detail WHERE orh_id = {$og_row['orh_id']}";
                                    $ord_arr = $mysqli->query($ord_query)->fetch_array();
                                    ?>
                                    <div class="pt-2 border-top">
                                        <div><?php echo $ord_arr["cnt"]; ?> item(s)</div>
                                        <div class="price"><?php echo $ord_arr["gt"]; ?> Rs.</div>
                                    </div>
                                    <div class="text-end mt-3">
                                        <a href="cust_order_detail.php?orh_id=<?php echo $og_row["orh_id"]; ?>" 
                                           class="more-details">
                                            <span>More Details</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="empty-state">
                    <p>You don't have any ongoing orders.</p>
                </div>
                <?php } ?>
            </div>

            <!-- Completed Orders Tab -->
            <!-- Similar structure as Ongoing Orders, just with different query -->
            <div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="completed-tab">
            
                <?php 
                $ongoing_query = "SELECT * FROM order_header WHERE c_id = {$_SESSION['cid']} AND orh_orderstatus = 'FNSH';";
                $ongoing_result = $mysqli->query($ongoing_query);
                $ongoing_num = $ongoing_result->num_rows;
                if($ongoing_num > 0){
                ?>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php while($og_row = $ongoing_result->fetch_array()){ ?>
                    <div class="col">
                        <div class="card">
                            <?php 
                            $status_class = '';
                            $status_text = '';
                            switch($og_row["orh_orderstatus"]) {
                                case "ACPT":
                                    $status_class = 'bg-info';
                                    $status_text = 'Accepted your order';
                                    break;
                                case "PREP":
                                    $status_class = 'bg-warning';
                                    $status_text = 'Preparing your order';
                                    break;
                                case "RDPK":
                                    $status_class = 'bg-primary text-white';
                                    $status_text = 'Ready for pick-up';
                                    break;
                                default:
                                    $status_class = 'bg-success text-white';
                                    $status_text = 'Order Finished';
                            }
                            ?>
                            <div class="card-header <?php echo $status_class; ?>">
                                <span class="status-badge"><?php echo $status_text; ?></span>
                            </div>
                            <div class="card-body">
                                <div class="order-info">
                                    <div>Order #<?php echo $og_row["orh_refcode"]; ?></div>
                                    <div class="mb-2">From 
                                        <?php
                                        $shop_query = "SELECT s_name FROM shop WHERE s_id = {$og_row['s_id']};";
                                        $shop_arr = $mysqli->query($shop_query)->fetch_array();
                                        echo $shop_arr["s_name"];
                                        ?>
                                    </div>
                                    <?php 
                                    $ord_query = "SELECT COUNT(*) AS cnt, SUM(ord_amount*ord_buyprice) AS gt FROM order_detail WHERE orh_id = {$og_row['orh_id']}";
                                    $ord_arr = $mysqli->query($ord_query)->fetch_array();
                                    ?>
                                    <div class="pt-2 border-top">
                                        <div><?php echo $ord_arr["cnt"]; ?> item(s)</div>
                                        <div class="price"><?php echo $ord_arr["gt"]; ?> Rs.</div>
                                    </div>
                                    <div class="text-end mt-3">
                                        <a href="cust_order_detail.php?orh_id=<?php echo $og_row["orh_id"]; ?>" 
                                           class="more-details">
                                            <span>More Details</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="empty-state">
                    <p>You don't have any finished orders.</p>
                </div>
                <?php } ?>
            
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>CEC</p>
    </footer>
</body>
</html>