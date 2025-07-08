<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start(); 
    include("conn_db.php"); 

    // Check if user is logged in
    if (!isset($_SESSION["cid"])) {
        header("location: restricted.php");
        exit(1);
    }

    // Handle password update submission
    if (isset($_POST["rst_confirm"])) {
        $oldpwd = $_POST["old_pwd"];
        $newpwd = $_POST["new_pwd"];
        $newcfpwd = $_POST["new_cfpwd"];

        // Validate password match
        if ($newpwd != $newcfpwd) {
    ?>
        <script>
            alert('Your new password does not match.\nPlease re-enter again.');
            history.back();
        </script>
    <?php
        exit(1);
        } else {
            $query = "SELECT c_pwd FROM customer WHERE c_id = {$_SESSION['cid']} LIMIT 0,1";
            $result = $mysqli->query($query);
            $row = $result->fetch_array();

            if ($oldpwd == $row["c_pwd"]) {
                $query = "UPDATE customer SET c_pwd = '{$newpwd}' WHERE c_id = {$_SESSION['cid']}";
                $result = $mysqli->query($query);
                
                if ($result) {
                    header("location: cust_profile.php?up_pwd=1");
                } else {
                    header("location: cust_profile.php?up_pwd=0");
                }
            } else {
    ?>
            <script>
                alert('Your old password does not match.\nPlease re-enter again.');
                history.back();
            </script>
    <?php
            exit(1);
            }
        }
    }
    include('head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .form-signin {
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-control:focus {
            border-color: #CD5C08;
            box-shadow: 0 0 0 0.2rem rgba(205, 92, 8, 0.25);
        }

        .btn-success {
            background-color: #CD5C08;
            border-color: #CD5C08;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #B54F07;
            border-color: #B54F07;
        }

        .smaller-font {
            font-size: 0.875rem;
            color: #6c757d;
        }

        footer {
            margin-top: auto;
            background-color: #CD5C08;
            color: #FFF5E4;
            padding: 1rem 0;
        }

        footer p {
            margin: 0;
        }
    </style>
    <title>Update Password</title>
</head>
<body>
    <?php include('nav_header.php') ?>
    <br>
    <br>
    <br>
    

    <div class="container">
        <form method="POST" action="cust_update_pwd.php" class="form-signin">
            <h2 class="text-center mb-4 fw-bold">Update Password</h2>
            
            <div class="form-floating">
                <input type="password" 
                       class="form-control" 
                       id="old_pwd" 
                       name="old_pwd"
                       minlength="8" 
                       maxlength="45" 
                       placeholder="Old Password" 
                       required>
                <label for="old_pwd">Old Password</label>
            </div>

            <div class="form-floating">
                <input type="password" 
                       class="form-control" 
                       id="rst_pwd" 
                       name="new_pwd"
                       minlength="8" 
                       maxlength="45" 
                       placeholder="New Password" 
                       required>
                <label for="rst_pwd">New Password</label>
            </div>

            <div class="form-floating">
                <input type="password" 
                       class="form-control" 
                       id="rst_cfpwd" 
                       name="new_cfpwd"
                       minlength="8" 
                       maxlength="45" 
                       placeholder="Confirm New Password" 
                       required>
                <label for="rst_cfpwd">Confirm New Password</label>
                <div id="passwordHelpBlock" class="form-text smaller-font mt-2">
                    Your password must be at least 8 characters long.
                </div>
            </div>

            <button class="w-100 btn btn-success mt-4" 
                    name="rst_confirm" 
                    type="submit" 
                    onclick="return confirm('Do you want to update your password?');">
                Update Password
            </button>
        </form>
    </div>

    <footer class="text-center">
        <div class="container">
            <p>CEC</p>
        </div>
    </footer>
</body>
</html>