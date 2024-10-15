<?php
class NewsCard {
    public static function render($header, $imageURL, $content) {
        // Shorten the content to 200 characters
        $shortenedContent = substr($content, 0, 100) . (strlen($content) > 100 ? '...' : ''); 
        ?>
        <html>
          <head>
            <script src="https://cdn.tailwindcss.com"></script>
          </head>
          <body class="bg-gray-900 p-4">
        <div class="max-w-xs bg-gray-800 rounded-lg shadow-lg overflow-hidden m-auto">
          <!-- Image -->
          <img class="w-full h-[18.75rem] object-cover object-center" src="src/assets/<?php echo htmlspecialchars($imageURL); ?>" alt="Movie Poster">
          <!-- Content -->
          <div class="p-4">
            <!-- Header -->
            <h2 class="text-xl font-semibold text-white mb-2"><?php echo htmlspecialchars($header); ?></h2>
            <!-- Shortened Content -->
            <p class="text-gray-400 text-sm leading-6"><?php echo htmlspecialchars($shortenedContent); ?></p>
          </div>
        </div>
        </body>
        </html>
        <?php
    }
}
