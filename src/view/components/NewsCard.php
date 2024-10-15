<?php
class NewsCard {
    public static function render($header, $imageURL, $content) {
        // Shorten the content to max 100 characters
        $shortenedContent = substr($content, 0, 140) . (strlen($content) > 140 ? '...' : ''); 
        ?>
        <div class="max-w-sm bg-gray-800 rounded-lg shadow-lg overflow-hidden m-auto">
          <!-- Image -->
          <img class="h-[260px] object-cover object-center" src="src/assets/<?php echo htmlspecialchars($imageURL); ?>" alt="Movie Poster">
          <!-- Content -->
          <div class="p-4">
            <h2 class="text-xl font-semibold text-white mb-2"><?php echo htmlspecialchars($header); ?></h2>

            <p class="text-gray-400 text-sm leading-6"><?php echo htmlspecialchars($shortenedContent); ?></p>
          </div>
        </div>
        <?php
    }
}
