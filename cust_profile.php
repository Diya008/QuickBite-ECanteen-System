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
    <link href="css/main.css" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
    <title>My Profile</title>
</head>

<body style="background-color: #FFF5E4">
    <?php include('nav_header.php')?>

    <div style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
        <!-- Notifications -->
        <?php if(isset($_GET["up_pwd"])){ ?>
            <div style="margin-bottom: 20px;">
                <?php if($_GET["up_pwd"]==1){ ?>
                    <div style="background-color: #D4EDDA; color: #155724; padding: 15px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                            <span style="margin-left: 10px;">Successfully updated your password!</span>
                        </div>
                        <a href="cust_profile.php" style="color: #155724; text-decoration: none;">×</a>
                    </div>
                <?php } else { /* Error notification styling... */ } ?>
            </div>
        <?php } ?>

        <!-- Profile Header -->
        <div style="text-align: center; margin-bottom: 40px;">
            <div style="width: 100px; height: 100px; background-color: #6A9C89; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                <span style="color: white; font-size: 40px;"><?php echo strtoupper(substr($_SESSION["firstname"], 0, 1)); ?></span>
            </div>
            <h2 style="color: #2C3639; font-size: 28px; margin: 0;">My Profile</h2>
        </div>

        <!-- Profile Card -->
        <?php
        $query = "SELECT c_username,c_firstname,c_lastname,c_email FROM customer WHERE c_id = {$_SESSION['cid']} LIMIT 0,1";
        $result = $mysqli->query($query);
        $row = $result->fetch_array();
        ?>
        <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); margin-bottom: 30px;">
            <div style="margin-bottom: 25px;">
                <div style="display: flex; margin-bottom: 20px;">
                    <div style="width: 120px; color: #666;">Username</div>
                    <div style="flex: 1; color: #2C3639; font-weight: 500;"><?php echo $row["c_username"]; ?></div>
                </div>
                <div style="display: flex; margin-bottom: 20px;">
                    <div style="width: 120px; color: #666;">Name</div>
                    <div style="flex: 1; color: #2C3639; font-weight: 500;"><?php echo $_SESSION["firstname"]." ".$_SESSION["lastname"]; ?></div>
                </div>
                <div style="display: flex;">
                    <div style="width: 120px; color: #666;">Email</div>
                    <div style="flex: 1; color: #2C3639; font-weight: 500;"><?php echo $row["c_email"]; ?></div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="cust_update_pwd.php" style="flex: 1; min-width: 200px; padding: 12px 20px; background-color: #C1D8C3; color: #2C3639; text-decoration: none; border-radius: 8px; text-align: center; font-weight: 500; transition: opacity 0.2s;">Change Password</a>
            <a href="cust_update_profile.php" style="flex: 1; min-width: 200px; padding: 12px 20px; background-color: #6A9C89; color: white; text-decoration: none; border-radius: 8px; text-align: center; font-weight: 500; transition: opacity 0.2s;">Update Profile</a>
            <a href="cust_order_history.php" style="flex: 1; min-width: 200px; padding: 12px 20px; background-color: #CD5C08; color: white; text-decoration: none; border-radius: 8px; text-align: center; font-weight: 500; transition: opacity 0.2s;">Order History</a>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background-color: #CD5C08; color: #FFF5E4; text-align: center; padding: 15px; bottom: 0; width: 100%;">
        <p style="margin: 0;">CEC</p>
    </footer>
</body>
</html>