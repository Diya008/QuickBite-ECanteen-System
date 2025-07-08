<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start(); 
    include("../conn_db.php"); 

    // Authentication check
    if ($_SESSION["utype"] != "shopowner") {
        header("location: ../restricted.php");
        exit(1);
    }

    $s_id = $_SESSION["sid"];

    // Handle password update form submission
    if (isset($_POST["rst_confirm"])) {
        $oldpwd = $_POST["old_pwd"];
        $newpwd = $_POST["new_pwd"];
        $newcfpwd = $_POST["new_cfpwd"];

        if ($newpwd != $newcfpwd) {
            ?>
            <script>
                alert('The new password does not match.\nPlease try again.');
                history.back();
            </script>
            <?php
            exit(1);
        }

        $query = "SELECT s_pwd FROM shop WHERE s_id = ? LIMIT 0,1";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $s_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array();

        if ($oldpwd == $row["s_pwd"]) {
            $update_query = "UPDATE shop SET s_pwd = ? WHERE s_id = ?";
            $stmt = $mysqli->prepare($update_query);
            $stmt->bind_param("si", $newpwd, $s_id);
            $result = $stmt->execute();

            if ($result) {
                header("location: shop_profile.php?up_pwd=1");
            } else {
                header("location: shop_profile.php?up_pwd=0");
            }
        } else {
            ?>
            <script>
                alert('Your old password is incorrect.\nPlease try again.');
                history.back();
            </script>
            <?php
            exit(1);
        }
    }

    include('../head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <title>Update Shop Password</title>
    <style>
        body {
            background-color: #FFF5E4;
            min-height: 100vh;
        }

        .form-signin {
            max-width: 500px;
            padding: 2rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            padding: 0.75rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
        }

        .smaller-font {
            font-size: 0.875rem;
            color: #6c757d;
        }

        footer {
            background-color: #CD5C08;
            color: #FFF5E4;
            padding: 1rem;
            margin-top: auto;
        }

        footer p {
            margin: 0;
        }

        .text-bold {
            color: #333;
            font-weight: 600;
        }

        .bi {
            font-size: 1.2rem;
        }
    </style>
</head>

<body class="d-flex flex-column">
    <?php include('nav_header_shop.php') ?>

    <div class="container">
        <div class="form-signin">
            <form method="POST" action="shop_update_pwd.php" class="form-floating">
                <h2 class="mt-4 mb-4 text-bold text-center">
                    Update Shop Password
                </h2>

                <div class="form-floating">
                    <input type="password" 
                           class="form-control" 
                           id="old_pwd" 
                           minlength="8" 
                           maxlength="45" 
                           placeholder="Old Password" 
                           name="old_pwd"
                           required>
                    <label for="old_pwd">Old Password</label>
                </div>

                <div class="form-floating">
                    <input type="password" 
                           class="form-control" 
                           id="rst_pwd" 
                           minlength="8" 
                           maxlength="45" 
                           placeholder="New Password" 
                           name="new_pwd"
                           required>
                    <label for="rst_pwd">New Password</label>
                </div>

                <div class="form-floating">
                    <input type="password" 
                           class="form-control" 
                           id="rst_cfpwd" 
                           minlength="8" 
                           maxlength="45" 
                           placeholder="Confirm New Password"
                           name="new_cfpwd" 
                           required>
                    <label for="rst_cfpwd">Confirm New Password</label>
                    <div id="passwordHelpBlock" class="form-text smaller-font mt-2">
                        Password must be at least 8 characters long
                    </div>
                </div>

                <button class="w-100 btn  mt-4" 
                        name="rst_confirm" 
                        type="submit"
                        style="background-color: #6A9C89" 
                        onclick="return confirm('Do you want to update the shop password?');">
                    Update Password
                </button>
            </form>
        </div>
    </div>

    <footer class="text-center">
        <div class="container">
            <p>© 2024 CEC. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>