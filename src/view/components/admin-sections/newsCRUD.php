<?php parse_str(file_get_contents("php://input"), $_PUT);
include_once "src/controller/NewsController.php";

include_once "src/view/components/NewsCard.php";
?>

<div>
    <h3 class="text-[1.5rem] font-semibold my-[2rem]">News</h3>
    <div id="tab-content" class="grid grid-cols-1 gap-4">
        <?php
        $newsController = new NewsController();
        $allNews = $newsController->getAllNews();

        if (isset($allNews['errorMessage'])) {
            echo $allNews['errorMessage'];
        } else {
            // Loop through each news item and render it using NewsCard
            echo '<div class="flex flex-row items-center">';
            foreach ($allNews as $news) {
                NewsCard::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
            }
            echo '</div>';
        }
        ?>
    </div>
</div>