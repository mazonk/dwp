<?php 
require_once 'session_config.php';

if (isLoggedIn()) {
    header("Location: " . $_SESSION['baseRoute'] . "home");
}

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
    <title>Sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('src/assets/register-background.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-sm w-full bg-white shadow-md rounded-lg p-3.5 -mt-24">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Sign up</h1>
        </div>

        <div>
            <?php
                require_once('src/view/components/RegisterForm.php');
                $registerForm = new RegisterForm();
                $registerForm->render($formData, $errors);
            ?>
        </div>
    </div>
</body>
</html>
