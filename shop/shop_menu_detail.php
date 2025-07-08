<?php 
session_start(); 
include("../conn_db.php"); 
include('../head.php');

if ($_SESSION["utype"] != "shopowner") {
    header("location: ../restricted.php");
    exit(1);
}

$s_id = $_SESSION["sid"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Detail</title>
    
    <!-- Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/menu.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6A9C89;
            --secondary-color: #CD5C08;
            --background-color: #FFF5E4;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --text-color: #333;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: white;
            border: none;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .menu-image-container {
            height: 300px;
            overflow: hidden;
            border-radius: 15px 15px 0 0;
            position: relative;
            margin-bottom: -1px;
        }

        .menu-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .menu-image:hover {
            transform: scale(1.05);
        }

        .food-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin: 5px;
            font-size: 0.9rem;
        }

        .badge-veg {
            background-color: #6BBE66;
            color: white;
        }

        .badge-nonveg {
            background-color: #FF4141;
            color: white;
        }

        .stats-card {
            padding: 20px;
            text-align: center;
            height: 100%;
        }

        .stats-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .action-button {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .action-button.primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .action-button.danger {
            background-color: var(--danger-color);
            color: white;
            border: none;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .orders-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table-header {
            background-color: var(--primary-color);
            color: white;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 20px 0;
            margin-top: auto;
        }

        .search-form {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-select, .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include('nav_header_shop.php')?>

    <div class="container pt-5">
        <?php
        $f_id = $_GET["f_id"];
        $query = "SELECT f.f_name, f.f_price, f.f_todayavail, f.f_preorderavail, f.f_pic, f.veg_nveg 
                  FROM food f 
                  WHERE f.f_id = ? 
                  LIMIT 0,1";
                  
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $f_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $food_row = $result->fetch_array();
        ?>

        <!-- Success/Error Messages -->
        <?php if(isset($_GET["up_fdt"])): ?>
            <div class="alert alert-<?php echo ($_GET["up_fdt"] == 1) ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                <?php if($_GET["up_fdt"] == 1): ?>
                    <i class="bi bi-check-circle-fill me-2"></i>Successfully updated menu detail.
                <?php else: ?>
                    <i class="bi bi-x-circle-fill me-2"></i>Failed to update menu detail.
                <?php endif; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Menu Details Card -->
        <div class="card">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="menu-image-container" style="height: 100% ; border-radius: 40px;">
                        <img class="menu-image"
                             src="<?php echo is_null($food_row["f_pic"]) ? '../img/default.png' : '../img/'.$food_row['f_pic']; ?>"
                             alt="<?php echo $food_row["f_name"]; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body p-4">
                        <h1 class="card-title display-5 fw-bold mb-3"><?php echo $food_row["f_name"]; ?></h1>
                        <h3 class="text-muted mb-4"><?php echo $food_row["f_price"] ?> Rs.</h3>
                        
                        <!-- Food Type Badge -->
                        <div class="mb-4">
                            <?php if($food_row["veg_nveg"] == 0): ?>
                                <span class="food-badge badge-veg">
                                    <i class="bi bi-circle-fill"></i> Vegetarian
                                </span>
                            <?php else: ?>
                                <span class="food-badge badge-nonveg">
                                    <i class="bi bi-circle-fill"></i> Non-Vegetarian
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Availability Status -->
                        <div class="mb-4">
                            <h5 class="mb-3">Availability Status</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <?php if($food_row["f_todayavail"] == 1): ?>
                                    <span class="status-badge bg-success">Available Today</span>
                                <?php else: ?>
                                    <span class="status-badge bg-danger">Not Available Today</span>
                                <?php endif; ?>
                                
                                <?php if($food_row["f_preorderavail"] == 1): ?>
                                    <span class="status-badge bg-success">Pre-order Available</span>
                                <?php else: ?>
                                    <span class="status-badge bg-danger">Pre-order Unavailable</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="shop_menu_edit.php?f_id=<?php echo $f_id?>" 
               class="action-button primary">
                <i class="bi bi-pencil-square me-2"></i>Update Menu
            </a>
            <a href="shop_menu_delete.php?f_id=<?php echo $f_id?>" 
               class="action-button danger">
                <i class="bi bi-trash me-2"></i>Delete Menu
            </a>
        </div>
        <br><br>

        <!-- Statistics Section -->
        <section class="mb-5">
            <h2 class="mb-4">Performance Statistics</h2>
            <div class="row g-4">
                <?php
                // Customer Count
                $count_query = "SELECT COUNT(DISTINCT orh.c_id) AS cnt 
                               FROM order_header orh 
                               INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
                               WHERE ord.f_id = ?";
                $stmt = $mysqli->prepare($count_query);
                $stmt->bind_param("i", $f_id);
                $stmt->execute();
                $customer_count = $stmt->get_result()->fetch_array()["cnt"];
                
                // Order Count
                $order_query = "SELECT COUNT(*) AS cnt FROM order_detail WHERE f_id = ?";
                $stmt = $mysqli->prepare($order_query);
                $stmt->bind_param("i", $f_id);
                $stmt->execute();
                $order_count = $stmt->get_result()->fetch_array()["cnt"];
                
                // Revenue
                $revenue_query = "SELECT SUM(ord_buyprice * ord_amount) AS total 
                                FROM order_detail 
                                WHERE f_id = ?";
                $stmt = $mysqli->prepare($revenue_query);
                $stmt->bind_param("i", $f_id);
                $stmt->execute();
                $revenue = $stmt->get_result()->fetch_array()["total"] ?? 0;
                ?>

                <!-- Stats Cards -->
                <div class="col-md-4">
                    <div class="card stats-card">
                        <div class="stats-number"><?php echo $customer_count; ?></div>
                        <div class="stats-label">Unique Customers</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card stats-card">
                        <div class="stats-number"><?php echo $order_count; ?></div>
                        <div class="stats-label">Total Orders</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card stats-card">
                        <div class="stats-number"><?php echo number_format($revenue, 2); ?> Rs.</div>
                        <div class="stats-label">Total Revenue</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Orders Section -->
        <section>
            <h2 class="mb-4">Order History</h2>
            
            <!-- Search Form -->
            <form class="search-form" method="GET" action="shop_menu_detail.php">
                <input type="hidden" name="f_id" value="<?php echo $f_id; ?>">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Customer Name</label>
                        <select class="form-select" name="c_id">
                            <option value="">All Customers</option>
                            <?php
                            $customer_query = "SELECT DISTINCT c.c_id, c.c_firstname, c.c_lastname
                                             FROM order_header orh 
                                             INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
                                             INNER JOIN customer c ON orh.c_id = c.c_id 
                                             WHERE ord.f_id = ?
                                             ORDER BY c.c_firstname";
                            $stmt = $mysqli->prepare($customer_query);
                            $stmt->bind_param("i", $f_id);
                            $stmt->execute();
                            $customers = $stmt->get_result();
                            
                            while($customer = $customers->fetch_array()) {
                                $selected = (isset($_GET['c_id']) && $_GET['c_id'] == $customer['c_id']) ? 'selected' : '';
                                echo "<option value='{$customer['c_id']}' {$selected}>";
                                echo htmlspecialchars($customer['c_firstname'] . ' ' . $customer['c_lastname']);
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Order Status</label>
                        <select class="form-select" name="status">
                            <option value="">All Statuses</option>
                            <option value="ACPT" <?php echo (isset($_GET['status']) && $_GET['status'] == 'ACPT') ? 'selected' : ''; ?>>Accepted</option>
                            <option value="PREP" <?php echo (isset($_GET['status']) && $_GET['status'] == 'PREP') ? 'selected' : ''; ?>>Preparing</option>
                            <option value="RDPK" <?php echo (isset($_GET['status']) && $_GET['status'] == 'RDPK') ? 'selected' : ''; ?>>Ready for Pickup</option>
                            <option value="FNSH" <?php echo (isset($_GET['status']) && $_GET['status'] == 'FNSH') ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="d-grid gap-2">
                            <a href="shop_menu_detail.php?f_id=<?php echo $f_id; ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Clear Filters
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Search Orders
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Orders Table -->
            <?php
            // Build the query based on filters
            $orders_query = "SELECT 
                               orh.orh_id,
                               orh.orh_refcode,
                               orh.orh_ordertime,
                               c.c_firstname,
                               c.c_lastname,
                               orh.orh_orderstatus,
                               ord.ord_amount,
                               (ord.ord_buyprice * ord.ord_amount) as total_price
                           FROM order_header orh 
                           INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
                           INNER JOIN customer c ON orh.c_id = c.c_id 
                           WHERE ord.f_id = ?";

            $params = array($f_id);
            $types = "i";

            if (isset($_GET['c_id']) && !empty($_GET['c_id'])) {
                $orders_query .= " AND orh.c_id = ?";
                $params[] = $_GET['c_id'];
                $types .= "i";
            }

            if (isset($_GET['status']) && !empty($_GET['status'])) {
                $orders_query .= " AND orh.orh_orderstatus = ?";
                $params[] = $_GET['status'];
                $types .= "s";
            }

            $orders_query .= " ORDER BY orh.orh_ordertime DESC";

            $stmt = $mysqli->prepare($orders_query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $orders_result = $stmt->get_result();
            
            if ($orders_result->num_rows > 0):
            ?>
            <div class="card orders-table">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-header">
                            <tr>
                                <th>Reference Code</th>
                                <th>Order Date</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $orders_result->fetch_array()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order["orh_refcode"]); ?></td>
                                <td><?php echo date('M j, Y g:i A', strtotime($order["orh_ordertime"])); ?></td>
                                <td><?php echo htmlspecialchars($order["c_firstname"] . " " . $order["c_lastname"]); ?></td>
                                <td>
                                    <?php
                                    $status_classes = [
                                        'ACPT' => 'bg-info',
                                        'PREP' => 'bg-warning',
                                        'RDPK' => 'bg-primary',
                                        'FNSH' => 'bg-success'
                                    ];
                                    $status_labels = [
                                        'ACPT' => 'Accepted',
                                        'PREP' => 'Preparing',
                                        'RDPK' => 'Ready for Pickup',
                                        'FNSH' => 'Completed'
                                    ];
                                    ?>
                                    <span class="status-badge <?php echo $status_classes[$order["orh_orderstatus"]]; ?>">
                                        <?php echo $status_labels[$order["orh_orderstatus"]]; ?>
                                    </span>
                                </td>
                                <td><?php echo $order["ord_amount"]; ?></td>
                                <td><?php echo number_format($order["total_price"], 2); ?> Rs.</td>
                                <td>
                                    <a href="shop_order_detail.php?orh_id=<?php echo $order["orh_id"]; ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>No orders found matching your criteria.
            </div>
            <?php endif; ?>
        </section>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> CEC. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 150);
                }, 5000);
            });
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>
</html>