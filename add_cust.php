<?php
    //For inserting new customers to database
    include('conn_db.php');
    $pwd = $_POST["pwd"];
    $cfpwd = $_POST["cfpwd"];
    if($pwd != $cfpwd){
        ?>
        <script>
            alert('Your password is not match.\nPlease enter it again.');
            history.back();
        </script>
        <?php
        exit(1);
    }else{
        $username = $_POST["username"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        
        //Check for duplicating username
        $query = "SELECT c_username FROM customer WHERE c_username = '$username';";
        $result = $mysqli -> query($query);
        if($result -> num_rows >= 1){
            ?>
            <script>
                alert('Your username is already taken!');
                history.back();
            </script>
            <?php
        }
        $result -> free_result();
        
        //Check for duplicating email
        $query = "SELECT c_email FROM customer WHERE c_email = '$email';";
        $result = $mysqli -> query($query);
        if($result -> num_rows >= 1){
            ?>
            <script>
                alert('Your email is already in use!');
                history.back();
            </script>
            <?php
        }
        $result -> free_result();


        $query = "INSERT INTO customer (c_username,c_pwd,c_firstname,c_lastname,c_email)
        VALUES ('$username','$pwd','$firstname','$lastname','$email');";

        $result = $mysqli -> query($query);

        if($result){
            header("location: cust_regist_success.php");
        }else{
            header("location: cust_regist_fail.php?err={$mysqli -> errno}");
        }
    }
?>
