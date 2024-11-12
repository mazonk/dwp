<?php
class NewsCardAdmin {
    public static function render($newsId, $header, $imageURL, $content) {
        // Shorten the content to max 140 characters
        $shortenedContent = substr($content, 0, 140) . (strlen($content) > 140 ? '... ' : ''); 
        ?>
        <div class="bg-bgSemiDark border-[1px] border-borderDark rounded-lg shadow-lg overflow-hidden">
          <!-- Clickable link wrapping the image -->
          <img class="h-[275px] max-h-[275px] object-cover object-center" src="src/assets/<?php echo htmlspecialchars($imageURL); ?>" alt="Movie Poster">
          <!-- Content -->
          <div class="p-4">
            <p class="text-xs text-gray-400 hidden"><?php echo htmlspecialchars($newsId); ?></p>
            <p class="text-xl font-semibold text-white mb-1"><?php echo htmlspecialchars($header); ?></p>

            <p class="mb-[1rem] text-gray-400 text-sm leading-6">
              <?php echo htmlspecialchars($shortenedContent); ?>
            </p>

            <div class="flex gap-[.5rem]">
              <button id="editNewsButton" onclick="openEditModal(
              '<?= htmlspecialchars($newsId); ?>',
              '<?= htmlspecialchars($header); ?>',
              '<?= htmlspecialchars($imageURL); ?>',
              '<?= htmlspecialchars($content); ?>')"
                class="py-1 px-2 text-primary border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[.2s] ease-in-out">Edit</button>
              <button id="deleteNewsButton" onclick="openDeleteModal('<?= htmlspecialchars($newsId); ?>',
              '<?= htmlspecialchars($header); ?>')" class="bg-red-500 text-textDark py-1 px-2 border-[1px] border-red-500 rounded hover:bg-red-600 hover:border-red-600">Delete</button>
            </div>
          </div>
        </div>
        <?php
    }
}
