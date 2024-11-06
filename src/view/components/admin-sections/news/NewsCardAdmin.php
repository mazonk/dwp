<?php
class NewsCardAdmin {
    public static function render($id, $header, $imageURL, $content) {
        // Shorten the content to max 140 characters
        $shortenedContent = substr($content, 0, 140) . (strlen($content) > 140 ? '... ' : ''); 
        ?>
        <div class="w-[400px] bg-bgSemiDark rounded-lg shadow-lg overflow-hidden">
          <!-- Clickable link wrapping the image -->
          <a href="<?php echo $_SESSION['baseRoute'] ?>news/<?php echo htmlspecialchars($id); ?>">
            <img class="h-[275px] max-h-[275px] object-cover object-center" src="src/assets/<?php echo htmlspecialchars($imageURL); ?>" alt="Movie Poster">
          </a>
          <!-- Content -->
          <div class="p-4">
            <a href="<?php echo $_SESSION['baseRoute'] ?>news/<?php echo htmlspecialchars($id)?>" class="text-xl font-semibold text-white mb-2"><?php echo htmlspecialchars($header); ?></a>

            <p class="pb-[1rem] text-gray-400 text-sm leading-6">
              <?php echo htmlspecialchars($shortenedContent); ?>
            </p>

            <div class="flex gap-[.5rem]">
              <button id="editNewsButton" class="text-white py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark duration-[.2s] ease-in-out">Edit</button>
              <button id="deleteNewsButton" class="bg-red-500 text-white py-2 px-4 border-[1px] border-transparent rounded hover:bg-red-600 duration-[.2s] ease-in-out">Delete</button>
            </div>
          </div>
        </div>
        <?php
    }
}
