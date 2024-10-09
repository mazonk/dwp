<?php 
session_start();

// Get input values from the session if available
$formData = isset($_SESSION['formData']) ? $_SESSION['formData'] : [
    'firstName' => '',
    'lastName' => '',
    'dob' => '',
    'email' => '',
];

// unset session's formdata
unset($_SESSION['formData']);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Register</h1>
        </div>

        <div>
            <?php
                require_once('src/view/components/RegisterForm.php');
                $registerForm = new RegisterForm();
                $registerForm->render($formData, $message);
                ?>
        </div>
    </div>
</body>
</html>
