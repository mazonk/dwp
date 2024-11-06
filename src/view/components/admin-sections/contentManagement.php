<?php parse_str(file_get_contents("php://input"), $_PUT);
include_once "src/controller/NewsController.php";

include_once "src/view/components/NewsCard.php";
?>
<section>
    <h2 class="text-3xl font-semibold mb-4 text-center">Content Management</h2>
    <div class="flex flex-col">
        <hr class="w-full mx-auto border-gray-300">
        <?php include_once("src/view/components/admin-sections/newsCRUD.php"); ?>
    </div>
</section>