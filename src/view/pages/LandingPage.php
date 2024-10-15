<?php 
require_once 'session_config.php';
include_once "src/controller/NewsController.php";
include_once "src/view/components/NewsCard.php"

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
    <main class="mt-[56px] p-4">
      <div class="grid grid-cols-1 gap-4">
      </div>

        <!-- News -->
        <div class="grid grid-cols-3 gap-4 flex flex-row items-center">
            <?php
            $newsController = new NewsController();
            $allNews = $newsController->getNews();

            // Loop through each movie and render its movie card
            foreach ($allNews as $news) {
                NewsCard::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
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