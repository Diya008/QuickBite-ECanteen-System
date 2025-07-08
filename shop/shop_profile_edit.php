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

    // Handle form submission
    if (isset($_POST["upd_confirm"])) {
        // Process form data
        $s_status = isset($_POST["s_status"]) ? 1 : 0;
        $s_preorderstatus = isset($_POST["s_preorderstatus"]) ? 1 : 0;
        $s_name = $_POST["s_name"];
        $s_username = $_POST["s_username"];
        $s_location = $_POST["s_location"];
        $s_email = $_POST["s_email"];
        $s_phoneno = $_POST["s_phoneno"];
        $s_openhour = $_POST["s_openhour"];
        $s_closehour = $_POST["s_closehour"];

        // Update shop information
        $update_query = "UPDATE shop SET 
            s_username = ?, 
            s_name = ?, 
            s_location = ?, 
            s_openhour = ?, 
            s_closehour = ?, 
            s_email = ?, 
            s_phoneno = ?, 
            s_status = ?, 
            s_preorderstatus = ?
            WHERE s_id = ?";

        $stmt = $mysqli->prepare($update_query);
        $stmt->bind_param("sssssssiis", 
            $s_username, $s_name, $s_location, $s_openhour, 
            $s_closehour, $s_email, $s_phoneno, $s_status, 
            $s_preorderstatus, $s_id
        );
        $update_result = $stmt->execute();

        // Handle image upload
        if (!empty($_FILES["s_pic"]["name"])) {
            $target_dir = '/img/';
            $temp = explode(".", $_FILES["s_pic"]["name"]);
            $target_newfilename = "shop" . $s_id . "." . strtolower(end($temp));
            $target_file = $target_dir . $target_newfilename;

            if (move_uploaded_file($_FILES["s_pic"]["tmp_name"], SITE_ROOT . $target_file)) {
                $img_query = "UPDATE shop SET s_pic = ? WHERE s_id = ?";
                $stmt = $mysqli->prepare($img_query);
                $stmt->bind_param("si", $target_newfilename, $s_id);
                $update_result = $stmt->execute();
            } else {
                $update_result = false;
            }
        }

        // Redirect based on update result
        if ($update_result) {
            $_SESSION["shopname"] = $s_name;
            header("location: shop_profile.php?up_prf=1");
        } else {
            header("location: shop_profile.php?up_prf=0");
        }
        exit(1);
    }

    include('../head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <title>Update Shop Profile</title>
    <style>
        body {
            background-color: #FFF5E4;
            min-height: 100vh;
        }

        .form-signin {
            max-width: 600px;
            padding: 2rem;
            margin: auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .form-check {
            margin-bottom: 1rem;
        }

        .footer {
            background-color: #CD5C08;
            color: #FFF5E4;
            padding: 1rem;
            margin-top: auto;
        }
    </style>
</head>

<body class="d-flex flex-column">
    <?php include('nav_header_shop.php')?>

    <div class="container form-signin mt-4">
        <?php 
        // Fetch shop data
        $query = "SELECT s_username, s_name, s_location, s_openhour, s_closehour, 
                         s_status, s_preorderstatus, s_email, s_phoneno 
                  FROM shop WHERE s_id = ? LIMIT 1";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $s_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array();
        ?>

        <form method="POST" action="shop_profile_edit.php" class="form-floating" enctype="multipart/form-data">
            <h2 class="mb-4 text-center fw-bold">Update Shop Information</h2>
            
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="shopstatus"
                    name="s_status" <?php echo $row["s_status"] ? "checked" : ""; ?>>
                <label class="form-check-label" for="shopstatus">Opening for today</label>
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="shoppreorderstatus" 
                    name="s_preorderstatus" <?php echo $row["s_preorderstatus"] ? "checked" : ""; ?>>
                <label class="form-check-label" for="shoppreorderstatus">Accepting Pre-Order</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="shopusername" placeholder="Username" 
                    name="s_username" value="<?php echo htmlspecialchars($row["s_username"]); ?>" required>
                <label for="shopusername">Username</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="shopname" placeholder="Shop Name" 
                    name="s_name" value="<?php echo htmlspecialchars($row["s_name"]); ?>" required>
                <label for="shopname">Shop Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="E-mail" 
                    name="s_email" value="<?php echo htmlspecialchars($row["s_email"]); ?>" required>
                <label for="email">E-mail</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="shopphoneno" placeholder="Phone Number" 
                    name="s_phoneno" value="<?php echo htmlspecialchars($row["s_phoneno"]); ?>" required>
                <label for="shopphoneno">Phone Number</label>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="time" class="form-control" id="shopopenhour" placeholder="Open Hour" 
                            name="s_openhour" value="<?php echo $row["s_openhour"]; ?>" required>
                        <label for="shopopenhour">Open Hour</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="time" class="form-control" id="shopclosehour" placeholder="Close Hour" 
                            name="s_closehour" value="<?php echo $row["s_closehour"]; ?>" required>
                        <label for="shopclosehour">Close Hour</label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="s_pic" class="form-label">Upload shop image</label>
                <input class="form-control" type="file" id="s_pic" name="s_pic" accept="image/*">
            </div>

            <button class="w-100 btn btn-primary btn-lg mb-3" name="upd_confirm" type="submit">
                Update Shop Profile
            </button>
        </form>
    </div>

    <footer class="footer text-center mt-auto">
        <p class="mb-0">CEC</p>
    </footer>
</body>
</html>