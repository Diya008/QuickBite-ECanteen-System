<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start();
        include("conn_db.php");
        include('head.php');
        if(!isset($_GET["s_id"])){
            header("location: restricted.php");
            exit(1);
        }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
    <title>Menu </title>
</head>

<body class="d-flex flex-column h-100" style="background-color: #FFF5E4;" >
    <?php include('nav_header.php')?>
  <?php
// Validate and assign $s_id from GET parameters
if (isset($_GET['s_id']) && is_numeric($_GET['s_id'])) {
    $s_id = intval($_GET['s_id']); // Convert to an integer for safety
} else {
    // Handle the case where s_id is missing or invalid
    die('Error: Shop ID is not specified or invalid.');
}

$query = "SELECT s_name, s_location, s_openhour, s_closehour, s_status, s_preorderstatus, s_phoneno, s_pic
          FROM shop WHERE s_id = {$s_id} LIMIT 1";

$result = $mysqli->query($query);
if (!$result) {
    die('Error fetching shop details: ' . $mysqli->error);
}

$shop_row = $result->fetch_array();

// Fetch "Today's Special" items
$special_query = "SELECT f_name FROM food WHERE is_special = 1 AND s_id = $s_id";
$special_result = $mysqli->query($special_query);

if (!$special_result) {
    die('Error fetching special items: ' . $mysqli->error);
}
?>

<div class="container mt-4">
    <!-- Generate notification pop-ups for each special item -->
    <?php
    if ($special_result->num_rows > 0) {
        while ($special_item = $special_result->fetch_assoc()) {
            ?>
            <div class="row row-cols-1 notibar mb-3">
                <div class="col p-3 bg-success text-white rounded text-start">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle ms-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                    <span class="ms-2">Today's Special: <?php echo htmlspecialchars($special_item['f_name']); ?></span>
                    <span class="me-2 float-end">
                        <button class="btn-close btn-close-white" onclick="this.parentElement.parentElement.remove();" aria-label="Close"></button>
                    </span>
                </div>
            </div>
            <?php
        }
    } else {
        // If no special items are available
        ?>
        <div class="row row-cols-1 notibar mb-3">
            <div class="col p-3 bg-warning text-dark rounded text-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-exclamation-circle ms-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zm.93-6.481a.5.5 0 0 1 .998 0l-.347 4.385a.25.25 0 0 1-.498 0l-.347-4.385z" />
                </svg>
                <span class="ms-2">No "Today's Special" items available at the moment.</span>
                <span class="me-2 float-end">
                        <button class="btn-close btn-close-white" onclick="this.parentElement.parentElement.remove();" aria-label="Close"></button>
                    </span>
            </div>
        </div>
        <?php
    }
    ?>
