<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        session_start(); 
        include("../conn_db.php"); 
        if($_SESSION["utype"]!="shopowner"){
            header("location: ../restricted.php");
            exit(1);
        }
        $s_id = $_SESSION["sid"];
        if(isset($_POST["upd_confirm"])){
            $f_id = $_POST["f_id"];
            if(isset($_POST["f_todayavail"])){$f_todayavail = 1;}else{$f_todayavail = 0;}
            if(isset($_POST["f_preorderavail"])){$f_preorderavail = 1;}else{$f_preorderavail = 0;}
            $f_name = $_POST["f_name"];
            $f_price = $_POST["f_price"];
            $veg_nveg=$_POST["veg_nveg"];
            $f_quantity = $_POST["f_quantity"];
            
            $update_query = "UPDATE food SET f_name = '{$f_name}', f_price = '{$f_price}', f_quantity = '{$f_quantity}',veg_nveg = '{$veg_nveg}', f_todayavail = '{$f_todayavail}', f_preorderavail = '{$f_preorderavail}' WHERE f_id = {$f_id};";
            $update_result = $mysqli -> query($update_query);
            
            if(!empty($_FILES["f_pic"]["name"])){
                $target_dir = '/img/';
                $temp = explode(".",$_FILES["f_pic"]["name"]);
                $target_newfilename = $f_id."_".$s_id.".".strtolower(end($temp));
                $target_file = $target_dir.$target_newfilename;
                if(move_uploaded_file($_FILES["f_pic"]["tmp_name"],SITE_ROOT.$target_file)){
                    $update_query = "UPDATE food SET f_pic = '{$target_newfilename}' WHERE f_id = {$f_id};";
                    $update_result = $mysqli -> query($update_query);
                }else{
                    $update_result = false;
                }
            }
            if($update_result){
                header("location: shop_menu_detail.php?f_id={$f_id}&up_fdt=1");
            } else {
                header("location: shop_menu_detail.php?f_id={$f_id}&up_fdt=0");
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #CD5C08;
            --bg-color: #FFF5E4;
            --text-color: #2C3333;
            --hover-color: #E89B4B;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .form-signin {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: var(--box-shadow);
            margin: 3rem auto;
            max-width: 600px;
            width: 90%;
        }

        .form-signin h2 {
            color: var(--primary-color);
            font-weight: 700;
            text-align: center;
            margin-bottom: 2.5rem;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            color: var(--text-color);
            background-color: #fff;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(205, 92, 8, 0.15);
            outline: none;
        }

        .form-check {
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-check:hover {
            background: #f0f1f2;
        }

        .form-check-input {
            width: 2.5em !important;
            height: 1.5em !important;
            margin-right: 1em;
            cursor: pointer;
        }

        .form-check-label {
            font-weight: 500;
            cursor: pointer;
        }

        select.form-control {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23CD5C08' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 12px;
            padding-right: 2.5rem;
        }

        .file-upload {
            margin-bottom: 2rem;
        }

        .file-upload .form-control {
            padding: 0.75rem;
            background: #f8f9fa;
        }

        .btn-success {
            background: var(--primary-color);
            border: none;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 10px;
            width: 100%;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
        }

        .form-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 1rem;
            pointer-events: none;
            transform-origin: 0 0;
            transition: opacity .1s ease-in-out,transform .1s ease-in-out;
            color: #6c757d;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
            background: white;
            padding: 0 0.5rem;
        }

        footer {
            background: var(--primary-color);
            padding: 1rem;
            margin-top: auto;
            text-align: center;
            color: white;
        }

        /* Custom styling for number inputs */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <title>Update Menu Detail</title>
</head>

<body>
    <?php include('nav_header_shop.php')?>

    <div class="container">
        <?php 
            $f_id = $_GET["f_id"];
            $query = "SELECT * FROM food WHERE f_id = {$f_id} LIMIT 0,1";
            $result = $mysqli ->query($query);
            $row = $result -> fetch_array();
        ?>
        <form method="POST" action="shop_menu_edit.php" class="form-signin" enctype="multipart/form-data">
            <h2><i class="bi bi-pencil-square me-2"></i>Update Menu Detail</h2>
            
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="f_todayavail"
                name="f_todayavail" <?php if($row["f_todayavail"]){echo "checked";} ?>>
                <label class="form-check-label" for="f_todayavail">Menu Available for Today</label>
            </div>
            
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="f_preorderavail" name="f_preorderavail" <?php if($row["f_preorderavail"]){echo "checked";} ?>>
                <label class="form-check-label" for="f_preorderavail">Accepting Pre-order for this menu</label>
            </div>

            <div class="form-group">
                <label class="form-label" for="f_name">Menu Name</label>
                <input type="text" class="form-control" id="f_name" name="f_name"
                value="<?php echo $row["f_name"];?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="f_price">Price (Rs.)</label>
                <input type="number" step=".25" min="0.00" max="999.75" class="form-control" id="f_price" 
                value="<?php echo $row["f_price"];?>" name="f_price" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="f_quantity">Available Quantity</label>
                <input type="number" min="0" class="form-control" id="f_quantity" 
                value="<?php echo $row["f_quantity"]; ?>" name="f_quantity" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="veg_nveg">Veg / Non-Veg</label>
                <select class="form-control" id="veg_nveg" name="veg_nveg" required>
                    <option value="0" <?php if($row["veg_nveg"]==0) echo "selected"; ?>>Veg</option>
                    <option value="1" <?php if($row["veg_nveg"]==1) echo "selected"; ?>>Non-Veg</option>
                </select>
            </div>

            <div class="form-group file-upload">
                <label class="form-label" for="f_pic">Upload food image</label>
                <input class="form-control" type="file" id="f_pic" name="f_pic" accept="image/*">
            </div>

            <input type="hidden" name="f_id" value="<?php echo $f_id;?>">
            <button class="btn btn-success" name="upd_confirm" type="submit">Update Menu Detail</button>
        </form>
    </div>

    <footer>
        <p class="mb-0">CEC</p>
    </footer>
</body>
</html>