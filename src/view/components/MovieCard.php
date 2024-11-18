<?php
class MovieCard {

    public static function render(Movie $movie, $showReleaseDate) {
        $isMovieManagementPage = strpos($_SERVER['REQUEST_URI'], 'admin?section=movie-management') !== false;
        $isEditPage = strpos($_SERVER['REQUEST_URI'], 'movies/edit') !== false && isset($_GET['id']) && $_GET['id'] == $movie->getMovieId();
        ?>
        <div class="w-[12.5rem] text-center m-[0.625rem] movie-card">
            <a href="<?php echo $_SESSION['baseRoute'] ?>movies/<?php echo $movie->getMovieId(); ?>">
                <img class="w-full h-[18.75rem] rounded-[0.625rem] m-[0.625rem] bg-center bg-cover" 
                     src="src/assets/<?php echo $movie->getPosterURL(); ?>" alt="Movie Poster">
            </a>
            <div class="text-[1.2rem] text-white"><?php echo htmlspecialchars($movie->getTitle()); ?></div>

            <?php 
            if ($isMovieManagementPage) {
                ?>
                <div class="movie-id bg-gray-800 p-4 rounded hidden" id="movie-id-<?php echo $movie->getMovieId(); ?>">
                    <p><strong>Movie ID:</strong> <?php echo htmlspecialchars($movie->getMovieId()); ?></p>
                </div>
                <div class="movie-actions">
                    <a href="<?php echo $_SESSION['baseRoute'] ?>movies/edit/<?php echo $movie->getMovieId(); ?>" class="text-blue-500">Edit</a>
                    <a href="<?php echo $_SESSION['baseRoute'] ?>movies/delete/<?php echo $movie->getMovieId(); ?>" class="text-red-500">Delete</a>
                </div>
                <?php
            } else {
                if ($showReleaseDate):
                ?>
                    <div class="text-[0.875rem] text-white">Release Date: <?php echo htmlspecialchars($movie->getReleaseDate()->format('Y-m-d')); ?></div>
                <?php endif; 
            } ?>

            <?php if ($isEditPage): ?>
                <script>
                    // Populate form fields for editing
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('editTitleInput').value = "<?php echo htmlspecialchars($movie->getTitle()); ?>";
                        document.getElementById('editDescriptionInput').value = "<?php echo htmlspecialchars($movie->getDescription()); ?>";
                        document.getElementById('editDurationInput').value = "<?php echo htmlspecialchars($movie->getDuration()); ?>";
                        document.getElementById('editLanguageInput').value = "<?php echo htmlspecialchars($movie->getLanguage()); ?>";
                        document.getElementById('editReleaseDateInput').value = "<?php echo $movie->getReleaseDate()->format('Y-m-d'); ?>";
                        document.getElementById('editPosterURLInput').value = "<?php echo htmlspecialchars($movie->getPosterURL()); ?>";
                        document.getElementById('editPromoURLInput').value = "<?php echo htmlspecialchars($movie->getPromoURL()); ?>";
                        document.getElementById('editRatingInput').value = "<?php echo htmlspecialchars($movie->getRating()); ?>";
                        document.getElementById('editTrailerURLInput').value = "<?php echo htmlspecialchars($movie->getTrailerURL()); ?>";
                    });
                </script>
            <?php endif; ?>

        </div>
        <?php
    }
}
?>
