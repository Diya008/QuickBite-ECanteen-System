<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Successfully</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .success-container {
            max-width: 500px;
            margin: auto;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .success-icon {
            color: #28a745;
            font-size: 5rem;
            margin-bottom: 1rem;
        }

        .btn-custom {
            background-color: #CD5C08;
            border: none;
            color: #FFF5E4;
            padding: 0.8rem 2rem;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #B54F07;
            transform: translateY(-2px);
            color: #FFF5E4;
        }

        .footer {
            background-color: #CD5C08;
            color: #FFF5E4;
            padding: 1rem;
            margin-top: auto;
        }

        .footer p {
            margin: 0;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <main class="container my-5">
        <div class="success-container text-center">
            <i class="bi bi-check-circle-fill success-icon"></i>
            <h2 class="mb-4 fw-bold">Password Reset Successful!</h2>
            <p class="mb-4 text-muted">Your password has been reset successfully. Please log in to your account with your new password.</p>
            <a class="btn btn-custom btn-lg" href="index.php">
                Return to Home
                <i class="bi bi-house-door ms-2"></i>
            </a>
        </div>
    </main>

    <footer class="footer text-center">
        <p>CEC</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>