<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("conn_db.php"); include('head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <style>
        html {
            height: 100%;
        }
    </style>
    <title>QuickBite</title>
</head>

<body class="d-flex flex-column h-100" style="background-color: #FFF5E4">

    <?php include('nav_header.php')?>
    <div class="container form-signin mt-auto" style="background-color: #FFF5E4">
    <form method="POST" action="feed_processing.php" class="form-floating">
        <div style="background-color: #F1F1E6; width: 70%; margin: 0 auto; padding: 20px; border-radius: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <h2 class="mt-4 mb-3 fw-normal text-bold">Feedback</h2>
            
            
            <div class="form-floating mb-2">
                <select class="form-select" id="floatingSelect" name="s_id" required>
                    <option value="">Select Shop</option>
                    <option value="1">Canteen</option>
                    <option value="2">Mess</option>
                </select>
                <label for="floatingSelect">Shop</label>
            </div>
            
            <div class="form-floating mb-2">
                <textarea class="form-control" placeholder="Leave your feedback here" id="floatingTextarea" name="feedback" style="height: 100px" required></textarea>
                <label for="floatingTextarea">Feedback Message</label>
            </div>
            
            <button class="w-100 btn mb-3" style="background-color: #CD5C08; color: #FFF5E4" type="submit">Submit Feedback</button>
        </div>
    </form>
    </div>

<br><br>

    <footer class="text-center text-white">
  <!-- Copyright -->
  <div class="text-center p-2 p-2 mb-1 " style="background-color: #CD5C08; color: #FFF5E4">
    
        <p> CEC </p>
  </div>
  <!-- Copyright -->
</footer>
</body>

</html>