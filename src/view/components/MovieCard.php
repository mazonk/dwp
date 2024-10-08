<?php
class MovieCard {

  
    public static function render($title, $posterURL, $releaseDate=null) {
        ?>
        <html>
          <head>
            <script src="https://cdn.tailwindcss.com"></script>
          </head>
          <body>
        <div class="w-[12.5rem] text-center m-[0.625rem]">
          <img class="w-full h-[18.75rem] rounded-[0.625rem] m-[0.625rem] bg-center bg-cover" src="src/assets/<?php echo $posterURL; ?>" alt="Movie Poster">
          <div class="text-[1.2rem] text-white"><?php echo htmlspecialchars($title); ?></div>

          <?php if ($releaseDate): // Check if releaseDate is not null ?>
              <div class="text-[0.875rem] text-white">Release Date: <?php echo htmlspecialchars($releaseDate); ?></div>
          <?php endif; ?>

        </div>
        </body>
        </html>
        <?php
    }
}
