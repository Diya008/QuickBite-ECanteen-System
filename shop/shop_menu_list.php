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
    <title>Shop Menu List</title>
    <style>
        :root {
            --primary-color: #CD5C08;
            --secondary-color: #FFF5E4;
            --success-color: #6BBE66;
            --danger-color: #dc3545;
            --text-dark: #2C3639;
        }

        body {
            background-color: var(--secondary-color);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .menu-header {
            background-color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .menu-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .add-menu-btn {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .add-menu-btn:hover {
            background-color: #b54e07;
            transform: translateY(-2px);
        }

        .menu-item {
            background-color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .menu-item img {
            border-radius: 10px;
            object-fit: cover;
            height: 250px;
            width: 100%;
        }

        .menu-item-details {
            padding: 1rem 0;
        }

        .menu-item-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .menu-item-price {
            font-size: 1.1rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }

        .badge-veg {
            background-color: var(--success-color);
            color: white;
        }

        .badge-nonveg {
            background-color: var(--danger-color);
            color: white;
        }

        .action-buttons .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            margin-left: 0.5rem;
            transition: all 0.3s ease;
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
        }

        .notibar {
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .special-items-form {
            background-color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            margin-top: 3rem;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include('nav_header_shop.php'); ?>

    <div class="container px-4 py-5">
        <div class="menu-header">
            <h1 class="menu-title display-5">Shop Menu List</h1>
            <a href="shop_menu_add.php" class="btn add-menu-btn">
                <i class="bi bi-plus-circle me-2"></i>Add New Menu Item
            </a>
        </div>

        <?php if(isset($_GET["dsb_fdt"]) || isset($_GET["add_fdt"])) { ?>
            <div class="notibar">
                <?php if(isset($_GET["dsb_fdt"]) && $_GET["dsb_fdt"]==1) { ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <div>Successfully removed menu.</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <!-- Similar alert structure for other notification types -->
            </div>
        <?php } ?>

        <div class="row g-4">
            <?php 
            $query = "SELECT * FROM food WHERE s_id = $s_id";
            $result = $mysqli -> query($query);
            while ($row = $result->fetch_array()) {
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="menu-item">
                    <img 
                        <?php echo is_null($row["f_pic"]) ? "src='../img/default.png'" : "src='../img/{$row['f_pic']}'"; ?>
                        alt="<?php echo $row["f_name"]; ?>"
                    >
                    <div class="menu-item-details">
                        <h3 class="menu-item-title"><?php echo $row["f_name"]; ?></h3>
                        <p class="menu-item-price">Rs. <?php echo $row["f_price"]; ?></p>
                        <p class="text-muted">Quantity: <?php echo $row["f_quantity"]; ?> Units</p>
                        
                        <div class="mb-3">
                            <span class="badge <?php echo $row["veg_nveg"]==0 ? 'badge-veg' : 'badge-nonveg'; ?>">
                                <?php echo $row["veg_nveg"]==0 ? 'Veg' : 'Non-veg'; ?>
                            </span>
                            <span class="badge <?php echo $row["f_todayavail"]==1 ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo $row["f_todayavail"]==1 ? 'Available' : 'Out of Order'; ?>
                            </span>
                        </div>

                        <div class="action-buttons d-flex justify-content">
                            <a href="shop_menu_detail.php?f_id=<?php echo $row["f_id"]; ?>" class="btn btn-primary">View</a>
                            <a href="shop_menu_edit.php?f_id=<?php echo $row["f_id"]; ?>" class="btn btn-outline-success">Edit</a>
                            <a href="shop_menu_delete.php?f_id=<?php echo $row["f_id"]; ?>" class="btn btn-outline-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="special-items-form">
            <form action="set_special.php" method="POST">
                <input type="hidden" name="s_id" value="<?php echo $s_id; ?>">
                <div class="mb-4">
                    <label class="form-label h5">Select Today's Special Items</label>
                    <select name="specialItems[]" class="form-select" multiple required>
                        <?php
                        $menu_query = "SELECT f_id, f_name FROM food WHERE s_id = $s_id";
                        $menu_result = $mysqli->query($menu_query);
                        while ($item = $menu_result->fetch_assoc()) {
                            echo "<option value='{$item['f_id']}'>{$item['f_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" name="setSpecial" class="btn btn-success px-4">Set as Today's Special</button>
                    <button type="submit" name="removeAllSpecials" class="btn btn-danger px-4" formaction="remove_special.php">Remove All Specials</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="mt-auto text-center">
        <p class="mb-0">CEC</p>
    </footer>
</body>
</html>