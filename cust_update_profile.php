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

    // Handle profile update submission
    if (isset($_POST["upd_confirm"])) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        
        $query = "UPDATE customer 
                 SET c_firstname = '{$firstname}', 
                     c_lastname = '{$lastname}', 
                     c_email = '{$email}' 
                 WHERE c_id = {$_SESSION['cid']}";
        
        $result = $mysqli->query($query);
        
        if ($result) {
            $_SESSION["firstname"] = $firstname;
            $_SESSION["lastname"] = $lastname;
            header("location: cust_profile.php?up_prf=1");
        } else {
            header("location: cust_profile.php?up_prf=0");
        }
        exit(1);
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
            margin-bottom: 1.5rem;
        }

        .form-control:focus {
            border-color: #CD5C08;
            box-shadow: 0 0 0 0.2rem rgba(205, 92, 8, 0.25);
        }

        .form-control {
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-success {
            background-color: #CD5C08;
            border-color: #CD5C08;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #B54F07;
            border-color: #B54F07;
            transform: translateY(-1px);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 2rem;
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
    <title>Update Profile</title>
</head>
<body>
    <?php include('nav_header.php')?>
<br><br>
    <div class="container">
        <?php 
        // Select customer record from database
        $query = "SELECT c_firstname, c_lastname, c_email 
                 FROM customer 
                 WHERE c_id = {$_SESSION['cid']} 
                 LIMIT 0,1";
        $result = $mysqli->query($query);
        $row = $result->fetch_array();
        ?>

        <form method="POST" action="cust_update_profile.php" class="form-signin">
            <h2 class="fw-bold">Update Profile</h2>
            
            <div class="form-floating">
                <input type="text" 
                       class="form-control" 
                       id="firstname" 
                       placeholder="First Name" 
                       name="firstname"
                       value="<?php echo htmlspecialchars($row["c_firstname"]); ?>" 
                       required>
                <label for="firstname">First Name</label>
            </div>

            <div class="form-floating">
                <input type="text" 
                       class="form-control" 
                       id="lastname" 
                       placeholder="Last Name" 
                       name="lastname"
                       value="<?php echo htmlspecialchars($row["c_lastname"]); ?>" 
                       required>
                <label for="lastname">Last Name</label>
            </div>

            <div class="form-floating">
                <input type="email" 
                       class="form-control" 
                       id="email" 
                       placeholder="E-mail" 
                       name="email"
                       value="<?php echo htmlspecialchars($row["c_email"]); ?>" 
                       required>
                <label for="email">E-mail</label>
            </div>
           
            <button class="w-100 btn btn-success" 
                    name="upd_confirm" 
                    type="submit">
                Update Profile
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