<?php
include_once "src/model/entity/Movie.php";
class MovieCard {

  
    public static function render(Movie $movie) {
        ?>
        <html>
          <head>
            <script src="https://cdn.tailwindcss.com"></script>
          </head>
          <body>
        <div class="w-[12.5rem] text-center m-[0.625rem]">
         <form action="/dwp/movies/<?php echo $movie->getMovieId(); ?>" method="GET">
                <!-- Hidden input to pass the movie ID -->
                <input type="hidden" name="id" value="<?php echo $movie->getMovieId(); ?>">
                <!-- Submit button with the poster image -->
                <button type="submit">
                  <img class="w-full h-[18.75rem] rounded-[0.625rem] m-[0.625rem] bg-center bg-cover" src="src/assets/<?php echo $movie->getPosterURL(); ?>" alt="Movie Poster">
                </button>
              </form>
        <div class="text-[1.2rem] text-white"><?php echo htmlspecialchars($movie->getTitle()); ?></div>

          <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] !== '/dwp/movies'): // Check if request method is GET and URI is /dwp/movies ?>
              <div class="text-[0.875rem] text-white">Release Date: <?php echo htmlspecialchars($movie->getReleaseDate()->format('Y-m-d')); ?></div>
          <?php endif; ?>

        </div>
        </body>
        </html>
        <?php
    }
}
