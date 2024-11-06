<?php
require_once 'session_config.php';

if (!isLoggedIn()) {
    header("Location: " . $_SESSION['baseRoute'] . "login");
    exit;
}


$user = 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your profile</title>
</head>
<body>
    
</body>
</html>