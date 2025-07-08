<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start(); 
        if($_SESSION["utype"]!="shopowner"){
            header("location: ../restricted.php");
            exit(1);
        }
        include("../conn_db.php"); 
        include('../head.php');
        $s_id = $_SESSION["sid"];
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <title>Shop Owner Home</title>
    <style>
        .dashboard-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border-radius: 15px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .stats-card {
            background: linear-gradient(145deg, #CD5C08, #e67e22);
            color: white;
        }

        .hero-section {
            position: relative;
            padding: 4rem 0;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../img/hero-image.jpg');
            background-size: cover;
            background-position: center;
            color: #FFF5E4;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            background: #FFF5E4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: #CD5C08;
        }

        .display-5 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #CD5C08;
        }

        .btn-custom {
            background-color: #CD5C08;
            color: #FFF5E4;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .btn-custom:hover {
            background-color: #b54e07;
            color: #FFF5E4;
        }

        .footer-custom {
            background-color: #CD5C08;
            color: #FFF5E4;
            padding: 1rem 0;
            margin-top: 2rem;
        }
    </style>
</head>

<body class="d-flex flex-column h-100" style="background-color: #FFF5E4">
    <?php include('nav_header_shop.php'); ?>

    <div class="hero-section text-center mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold"><?php echo $_SESSION["shopname"]?></h1>
            <h2 class="display-6">Welcome to QuickBite</h2>
            <p class="lead">Online Food ordering system</p>
        </div>
    </div>

    <div class="container p-4" id="shop-dashboard">
        <h2 class="border-bottom pb-2 mb-4">
            <i class="bi bi-speedometer2"></i> Shop Dashboard
            <span class="small fw-light"><?php echo date('F j, Y');?></span>
        </h2>

        <div class="row g-4">
            <!-- Today's Orders Card -->
            <div class="col-md-6">
                <div class="dashboard-card stats-card p-4">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                            <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                        </svg>
                    </div>
                    <h3 class="h5 mb-3">Today Completed Orders</h3>
                    <p class="display-5 mb-0" style="color: white">
                        <?php 
                            $query = "SELECT COUNT(*) AS cnt_order FROM order_header WHERE s_id = {$s_id} AND DATE(orh_pickuptime) = CURDATE() AND orh_orderstatus = 'FNSH';";
                            $result = $mysqli -> query($query) -> fetch_array();
                            echo $result["cnt_order"];
                        ?>
                        <span class="fs-6" style="color: white">Orders</span>
                    </p>
                </div>
            </div>

            <!-- Today's Revenue Card -->
            <div class="col-md-6">
                <div class="dashboard-card stats-card p-4">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                        </svg>
                    </div>
                    <h3 class="h5 mb-3">Today Revenue</h3>
                    <p class="display-5 mb-0" style="color: white">$
                        <?php 
                            $query = "SELECT SUM(ord.ord_buyprice*ord.ord_amount) AS revenue FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id WHERE orh.s_id = {$s_id} AND DATE(orh.orh_pickuptime) = CURDATE() AND orh.orh_orderstatus = 'FNSH';";
                            $result = $mysqli -> query($query) -> fetch_array();
                            if(!is_null($result["revenue"])){echo $result["revenue"];}else{echo "0.00";}
                        ?>
                    </p>
                </div>
            </div>

            <!-- Remaining Orders Card -->
            <div class="col-md-6">
                <a href="shop_order_list.php" class="text-decoration-none">
                    <div class="dashboard-card p-4">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                        </div>
                        <h3 class="h5 mb-3 text-dark">Remaining Orders</h3>
                        <p class="h4 mb-3 text-dark">
                            <?php 
                                $query = "SELECT COUNT(*) AS cnt_remain FROM order_header WHERE s_id = {$s_id} AND orh_orderstatus NOT LIKE 'FNSH';";
                                $result = $mysqli -> query($query) -> fetch_array();
                                echo $result["cnt_remain"];
                            ?>
                            <span class="fs-6">orders remaining</span>
                        </p>
                        <button class="btn btn-custom">View Orders</button>
                    </div>
                </a>
            </div>

            <!-- Menu Items Card -->
            <div class="col-md-6">
                <a href="shop_menu_list.php" class="text-decoration-none">
                    <div class="dashboard-card p-4">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-menu-button" viewBox="0 0 16 16">
                                <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h8A1.5 1.5 0 0 1 11 1.5v2A1.5 1.5 0 0 1 9.5 5h-8A1.5 1.5 0 0 1 0 3.5v-2zM1.5 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-8z"/>
                                <path d="m7.823 2.823-.396-.396A.25.25 0 0 1 7.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2H1zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2h14zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </div>
                        <h3 class="h5 mb-3 text-dark">Available Menu Items</h3>
                        <p class="h4 mb-3 text-dark">
                            <?php
                                $query = "SELECT COUNT(*) AS cnt_menu FROM food f INNER JOIN shop s ON f.s_id = s.s_id WHERE (s.s_status = 1 AND (CURTIME() BETWEEN s.s_openhour AND s.s_closehour) AND f.f_todayavail = 1) OR (s.s_preorderstatus = 1 AND f.f_preorderavail = 1) AND s.s_id = {$s_id};";
                                $result = $mysqli -> query($query) -> fetch_array();
                                echo $result["cnt_menu"];
                            ?>
                            <span class="fs-6">items available</span>
                        </p>
                        <button class="btn btn-custom">View Menu</button>
                    </div>
                </a>
            </div>

            <!-- Feedback Card -->
            <div class="col-12">
                <a href="shop_feedback.php" class="text-decoration-none">
                    <div class="dashboard-card p-4">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                            </svg>
                        </div>
                        <h3 class="h5 mb-3 text-dark">Customer Feedback</h3>
                        <button class="btn btn-custom">View Feedback</button>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <footer class="footer-custom text-center mt-auto">
        <div class="container">
            <p class="mb-0">CEC © 2025</p>
        </div>
    </footer>

    <!-- Optional: Add smooth scroll behavior -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>