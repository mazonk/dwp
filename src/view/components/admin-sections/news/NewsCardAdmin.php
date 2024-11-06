<?php
class NewsCardAdmin {
    public static function render($id, $header, $imageURL, $content) {
        // Shorten the content to max 140 characters
        $shortenedContent = substr($content, 0, 140) . (strlen($content) > 140 ? '... ' : ''); 
        ?>
        <div class="max-w-sm bg-gray-800 rounded-lg shadow-lg overflow-hidden">
          <!-- Clickable link wrapping the image -->
          <a href="<?php echo $_SESSION['baseRoute'] ?>news/<?php echo htmlspecialchars($id); ?>">
            <img class="h-[260px] object-cover object-center" src="src/assets/<?php echo htmlspecialchars($imageURL); ?>" alt="Movie Poster">
          </a>
          <!-- Content -->
          <div class="p-4">
            <a href="<?php echo $_SESSION['baseRoute'] ?>news/<?php echo htmlspecialchars($id)?>" class="text-xl font-semibold text-white mb-2"><?php echo htmlspecialchars($header); ?></a>

            <p class="text-gray-400 text-sm leading-6">
              <?php echo htmlspecialchars($shortenedContent); ?>
              <a href="<?php echo $_SESSION['baseRoute'] ?>news/<?php echo htmlspecialchars($id); ?>" class="text-blue-500 hover:underline">Read more</a>
            </p>
          </div>
        </div>
        <?php
    }
}
