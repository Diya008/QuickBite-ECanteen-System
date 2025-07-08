
<?php
include 'conn_db.php'; // Replace with your actual connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $ord_id =$_POST['ord_id'];
    $orh_id = $_POST['orh_id'];
    $f_id = $_POST['f_id'];
    $ord_amount = $_POST['ord_amount']; // Ensure it's an integer
    $ord_buyprice = $_POST['ord_buyprice']; // Ensure it's a float
    $ord_note = $_POST['ord_note'];

    // Start transaction
    mysqli_begin_transaction($conn); 

    try {
        
        


       // Fetch the current f_quantity for the given f_id
       $fetchQuantityQuery = "SELECT f_quantity FROM food WHERE f_id = '$f_id'";
       $result = mysqli_query($conn, $fetchQuantityQuery);
       $row = mysqli_fetch_assoc($result);

       if (!$result || mysqli_num_rows($result) === 0) {
           throw new Exception("Invalid food ID or food not found.");
       }

       
       $currentQuantity = $row['f_quantity'];
       ?>
       <body>
       <form >
        <input type="hidden" name="f_quantity" value="<?php echo $currentQuantity;?>">
        <a href="temp.php">click</a>
       </form>
       </body>
       <?php

       // Check if there's sufficient quantity
       if ($currentQuantity < $ord_amount) {
           throw new Exception("Insufficient food quantity.");
       }

       // Calculate the new quantity
       $newQuantity = $currentQuantity - $ord_amount;

       // Update the `food` table with the new quantity
       $updateFoodQuery = "UPDATE food SET f_quantity = $newQuantity WHERE f_id = '$f_id'";
       if (!mysqli_query($conn, $updateFoodQuery)) {
           throw new Exception("Error updating food quantity: " . mysqli_error($conn));
       }

       // Insert into `order_table`
       $insertOrderQuery = "INSERT INTO order_table (ord_id, orh_id, f_id, ord_amount, ord_buyprice, ord_note) 
       VALUES ('$ord_id', '$orh_id', '$f_id', '$ord_amount', '$ord_buyprice', '$ord_note')";

       if (!mysqli_query($conn, $insertOrderQuery)) {
        throw new Exception("Error inserting order details: " . mysqli_error($conn));
    }


        // Commit transaction
        mysqli_commit($conn);
        echo "Order placed successfully!";
    } catch (Exception $e) {
        // Rollback on failure
        mysqli_rollback($conn);
        echo "Failed to place order: " . $e->getMessage();
    }

    // Close connection
    header("temp.php");
    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
