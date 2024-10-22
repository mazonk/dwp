<?php
include_once "src/controller/NewsController.php";
include_once "session_config.php";

if ($id === null) { // this is from the query string
    // Redirect back if id not found
    header("Location: " . $_SESSION['baseRoute'] . "home");
    exit;
}

$newsController = new NewsController();
$newsArticle = $newsController->getNewsById($id);
if (!$newsArticle) {
    // Handle case where the article is not found
    echo "<p>News article not found.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
        <title><?php echo htmlspecialchars($newsArticle->getHeader()); ?> - News</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <?php include_once("src/assets/tailwindConfig.php"); ?>
    </head>
    <body class="max-w-[1440px] w-[100%] mx-auto px-[100px] bg-bgDark text-textLight overflow-hidden">
        <?php include_once("src/view/components/Navbar.php"); ?>
        <main class="mt-[56px] p-4">
            <div class="max-w-4xl mx-auto py-8 px-4 translate-y-[80px]">
                            <!-- Back to News List Icon -->
            <div class="absolute top-0 -left-16">
                <a href="<?php echo $_SESSION['baseRoute'] ?>home" class="text-white flex items-center hover:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to News List
                </a>
            </div>
                <h1 class="text-4xl font-bold mb-4"><?php echo htmlspecialchars($newsArticle->getHeader()); ?></h1>
                
                <img class="w-full h-80 object-cover rounded-lg mb-6" 
                    src="../src/assets/<?php echo htmlspecialchars($newsArticle->getImageURL()); ?>" alt="News Image">
                
                <div class="text-lg leading-7 text-gray-300">
                    <!-- nl2br: Inserts HTML line breaks before all newlines in a string -->
                    <?php echo nl2br(htmlspecialchars($newsArticle->getContent())); ?>
                </div>
            </div>
        </main>
    </body>
</html>
