<?php
class NewsCardAdmin {
    public static function render($id, $header, $imageURL, $content) {
        // Shorten the content to max 140 characters
        $shortenedContent = substr($content, 0, 140) . (strlen($content) > 140 ? '... ' : ''); 
        ?>
        <div class="max-w-[400px] bg-bgSemiDark rounded-lg shadow-lg overflow-hidden">
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

            <button id="editCompanyInfoButton" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Edit</button>
            <button id="deleteNewsButton" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Delete</button>
          </div>
        </div>
        <?php
    }
}
