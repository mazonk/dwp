<?php
include_once "src/model/entity/Movie.php";
class MovieCard {

  
    public static function render(Movie $movie, $showReleaseDate) {

        ?>
          <body>
        <div class="w-[12.5rem] text-center m-[0.625rem] movie-card">
          <a href="<?php echo $_SESSION['baseRoute'] ?>movies/<?php echo $movie->getMovieId(); ?>">
            <img class="w-full h-[18.75rem] rounded-[0.625rem] m-[0.625rem] bg-center bg-cover" 
            src="src/assets/<?php echo $movie->getPosterURL(); ?>" alt="Movie Poster">
          </a>
        <div class="text-[1.2rem] text-white"><?php echo htmlspecialchars($movie->getTitle()); ?></div>

          <?php if ($showReleaseDate):?>
              <div class="text-[0.875rem] text-white">Release Date: <?php echo htmlspecialchars($movie->getReleaseDate()->format('Y-m-d')); ?></div>
          <?php endif; ?>

        </div>
        <?php
    }
}