<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("conn_db.php"); include('head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/login.css" rel="stylesheet">
    <title>Customer Registration</title>
    
    <style>
        body {
            background-color: #FFF5E4;
            min-height: 100vh;
        }

        .registration-container {
            background-color: #F1F1E6;
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .btn-signup {
            background-color: #6A9C89;
            color: #FFF5E4;
            padding: 0.75rem;
            font-weight: 500;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-signup:hover {
            background-color: #5a8b78;
            color: #FFF5E4;
        }

        .footer {
            background-color: #CD5C08;
            color: #FFF5E4;
            margin-top: auto;
            padding: 1rem;
        }

        /* Toast styling */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .toast {
            background-color: #f8d7da;
            color: #842029;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body class="d-flex flex-column">
<?php include('nav_header.php')?>
    <!-- Toast container -->
    <div class="toast-container"></div>

    <div class="container">
        <div class="registration-container">
            <form method="POST" action="add_cust.php" class="form-floating needs-validation" novalidate>
                <h2 class="text-center mb-4">
                    <i class="bi bi-person-plus me-2"></i>Sign Up
                </h2>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                        minlength="5" maxlength="45" pattern="^[a-zA-Z0-9_-]+$" required>
                    <label for="username">Username</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname"
                        pattern="^[a-zA-Z\s-]+$" required>
                    <label for="firstname">First Name</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="lastname" placeholder="Last Name" name="lastname" 
                        pattern="^[a-zA-Z\s-]+$" required>
                    <label for="lastname">Last Name</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" placeholder="E-mail" name="email" 
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                    <label for="email">E-mail</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="pwd" placeholder="Password" name="pwd" 
                        minlength="8" maxlength="45" required 
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,45}$">
                    <label for="pwd">Password</label>
                </div>
                
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="cfpwd" placeholder="Confirm Password" 
                        minlength="8" maxlength="45" name="cfpwd" required>
                    <label for="cfpwd">Confirm Password</label>
                </div>
                
                <button class="w-100 btn btn-signup mb-3" type="submit">
                    Sign Up
                </button>
            </form>
        </div>
    </div>

    <footer class="footer text-center mt-auto">
        <p class="mb-0">CEC</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const pwdInput = document.getElementById('pwd');
            const cfpwdInput = document.getElementById('cfpwd');

            // Function to show toast message
            function showToast(message) {
                const toastContainer = document.querySelector('.toast-container');
                const toast = document.createElement('div');
                toast.className = 'toast show p-3';
                toast.innerHTML = message;
                toastContainer.appendChild(toast);

                // Remove toast after 3 seconds
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }

            // Validation messages
            const validationMessages = {
                username: "Username must be 5-45 characters long and can only contain letters, numbers, underscore, or hyphen",
                firstname: "First name can only contain letters and spaces",
                lastname: "Last name can only contain letters and spaces",
                email: "Please enter a valid email address",
                pwd: "Password must be 8-45 characters and include uppercase, lowercase, number, and special character (@$!%*?&)",
                cfpwd: "Passwords do not match"
            };

            // Password match validation
            cfpwdInput.addEventListener('input', function() {
                if (pwdInput.value !== cfpwdInput.value) {
                    cfpwdInput.setCustomValidity('Passwords do not match');
                } else {
                    cfpwdInput.setCustomValidity('');
                }
            });

            // Clear invalid state on input
            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                });
            });

            // Form submission handling
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                // Clear previous toasts
                document.querySelector('.toast-container').innerHTML = '';

                let isValid = true;
                let firstInvalid = null;

                // Check each input
                inputs.forEach(input => {
                    if (!input.checkValidity()) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        
                        if (!firstInvalid) {
                            firstInvalid = input;
                        }

                        // Show toast with appropriate message
                        showToast(validationMessages[input.id]);
                    }
                });

                // Additional password match check
                if (pwdInput.value !== cfpwdInput.value) {
                    isValid = false;
                    cfpwdInput.classList.add('is-invalid');
                    showToast(validationMessages.cfpwd);
                }

                if (isValid) {
                    form.submit();
                } else if (firstInvalid) {
                    firstInvalid.focus();
                }
            });
        });
    </script>
</body>
</html>