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
    <title>Shop Profile</title>
    <style>
        :root {
            --primary-color: #CD5C08;
            --secondary-color: #6A9C89;
            --background-color: #FFF5E4;
            --text-color: #333;
            --card-background: #ffffff;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-card {
            background-color: var(--card-background);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .shop-image {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .profile-header {
            border-bottom: 2px solid var(--primary-color);
            margin-bottom: 2rem;
            padding-bottom: 1rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover, .btn-secondary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            margin-right: 0.5rem;
        }

        .profile-label {
            font-weight: 600;
            color: var(--primary-color);
        }

        .notification {
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            position: relative;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_shop.php');?>

    <div class="container px-4 py-5" id="profile-body">
        <?php 
            if(isset($_GET["up_pwd"])){
                if($_GET["up_pwd"]==1){
        ?>
        <div class="notification bg-success text-white">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                </svg>
                <span class="ms-2">Successfully updated the password!</span>
            </div>
            <a href="shop_profile.php" class="text-white text-decoration-none">×</a>
        </div>
        <?php } else { ?>
        <div class="notification bg-danger text-white">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
                <span class="ms-2">Failed to update the password.</span>
            </div>
            <a href="shop_profile.php" class="text-white text-decoration-none">×</a>
        </div>
        <?php }
            }
        ?>

        <?php
            //Select customer record from database
            $query = "SELECT s_username,s_name,s_location,s_openhour,s_closehour,s_status,s_preorderstatus,s_email,s_phoneno,s_pic FROM shop WHERE s_id = {$s_id} LIMIT 0,1";
            $result = $mysqli->query($query);
            $row = $result->fetch_array();
        ?>

        <div class="profile-card">
            <div class="profile-header">
                <h2 class="display-6">Shop Profile</h2>
            </div>

            <div class="shop-image" style="
                background: url(<?php echo is_null($row["s_pic"]) ? '../img/default.png' : '../img/'.$row['s_pic']; ?>) center;
                height: 250px;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;">
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <p><span class="profile-label">Username:</span> <?php echo $row["s_username"];?></p>
                    <p><span class="profile-label">Shop Name:</span> <?php echo $row["s_name"];?></p>
                    <p><span class="profile-label">E-mail:</span> <?php echo $row["s_email"];?></p>
                    <p><span class="profile-label">Phone:</span> <?php echo "(+91) ".$row["s_phoneno"];?></p>
                </div>
                <div class="col-md-6">
                    <p><span class="profile-label">Opening Hours:</span>
                        <?php 
                        $current_time = date('H:i:s');
                        
                        $open = explode(":",$row["s_openhour"]);
                        $close = explode(":",$row["s_closehour"]);
                        echo $open[0].":".$open[1]." - ".$close[0].":".$close[1];
                        ?>
                    </p><br>
                    <p><span class="profile-label">Operation Status:</span><br><br>
                        <?php if($row["s_status"]==1){ ?>
                            <span class="status-badge " style="background-color: #6A9C89; color: #FFF5E4">Available for Store-Front</span><br><br>
                        <?php } else { ?>
                            <span class="status-badge " style="background-color: #CD5C08; color: #FFF5E4">Unavailable for Store-Front</span><br><br>
                        <?php }
                        if($row["s_preorderstatus"]==1){ ?>
                            <span class="status-badge" style="background-color: #6A9C89; color: #FFF5E4">Available for Pre-Order</span><br>
                        <?php } else { ?>
                            <span class="status-badge " style="background-color: #CD5C08; color: #FFF5E4">Unavailable for Pre-Order</span><br>
                        <?php } ?>
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <a class="btn btn-secondary me-2" href="shop_update_pwd.php">Change Password</a>
                <a class="btn btn-primary" href="shop_profile_edit.php">Update Profile</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p class="mb-0">CEC</p>
    </footer>
</body>
</html>