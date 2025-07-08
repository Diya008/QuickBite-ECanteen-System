<!--    NAV HEADER FOR SHOP OWNER SIDE PAGE   -->
<header class="navbar navbar-expand-md fixed-top shadow-sm" style="background-color: #FFF5E4">
    <div class="container-fluid mx-4">
        <a href="shop_home.php" class="navbar-brand">
            <img src="../img/logo.png" width="75" class="me-2" alt="QuickBite Logo" style="transition: transform 0.2s;">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" 
            aria-expanded="false" aria-label="Toggle navigation"
            style="border-color: #CD5C08;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark fw-medium hover-effect" href="shop_home.php" 
                       style="transition: color 0.3s, transform 0.2s;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark fw-medium hover-effect" href="shop_order_list.php"
                       style="transition: color 0.3s, transform 0.2s;">Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark fw-medium hover-effect" href="shop_menu_list.php"
                       style="transition: color 0.3s, transform 0.2s;">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark fw-medium hover-effect" href="shop_profile.php"
                       style="transition: color 0.3s, transform 0.2s;">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark fw-medium hover-effect" href="shop_report_select.php"
                       style="transition: color 0.3s, transform 0.2s;">Revenue Report</a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link px-3 text-dark fw-medium hover-effect" href="shop_crowd_estimation.php"
                       style="transition: color 0.3s, transform 0.2s;">Crowd Estimation</a>
                </li>-->
            </ul>

            <div class="d-flex align-items-center">
                <?php if(!isset($_SESSION['sid'])){ ?>
                <a class="btn btn-outline-secondary me-2 hover-effect" href="cust_regist.php"
                   style="transition: all 0.3s;">Sign Up</a>
                <a class="btn hover-effect" href="cust_login.php"
                   style="background-color: #CD5C08; color: #FFF5E4; transition: all 0.3s;">Log In</a>
                <?php }else{ ?>
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a href="shop_profile.php" class="nav-link px-3 text-dark fw-medium"
                           style="transition: color 0.3s;">
                            Welcome, <?=$_SESSION['shopname']?> admin
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn hover-effect ms-2" href="../logout.php"
                           style="background-color: #CD5C08; color: #FFF5E4; transition: all 0.3s;">Log Out</a>
                    </li>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>

    <style>
        .hover-effect:hover {
            transform: translateY(-2px);
            color: #CD5C08 !important;
        }
        
        .btn.hover-effect:hover {
            background-color: #b54e07 !important;
            color: #FFF5E4 !important;
            transform: translateY(-2px);
        }

        .navbar-brand img:hover {
            transform: scale(1.05);
        }

        .nav-link.hover-effect:hover {
            color: #CD5C08 !important;
            transform: translateY(-2px);
        }

        .navbar {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .navbar-collapse {
                padding: 1rem 0;
            }
            
            .nav-item {
                padding: 0.5rem 0;
            }
        }
    </style>
</header>