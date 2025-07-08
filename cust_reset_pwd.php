<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        session_start(); 
        include("conn_db.php"); 
        include('head.php');

        if (isset($_POST["rst_confirm"])) {
            $cust_id = $_POST['cust_id'];
            $newpwd = $_POST['new_pwd'];
            $newcfpwd = $_POST['new_cfpwd'];

            if ($newpwd === $newcfpwd) {
                // Use prepared statements to prevent SQL injection
                $query = "UPDATE customer SET c_pwd = ? WHERE c_id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('si', $newpwd, $cust_id);
                $result = $stmt->execute();

                if ($result) {
                    header("Location: cust_reset_success.php");
                    exit();
                } else {
                    echo "<script>
                        alert('Error: Password reset failed. Please try again.');
                        window.location.href = 'cust_reset_fail.php';
                    </script>";
                    exit();
                }
            } else {
                echo "<script>
                    alert('Error: Passwords do not match.');
                    window.location.href = 'cust_reset_fail.php';
                </script>";
                exit();
            }
        } else {
            $cust_un = $_POST["fp_username"];
            $cust_em = $_POST["fp_email"];
            $query = "SELECT c_firstname, c_lastname, c_id FROM customer WHERE c_username = ? AND c_email = ? LIMIT 1";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ss', $cust_un, $cust_em);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                echo "<script>
                    alert('There is no account associated with this username and email.');
                    history.back();
                </script>";
                exit(1);
            } else {
                $row = $result->fetch_assoc();
                $cust_id = $row["c_id"];
                $cust_fn = $row["c_firstname"];
                $cust_ln = $row["c_lastname"];
            }
        }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        :root {
            --primary-color: #CD5C08;
            --bg-color: #FFF5E4;
            --text-color: #333;
            --input-bg: #ffffff;
            --shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .container {
            max-width: 450px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: var(--input-bg);
            border-radius: 10px;
            box-shadow: var(--shadow);
        }

        .form-signin {
            width: 100%;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 1rem;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(205, 92, 8, 0.2);
        }

        .btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #B54E07;
        }

        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2rem;
        }

        p {
            text-align: center;
            color: #666;
        }

        footer {
            margin-top: auto;
            background-color: var(--primary-color);
            color: var(--bg-color);
            padding: 1rem;
            text-align: center;
        }

        footer p {
            margin: 0;
            color: var(--bg-color);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #555;
        }
    </style>
</head>
<body>
    <?php include('nav_header.php'); ?>
    <br>
    <br><br><br>
    
    <div class="container">
        <form method="POST" action="cust_reset_pwd.php" class="form-signin">
            <h2>Reset Password</h2>
            <p>Enter your new password below.<br>
            Account: <?php echo htmlspecialchars($cust_fn . " " . $cust_ln); ?></p>
            
            <div class="form-floating">
                <label for="rst_pwd" class="form-label">New Password</label><br><br>
                <input type="password" class="form-control" id="rst_pwd" minlength="8" maxlength="45" 
                    placeholder="Enter new password" name="new_pwd" required>
            </div>
            
            <div class="form-floating">
                <label for="rst_cfpwd" class="form-label">Confirm New Password</label><br><br>
                <input type="password" class="form-control" id="rst_cfpwd" minlength="8" maxlength="45" 
                    placeholder="Confirm new password" name="new_cfpwd" required>
            </div>
            
            <input type="hidden" name="cust_id" value="<?php echo htmlspecialchars($cust_id); ?>">
            <button class="btn" name="rst_confirm" type="submit">Reset Password</button>
        </form>
    </div>

    <footer>
        <p>CEC</p>
    </footer>
</body>
</html>
