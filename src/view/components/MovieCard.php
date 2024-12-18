<?php
include_once "src/model/entity/Movie.php";
class MovieCard {

    public static function render(Movie $movie, $showReleaseDate) {
        ?>
        <body>
        <div class="w-[12.5rem] text-center m-[0.625rem] movie-card group">
            <img class="w-full h-[18.75rem] rounded-[0.625rem] m-[0.625rem] bg-center bg-cover transition-transform duration-300 ease-in-out transform group-hover:scale-105" 
                src="src/assets/<?php echo $movie->getPosterURL(); ?>" alt="Movie Poster">
            <div class="text-[1.2rem] text-white transition-transform transform duration-300 ease-in-out group-hover:scale-105"><?php echo htmlspecialchars($movie->getTitle()); ?></div>
            <?php if ($showReleaseDate): ?>
                <div class="text-[0.875rem] text-white transition-transform transform duration-300 ease-in-out group-hover:scale-105"><?php echo htmlspecialchars($movie->getReleaseDate()->format('Y-m-d')); ?></div>
            <?php endif; ?>
        </div>
        </body>
        <?php
    }
}
?>
