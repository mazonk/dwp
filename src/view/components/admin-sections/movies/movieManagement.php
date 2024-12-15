<?php
include_once "src/controller/MovieController.php";
include_once "src/view/components/admin-sections/movies/MovieCardAdmin.php";
?>
<div>
<h2 class="text-3xl font-semibold mb-4 text-center">Movie Management</h2>
    <div class="flex justify-between my-[2rem]">
        <h3 class="text-[1.5rem] font-semibold">Movies</h3>
        <button id="addMovieButton" class="bg-primary text-textDark font-bold py-2 px-4 rounded hover:bg-primaryHover">
            Add Movie
        </button>
    </div>

    <div id="tab-content" class="grid grid-cols-1 gap-4">
        <?php
        $movieController = new MovieController();
        $allMovies = $movieController->getAllMovies();
        $allGenres = $movieController->getAllGenres();

        if (isset($allMovies['errorMessage'])) {
            echo htmlspecialchars($allMovies['errorMessage']);
        } else {
            echo '<div class="flex items-start flex-wrap gap-[1rem]">';
            foreach ($allMovies as $movie) {
                MovieCardAdmin::render($movie); // Pass the Movie object
            }
            echo '</div>';
        }
        ?>
    </div>
</div>
<section class="">
    <?php include_once 'src/view/components/admin-sections/movies/movieCreate.php' ?>
    <?php include_once 'src/view/components/admin-sections/movies/movieEdit.php' ?>
    <?php include_once 'src/view/components/admin-sections/movies/movieArchiveRestore.php' ?>
</section>
<script>
    //Clear error messages and input values
    function clearValues(action) {
            if (action === 'edit') {
                editMovieForm.reset();
            } else if (action === 'add') {
                addMovieForm.reset();
            } else if (action === 'archive') {
                errorArchiveMovieMessageGeneral.classList.add('hidden');
                archiveMovieIdInput.value = '';
                archiveMovieForm.reset();
            }
        }
</script>