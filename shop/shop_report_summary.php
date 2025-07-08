<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start(); 
    if ($_SESSION["utype"] != "shopowner") {
        header("location: ../restricted.php");
        exit(1);
    }
    include("../conn_db.php"); 
    include('../head.php');
    include("range_fn.php");
    
    $s_id = $_SESSION["sid"];
    
    // Revenue Summary Preparation
    $rev_mode = $_GET["rev_mode"];
    $today = date("Y-m-d");
    $yesterday = (new Datetime())->sub(new DateInterval("P1D"))->format('Y-m-d');
    $weekrange = rangeWeek(date('Y-n-j'));
    $monthrange = rangeMonth(date('Y-n-j'));
    
    // Determine date range based on mode
    switch($rev_mode) {
        case 1: 
            $start_date = $today; 
            $end_date = $today; 
            break;
        case 2: 
            $start_date = $yesterday; 
            $end_date = $yesterday; 
            break;
        case 3: 
            $start_date = (new Datetime($weekrange["start"]))->format('Y-m-d');
            $end_date = (new Datetime($weekrange["end"]))->format('Y-m-d');
            break;
        case 4: 
            $start_date = (new Datetime($monthrange["start"]))->format('Y-m-d');
            $end_date = (new Datetime($monthrange["end"]))->format('Y-m-d');
            break;
        case 5: 
            if (isset($_GET["start_date"]) && isset($_GET["end_date"])) {
                $start_date = $_GET["start_date"];
                $end_date = $_GET["end_date"];
            } else {
                header("location: shop_report_select.php"); 
                exit(1);
            }
            break;
        default: 
            header("location: shop_report_select.php"); 
            exit(1);
    }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <title>Shop Revenue Report</title>
    
    <style>
        .card {
            transition: transform 0.2s ease-in-out;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .table thead {
            background-color: #CD5C08;
            color: #FFF5E4;
        }
        
        .display-6 {
            color: #CD5C08;
            font-weight: 600;
        }
        
        .border-top {
            border-color: #CD5C08 !important;
        }
        
        .border-secondary {
            border-color: #CD5C08 !important;
        }
        
        .card-title {
            color: #CD5C08;
            font-weight: 600;
        }
        
        .small {
            color: #666;
        }
    </style>
</head>

<body class="d-flex flex-column h-100" style="background-color: #FFF5E4">
    <?php
    echo "<div class='noprint'>";
    include('nav_header_shop.php');
    echo "</div>";
    
    // Format date to human-readable
    $formatted_start = (new Datetime($start_date))->format('F j, Y');
    $formatted_end = (new Datetime($end_date))->format('F j, Y');
    ?>

    <div class="container px-5 py-4" id="shop-body">
        <div class="mt-4">
            <h2 class="display-6">Revenue Report</h2>
            <h4 class="fw-light">
                <?php 
                if ($formatted_start == $formatted_end) {
                    echo "Of {$formatted_start}";
                } else {
                    echo "From {$formatted_start} to {$formatted_end}";
                }
                ?>
            </h4>
            <p class="fw-light">Generated on <?php echo date("F j, Y H:i")?>. This report only includes finished orders.</p>

            <!-- Overall Performance Section -->
            <h4 class="border-top fw-light pt-3 pb-2 mt-2">Overall Performance</h4>
            <div class="row row-cols-2 row-cols-md-4 mb-3 g-2">
                <!-- Total Revenue Card -->
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                $query = "SELECT SUM(ord.ord_amount*ord.ord_buyprice) AS rev 
                                         FROM order_header orh 
                                         INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
                                         WHERE orh.s_id = {$s_id} 
                                         AND orh_orderstatus = 'FNSH' 
                                         AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}'))";
                                $result = $mysqli->query($query)->fetch_array();
                                $grandtotal = is_null($result["rev"]) ? 0 : $result["rev"];
                                printf("Rs. %.2f ", $grandtotal);
                                ?>
                            </h5>
                            <p class="card-text small">Total Revenue</p>
                        </div>
                    </div>
                </div>

                <!-- Number of Orders Card -->
                <div class="col">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                $query = "SELECT COUNT(*) AS cnt 
                                         FROM order_header orh 
                                         WHERE orh.s_id = {$s_id} 
                                         AND orh_orderstatus = 'FNSH' 
                                         AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}'))";
                                $result = $mysqli->query($query)->fetch_array();
                                $num_order = is_null($result["cnt"]) ? 0 : $result["cnt"];
                                printf("%d Orders", $num_order);
                                ?>
                            </h5>
                            <p class="card-text small">Number of Orders</p>
                        </div>
                    </div>
                </div>

                <!-- Remaining cards... -->
                <!-- Similar structure for other metric cards -->

            </div>

            <!-- Menu Performance Section -->
            <h4 class="border-top fw-light pt-3 mt-2">Menu Performance</h4>
            <?php
            $query = "SELECT f.f_name, f.f_price, SUM(ord.ord_amount) AS amount, 
                             SUM(ord.ord_amount*ord.ord_buyprice) AS subtotal 
                      FROM order_header orh 
                      INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id 
                      INNER JOIN food f ON ord.f_id = f.f_id
                      WHERE orh.s_id = {$s_id} 
                      AND orh_orderstatus = 'FNSH' 
                      AND (DATE(orh_finishedtime) BETWEEN DATE('{$start_date}') AND DATE('{$end_date}'))
                      GROUP BY ord.f_id 
                      ORDER BY amount DESC";
            $result = $mysqli->query($query);
            $num_rows = $result->num_rows;
            
            if ($num_rows > 0) {
            ?>
            <div class="table-responsive">
                <table class="table table-light table-striped table-hover align-middle caption-top mb-5">
                    <caption><?php echo $num_rows;?> Menus</caption>
                    <thead>
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Menu Name</th>
                            <th scope="col">Current Price</th>
                            <th scope="col">Amount Sold</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1; 
                        while ($row = $result->fetch_array()) { 
                        ?>
                        <tr>
                            <th><?php echo $i++;?></th>
                            <td><?php echo $row["f_name"]?></td>
                            <td><?php echo " Rs. ".$row["f_price"]?></td>
                            <td><?php echo $row["amount"]." plates"?></td>
                            <td><?php echo " Rs. ".$row["subtotal"]?></td>
                        </tr>
                        <?php } ?>
                        <tr class="fw-bold table-info">
                            <td colspan="4" class="text-end">Grand Total</td>
                            <td><?php printf("Rs. %.2f ", $grandtotal);?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <p class="fw-light">No records.</p>
            <?php } ?>
        </div>
    </div>

    <footer class="text-center text-white">
        <div class="text-center p-2 mb-1" style="background-color: #CD5C08; color: #FFF5E4">
            <p class="mb-0">CEC</p>
        </div>
    </footer>
</body>
</html>