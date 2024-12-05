<?php
class MovieCardAdmin
{
    public static function render(Movie $movie)
    {
        ?>
        <div class="w-[15.75rem] text-center m-[0.5rem] movie-card bg-bgSemiDark rounded-lg p-4 border-[1px] border-borderDark">
            <a href="<?php echo $_SESSION['baseRoute'] ?>movie/<?php echo $movie->getMovieId(); ?>">
                <img class="w-full h-[18.75rem] mb-2 bg-bgSemiDark border-[1px] rounded-lg shadow-lg border-borderDark bg-center bg-cover"
                     src="src/assets/<?php echo htmlspecialchars($movie->getPosterURL()); ?>" alt="Movie Poster">
            </a>
            <div class="text-[1rem] text-white mb-2 font-semibold">
                <?php echo htmlspecialchars($movie->getTitle()); ?>
            </div>
            <p class="text-sm text-yellow-500 font-bold mb-2">
                Rating: <?php echo htmlspecialchars($movie->getRating() . ' / 10'); ?> ⭐
            </p>
            <div class="flex gap-[0.3rem] justify-center">
                <button onclick="openEditMovieModal(
                    '<?= htmlspecialchars($movie->getTitle()); ?>',
                    '<?= htmlspecialchars($movie->getDescription()); ?>',
                    '<?= htmlspecialchars($movie->getDuration()); ?>',
                    '<?= htmlspecialchars($movie->getLanguage()); ?>',
                    '<?= htmlspecialchars($movie->getReleaseDate()->format('Y-m-d')); ?>',
                    '<?= htmlspecialchars($movie->getPosterURL()); ?>',
                    '<?= htmlspecialchars($movie->getPromoURL()); ?>',
                    '<?= htmlspecialchars($movie->getTrailerURL()); ?>',
                    '<?= htmlspecialchars($movie->getRating()); ?>',
                    '<?= htmlspecialchars($movie->getMovieId()); ?>'
)"
                    id="editMovieButton"
                    class="py-1 px-2 text-primary text-xs border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[0.2s] ease-in-out">
                    Edit
                </button>
                <button onclick="openArchiveMovieModal('<?= htmlspecialchars($movie->getMovieId()); ?>')"
                        class="bg-blue-400 text-textDark py-1 px-2 text-xs border-[1px] border-blue-500 rounded hover:bg-blue-600 hover:border-blue-600">
                    Archive
                </button>
            </div>
        </div>
        <?php
    }
}
