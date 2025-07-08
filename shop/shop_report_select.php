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
        include("range_fn.php");
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #2EC4B6;
            --bg-color: #F7F9FC;
            --text-color: #1B2D45;
            --border-color: #E4E9F2;
            --hover-color: #FF8659;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
        }

        .container.form-signin {
            max-width: 768px;
            padding: 2.5rem;
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            margin: 3rem auto;
            animation: fadeIn 0.6s ease-out;
        }

        h2 {
            color: var(--text-color);
            font-weight: 700;
            font-size: 2.25rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .lead {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .form-check {
            background: white;
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .form-check:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-color);
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            margin-top: 0.3rem;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(255, 107, 53, 0.2);
        }

        .form-check-label {
            padding-left: 0.75rem;
            cursor: pointer;
        }

        .form-check-label strong {
            display: block;
            color: var(--text-color);
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }

        .text-muted {
            color: #6c757d !important;
            font-size: 0.95rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            height: 3.5rem;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.15);
        }

        .form-floating label {
            padding: 1rem;
            color: #6c757d;
        }

        .btn-outline-success {
            color: white;
            background-color: var(--primary-color);
            border: none;
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-outline-success:hover {
            background-color: var(--hover-color);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .date-range-container {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 1rem;
        }

        input[type="date"] {
            cursor: pointer;
            font-family: inherit;
        }

        input[type="date"]:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        footer {
            background-color: var(--primary-color);
            padding: 1.5rem 0;
            margin-top: auto;
        }

        footer p {
            margin: 0;
            font-weight: 500;
            font-size: 1rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container.form-signin {
                margin: 1.5rem;
                padding: 1.5rem;
            }

            h2 {
                font-size: 1.75rem;
            }

            .row-cols-2 {
                flex-direction: column;
            }

            .col {
                width: 100%;
            }

            .btn-outline-success {
                padding: 0.75rem 1.5rem;
            }
        }
    </style>
    <script type="text/javascript" src="../js/revenue_date_selection.js"></script>
    <title>Revenue Report</title>
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #FFF5E4">
    <?php include('nav_header_shop.php'); ?><br>

    <div class="container form-signin">
        <form method="GET" action="shop_report_summary.php" class="form-floating">
            <h2 class="animate_animated animate_fadeIn">Revenue Report</h2>
            <p class="lead animate_animated animatefadeIn animate_delay-1s">Select a time period to generate your sales and revenue report.</p>
            
            <div class="form-check animate_animated animatefadeIn animate_delay-2s">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode1" value="1" checked onclick="switch_disable(0)">
                <label class="form-check-label" for="rev_mode1">
                    <strong>Today's Overview</strong>
                    <span class="text-muted"><?php echo date('F j, Y');?></span>
                </label>
            </div>
            
            <div class="form-check animate_animated animatefadeIn animate_delay-2s">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode2" value="2" onclick="switch_disable(0)">
                <label class="form-check-label" for="rev_mode2">
                    <strong>Yesterday's Results</strong>
                    <span class="text-muted"><?php echo (new Datetime()) -> sub(new DateInterval("P1D")) -> format('F j, Y');?></span>
                </label>
            </div>
            
            <div class="form-check animate_animated animatefadeIn animate_delay-2s">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode3" value="3" onclick="switch_disable(0)">
                <label class="form-check-label" for="rev_mode3">
                    <strong>This Week's Performance</strong>
                    <span class="text-muted"><?php 
                    $weekrange = rangeWeek(date('Y-n-j'));
                    $week_start = (new Datetime($weekrange["start"])) -> format('F j, Y');
                    $week_end = (new Datetime($weekrange["end"])) -> format('F j, Y');
                    echo "{$week_start} - {$week_end}";
                    ?></span>
                </label>
            </div>
            
            <div class="form-check animate_animated animatefadeIn animate_delay-2s">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode4" value="4" onclick="switch_disable(0)">
                <label class="form-check-label" for="rev_mode4">
                    <strong>Monthly Analysis</strong>
                    <span class="text-muted"><?php 
                    $monthrange = rangeMonth(date('Y-n-j'));
                    $month_start = (new Datetime($monthrange["start"])) -> format('F j, Y');
                    $month_end = (new Datetime($monthrange["end"])) -> format('F j, Y');
                    echo "{$month_start} - {$month_end}";
                    ?></span>
                </label>
            </div>
            
            <div class="form-check animate_animated animatefadeIn animate_delay-2s">
                <input class="form-check-input" type="radio" name="rev_mode" id="rev_mode5" value="5" onclick="switch_disable(1)">
                <label class="form-check-label" for="rev_mode5">
                    <strong>Custom Date Range</strong>
                </label>
                <div class="date-range-container">
                    <div class="row row-cols-2 g-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="start_date" placeholder="Starting Date"
                                    value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>" name="start_date"
                                    oninput="update_minrange()" disabled>
                                <label for="start_date">Starting Date</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="end_date" placeholder="Ending Date"
                                    value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>" name="end_date" disabled>
                                <label for="end_date">Ending Date</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="w-100 btn btn-outline-success my-4 animate_animated animatefadeIn animate_delay-3s" type="submit">
                Generate Report
            </button>
        </form>
    </div>

    <footer class="text-center text-white mt-auto">
        <div class="text-center">
            <p>CEC</p>
        </div>
    </footer>
</body>
</html>