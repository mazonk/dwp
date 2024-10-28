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
<body class="w-[100%] mx-auto mb-[2rem] bg-bgDark text-textLight">
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

    <div class="flex mt-8">
        <?php include 'src/view/components/AdminSidebar.php'; ?>

        <!-- Main content -->
        <main class="flex-1 p-8 bg-gray-900 text-gray-100">
            <section id="venue-info" class="mb-8">
                <h2 class="text-3xl font-semibold mb-4"></h2>
            </section>
        </main>
    </div>
</body>
</html>
