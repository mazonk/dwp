<?php
require_once 'session_config.php';
include_once "src/controller/NewsController.php";
include_once "src/view/components/NewsCard.php";

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'news'; // Default to 'news' if no tab is set in query string

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWP Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto px-[100px] bg-bgDark text-textLight overflow-hidden">
    <!-- Navbar -->
    <?php include_once("src/view/components/Navbar.php"); ?>

    <main class="mt-8 p-4">

        <!-- Tab Navigation -->
        <div class="flex space-x-4 justify-center mt-8 mb-8">
            <a href="?tab=news" class="text-white <?php echo $tab === 'news' ? 'underline font-semibold' : 'b'; ?>">News & Articles</a>
            <a href="?tab=company" class="text-white <?php echo $tab === 'company' ? 'underline font-semibold' : ''; ?>">Company Information</a>
            <a href="?tab=tickets" class="text-white <?php echo $tab === 'tickets' ? 'underline font-semibold' : ''; ?>">Ticket Prices</a>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <?php
            // Render content based on the selected tab
            if ($tab === 'news') {
                $newsController = new NewsController();
                $allNews = $newsController->getNews();

                // Loop through each news item and render it using NewsCard
                echo '<div class="grid grid-cols-3 gap-4 flex flex-row items-center">';
                foreach ($allNews as $news) {
                    NewsCard::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
                }
                echo '</div>';
            } elseif ($tab === 'company') {
                echo '<h2 class="text-2xl font-bold text-white">Company Information</h2>';
                echo '<p class="text-lg text-gray-300 mt-4">space reserved for company info.</p>';
            } elseif ($tab === 'tickets') {
                echo '<h2 class="text-2xl font-bold text-white">Ticket Prices</h2>';
                echo '<p class="text-lg text-gray-300 mt-4">space reserved for ticket prices.</p>';
            }
            ?>
        </div>
    </main>

    <h2>Testing some stuff here:</h2>
    <form action="/dwp/logout" method="post">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Logout</button>
    </form>
</body>
</html>