</div>



   
<!-- JavaScript for Closing Notification -->
<script>
    function closeNotification() {
        const notification = document.getElementById('special-notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }
</script>


        <?php 
            if(isset($_GET["atc"])){
                if($_GET["atc"]==1){
                    ?>
                    <!-- START SUCCESSFULLY ADD TO CART -->
                    <div class="row row-cols-1 notibar pb-3">
                        <div class="col mt-2 ms-2 p-2 bg-success text-white rounded text-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-check-circle ms-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                            </svg>
                            <span class="ms-2 mt-2">Add item to your cart successfully!</span>
                            <span class="me-2 float-end"><a class="text-decoration-none link-light" href="shop_menu.php?s_id=<?php echo $s_id;?>">X</a></span>
                        </div>
                    </div>
                    <!-- END SUCCESSFULLY ADD TO CART -->
            <?php }else{ ?>
                    <!-- START FAILED ADD TO CART -->
                    <div class="row row-cols-1 notibar">
                        <div class="col mt-2 ms-2 p-2 bg-danger text-white rounded text-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-circle ms-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg><span class="ms-2 mt-2">Failed to add item to your cart.</span>
                            <span class="me-2 float-end"><a class="text-decoration-none link-light" href="shop_menu.php?s_id=<?php echo $s_id;?>">X</a></span>
                        </div>
                    </div>
                    <!-- END FAILED ADD TO CART -->
            <?php }
                } ?>
        <div class="mb-3 text-wrap" id="shop-header" style="padding: 20px">
            <div class="rounded-25 mb-4" id="shop-img" style="
                    ">
            </div><div style="padding: 30px; display: flex; justify-content: center; gap: 20px; background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('img/<?php echo isset($shop_row['s_pic']) ? $shop_row['s_pic'] : 'default.jpg'; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; background-color: rgba(255, 240, 100, 0.4);">

           <div> <h1 class="display-1 strong"><?php echo $shop_row["s_name"];?></h1></div>
           <div> <ul class="list-unstyled">
                <li class="my-2">
                    <?php 
                        $now = date('H:i:s');
                        if((($now < $shop_row["s_openhour"])||($now > $shop_row["s_closehour"]))||($shop_row["s_status"]==0)){
                    ?>
                    <span class="badge  " style="background-color: #CD5C08 ; color: #FFF5E4">Closed</span>
                    <?php }else{ ?>
                    <span class="badge  " style="background-color: #6A9C89 ; color: #FFF5E4">Open</span>
                    <?php }
                        if($shop_row["s_preorderstatus"]==1){
                    ?>
                    <span class="badge bg-success">Pre-order Available</span>
                    <?php }else{ ?>
                    <span class="badge bg-danger">Pre-order Unavailable</span>
                    <?php } ?>
                    </li>
                <!--<li class=""><?php echo $shop_row["s_location"];?></li>-->
                <li class="">Open hours: 
                    <?php 
                        $open = explode(":",$shop_row["s_openhour"]);
                        $close = explode(":",$shop_row["s_closehour"]);
                        echo $open[0].":".$open[1]." - ".$close[0].":".$close[1];
                    ?>
                </li>
                <li class="">Telephone number: <?php echo "(+91) ".$shop_row["s_phoneno"];?></li>
            </ul></div></div>
        </div>
        

        <!-- GRID MENUS SELECTION -->
        
<h3 class="border-top py-3 mt-2" style="padding: 40px">Menu</h3>
<div style="margin-left: 40px; display: flex; gap: 20px; align-items: center;">
    <form method="POST" action="" style="display: flex; gap: 20px; align-items: center;">
        <div style="display: flex; gap: 20px;">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="veg" name="veg" 
                    <?php echo (!isset($_POST['add_filter']) || isset($_POST['veg'])) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="veg">Veg</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="non_veg" name="non_veg" 
                    <?php echo (!isset($_POST['add_filter']) || isset($_POST['non_veg'])) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="non_veg">Non Veg</label>
            </div>
        </div>
        <button class="btn btn-success" name="add_filter" type="submit">Add Filter</button>
    </form>
</div>


<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 align-items-stretch mb-1" style="padding: 40px">
<?php
    $result->free_result();
    
    // Get checkbox states
    $veg_checked = isset($_POST['veg']) ? true : false;
    $non_veg_checked = isset($_POST['non_veg']) ? true : false;
    
    // Base query
    $query = "SELECT * FROM food WHERE s_id = {$s_id} AND NOT(f_todayavail = 0 AND f_preorderavail = 0)";
    
    // Add veg/non-veg filter conditions
    if ($veg_checked && !$non_veg_checked) {
        // Only veg items
        $query .= " AND veg_nveg = 0";
    } elseif (!$veg_checked && $non_veg_checked) {
        // Only non-veg items
        $query .= " AND veg_nveg = 1";
    }
    // If both checked or both unchecked, show all items (no additional condition needed)
    
    $result = $mysqli->query($query);

    if($result->num_rows > 0){
        while($food_row = $result->fetch_array()){
?>

            <!-- GRID EACH MENU -->
            <div class="col">
            <div class="list-group-item mb-3 shadow-sm" style="border-radius: 15px;">
    <div class="row g-0 align-items-center">
        <div class="col-md-2">
            <img 
                <?php
                if(is_null($food_row["f_pic"])) {
                    echo "src='img/default.png'";
                } else {
                    echo "src=\"img/{$food_row['f_pic']}\"";
                }
                ?> 
                style="width:100%; height:120px; object-fit:cover; border-radius: 10px;"
                class="img-fluid" alt="<?php echo $food_row["f_name"]?>">
        </div>
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-start px-3">
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="mb-1 fs-6 fw-semibold"><?php echo $food_row["f_name"]?></h5>
                        <?php if($food_row["veg_nveg"]==0){ ?>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 122.88" style="height: 15px;">
                                <path style="fill:#6BBE66;" d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44c0,33.93-27.51,61.44-61.44,61.44C27.51,122.88,0,95.37,0,61.44 C0,27.51,27.51,0,61.44,0L61.44,0z"/>
                            </svg>
                        <?php } else { ?>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 122.88" style="height: 15px;">
                                <path style="fill:#ff0000;" d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z"/>
                            </svg>
                        <?php } ?>
                    </div>
                    
                    <p class="mb-1 text-muted small">Rs. <?php echo $food_row["f_price"]?></p>
                    
                    <div class="d-flex gap-1 mt-2">
                        <?php if($food_row["f_todayavail"]==1){ ?>
                            <span class="badge text-bg-success" style="font-size: 0.7rem;">Available</span>
                        <?php } else { ?>
                            <span class="badge text-bg-danger" style="font-size: 0.7rem;">Out of Order</span>
                        <?php }
                        if($food_row["f_preorderavail"]==1){ ?>
                            <span class="badge text-bg-success" style="font-size: 0.7rem;">Pre-order</span>
                        <?php } else { ?>
                            <span class="badge text-bg-danger" style="font-size: 0.7rem;">No Pre-order</span>
                        <?php } ?>
                    </div>
                </div>
                
                <div>
                    <a href="food_item.php?<?php echo "s_id=".$food_row["s_id"]."&f_id=".$food_row["f_id"]?>" 
                       class="btn btn-sm px-3" 
                       style="background-color: #6A9C89; color: #FFF5E4; font-size: 0.8rem; border-radius: 20px;">
                        Add to cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
            <?php
                    }   
                }
            ?>
            <!-- END GRID EACH SHOPS -->

        </div>
        <!-- END GRID SHOPS SELECTION -->
        <div class="card" style="background-color: #ffffe6; padding: 20px; text-align: center;">
    <h3>Provide your feedback</h3>
    <a href="feedback.php" 
       style="background-color: #CD5C08; color: #FFF5E4; padding: 10px 20px; display: inline-block; text-decoration: none; border-radius: 5px;">
       Feedback
    </a>
</div>


    </div>
    <footer class="text-center text-white">
  <!-- Copyright -->
  <div class="text-center p-2 p-2 mb-1 " style="background-color: #CD5C08; color: #FFF5E4">
    
        <p> CEC </p>
  </div>
  <!-- Copyright -->
</footer>
</body>

</html>
