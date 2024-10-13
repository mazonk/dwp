<?php 
session_start();

// Get input values from the session if available
$formData = isset($_SESSION['formData']) ? $_SESSION['formData'] : [
    'firstName' => '',
    'lastName' => '',
    'dob' => '',
    'email' => '',
];
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];

unset($_SESSION['formData']);
unset($_SESSION['errors']);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/register-background.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-sm w-full bg-white shadow-md rounded-lg p-3.5">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Login</h1>
        </div>

        <div>
            <?php
                include("src/view/components/LoginForm.php");
                $loginForm = new LoginForm();
                $loginForm->render($formData, $errors);
            ?>
        </div>
    </div>
</body>
</html>
