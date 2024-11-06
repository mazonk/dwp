<?php
include_once "src/controller/NewsController.php";

include_once "src/view/components/admin-sections/news/NewsCardAdmin.php";
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
            echo '<div class="flex items-center gap-[1rem]">';
            foreach ($allNews as $news) {
                NewsCardAdmin::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
            }
            echo '</div>';
        }
        ?>
    </div>
</div>