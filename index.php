<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); include("conn_db.php"); include('head.php');?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E4;
            min-height: 100vh;
        }

        .hero {
            height: 60vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('img/hero-image.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #FFF5E4;
            margin-bottom: 2rem;
        }

        .hero h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #CD5C08;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            padding: 1rem 0;
        }

        .shop-card {
            position: relative;
            height: 280px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-size: cover;
            background-position: center;
        }

        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 20px;
            color: white;
        }

        .shop-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .badge {
            background: #CD5C08;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-right: 8px;
            display: inline-block;
        }

        .badge.preorder {
            background: #6A9C89;
        }

        .hours {
            margin: 12px 0;
            opacity: 0.9;
        }

        .shop-btn {
            display: inline-block;
            background: #6A9C89;
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .shop-btn:hover {
            background: #5a8b78;
            transform: translateY(-2px);
        }

        footer {
            background: #CD5C08;
            color: #FFF5E4;
            text-align: center;
            padding: 1rem;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            .cards-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <title>QuickBite</title>
</head>

<body>
    <?php include('nav_header.php')?>

    <div class="hero">
        <h1>
            <?php 
            if (isset($_SESSION["firstname"]) && !empty($_SESSION["firstname"])) {
                echo "Hi " . htmlspecialchars($_SESSION["firstname"]) . ", Welcome to QuickBite";
            } else {
                echo "Welcome to QuickBite";
            }
            ?>
        </h1>
    </div>

    <div class="container">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#CD5C08" stroke-width="2">
                <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2M7 2v20M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
            </svg>
            <h2>Canteen & Mess</h2>
        </div>

        <div class="cards-grid">
            <?php
            $query = "SELECT s_id,s_name,s_openhour,s_closehour,s_status,s_preorderstatus,s_pic FROM shop
            WHERE (s_preorderstatus = 1) OR (s_preorderstatus = 0 AND (CURTIME() BETWEEN s_openhour AND s_closehour));";
            $result = $mysqli -> query($query);
            if($result -> num_rows > 0){
                while($row = $result -> fetch_array()){
            ?>
            <div class="shop-card" style="background-image: url('img/<?php echo $row['s_pic']; ?>')">
                <div class="card-overlay">
                    <h3 class="shop-title"><?php echo $row["s_name"]?></h3>
                    <div>
                        <?php 
                        $now = date('H:i:s');
                        if((($now < $row["s_openhour"])||($now > $row["s_closehour"]))||($row["s_status"]==0)){
                            echo '<span class="badge">Closed</span>';
                        } else {
                            echo '<span class="badge">Open</span>';
                        }
                        echo $row["s_preorderstatus"] == 1 ? 
                            '<span class="badge preorder">Pre-order Available</span>' : 
                            '<span class="badge">Pre-order Unavailable</span>';
                        ?>
                    </div>
                    <p class="hours">
                        Open hours: <?php echo substr($row["s_openhour"], 0, 5)." - ".substr($row["s_closehour"], 0, 5);?>
                    </p>
                    <div style="text-align: right">
                        <a href="<?php echo 'shop_menu.php?s_id='.$row['s_id']; ?>" class="shop-btn">Go to shop</a>
                    </div>
                </div>
            </div>
            <?php 
                }
            } else {
                echo '<div style="text-align: center; padding: 2rem; background: #fee2e2; color: #991b1b; border-radius: 8px;">
                        No shop currently available to order.
                      </div>';
            }
            $result -> free_result();
            ?>
        </div>
    </div>

    <footer>
        <p>CEC</p>
    </footer>
</body>
</html>