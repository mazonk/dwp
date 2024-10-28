<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWP Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] bg-bgDark text-textLight">
    <?php
    require_once 'session_config.php';

    if (!isLoggedIn() || $_SESSION['loggedInUser']['roleType'] !== "Admin") {
        http_response_code(403);
        echo '<div class="text-4xl font-bold text-red-600">Nice try, but forbidden!</div>';
        exit;
    } else {
        echo '<div class="text-2xl font-bold text-green-600 flex justify-center">Welcome, '. $_SESSION['loggedInUser']['firstName'] . ' ' . $_SESSION['loggedInUser']['lastName'].'!</div>';
    }
    ?>
</body>
</html>

