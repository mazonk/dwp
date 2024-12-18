<section>
    <h2 class="text-3xl font-semibold mb-4 text-center">Showings</h2>
    <?php
    if (isset($_GET['selectedMovie'])) {
        require_once "src/view/components/admin-sections/showings/movieShowings.php";
    } else {
        require_once 'src/view/components/admin-sections/showings/moviesList.php';
    }
    ?>
</section>