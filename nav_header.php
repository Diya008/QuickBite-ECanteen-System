<!--    NAV HEADER FOR CUSTOMER SIDE PAGE
        EXCEPT LOGIN AND REGISTRATION PAGE  -->

        <header class="navbar navbar-expand-md fixed-top shadow-sm" style="background-color: #FFF5E4;">
    <style>
        .navbar {
            padding: 0.75rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .nav-link {
            position: relative;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 0.5rem 1rem !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #6A9C89;
            transition: all 0.3s ease;
        }

        .nav-link:hover::after {
            width: 80%;
            left: 10%;
        }

        .btn {
            padding: 0.5rem 1.25rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cart-button {
            position: relative;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .cart-button:hover {
            background-color: #f8f9fa;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #CD5C08;
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            min-width: 20px;
            text-align: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background-color: #f8f9fa;
        }

        .logout-btn {
            background-color: #CD5C08;
            color: white;
        }

        .logout-btn:hover {
            background-color: #bf5507;
            color: white;
        }
    </style>

    <div class="container-fluid mx-4">
        <a class="navbar-brand" href="index.php">
            <img src="img/logo.png" width="75" class="me-2" alt="Sai Cafe">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" 
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="index.php">Home</a>
                </li>
                <?php if(isset($_SESSION['cid'])){ ?>
                <?php } ?>
            </ul>
            
            <div class="d-flex align-items-center">
                <?php if(!isset($_SESSION['cid'])){ ?>
                    <a class="btn me-2" href="cust_login.php" style="background-color: #C1D8C3">Log In</a>
                    <a class="btn" href="cust_regist.php" style="background-color: #6A9C89; color: white">Sign Up</a>
                <?php }else{ ?>
                    <div class="d-flex align-items-center gap-3">
                        <a class="cart-button" href="cust_cart.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                            </svg>
                            <?php
                                $incart_query = "SELECT SUM(ct_amount) AS incart_amt FROM cart WHERE c_id = {$_SESSION['cid']}";
                                $incart_result = $mysqli -> query($incart_query) -> fetch_array(); 
                                $incart_amt = $incart_result["incart_amt"];
                            ?>
                            <span class="cart-count"><?php echo $incart_amt > 0 ? $incart_amt : '0'; ?></span>
                        </a>
                        
                        <a href="cust_profile.php" class="user-profile text-dark text-decoration-none">
                            <span><?=$_SESSION['firstname']?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </a>
                        
                        <a class="btn logout-btn" href="logout.php">Log Out</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>