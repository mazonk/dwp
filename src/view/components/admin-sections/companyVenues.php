<?php parse_str(file_get_contents("php://input"), $_PUT); ?>
<section>
    <h2 class="text-3xl font-semibold mb-4 text-center">Company & Venues</h2>
    <div class="flex flex-col">
        <hr class="mb-4 w-full mx-auto border-gray-300">
        <?php require_once 'src/view/components/admin-sections/venueCRUD.php' ?>
        
    </div>
</section>

