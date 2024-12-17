<?php
include_once "src/controller/MovieController.php";
include_once "src/controller/GenreController.php";
include_once "src/view/components/admin-sections/movies/MovieCardAdmin.php";
class MovieCardAdmin
{
    public static function render(Movie $movie)
    {
        $movieController = new MovieController();
        $genreController = new GenreController();
        $isArchived = $movieController->isArchived($movie->getMovieId()); // Check if the movie is archived
        ?>
        <div class="w-[15.75rem] text-center m-[0.5rem] movie-card bg-bgSemiDark rounded-lg p-4 border-[1px] border-borderDark relative">
            <?php if ($isArchived): ?>
                <div class="absolute top-0 left-0 w-full py-1 bg-red-600 text-white font-bold text-xs uppercase text-center rounded-t-lg">
                    Archived
                </div>
            <?php endif; ?>
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
                <button id="editMovieButton"
                        data-movie='<?= json_encode([
                            'title' => htmlspecialchars($movie->getTitle()),
                            'description' => htmlspecialchars($movie->getDescription()),
                            'duration' => htmlspecialchars($movie->getDuration()),
                            'language' => htmlspecialchars($movie->getLanguage()),
                            'releaseDate' => $movie->getReleaseDate() ? htmlspecialchars($movie->getReleaseDate()->format('Y-m-d')) : '',
                            'posterURL' => htmlspecialchars($movie->getPosterURL()),
                            'promoURL' => htmlspecialchars($movie->getPromoURL()),
                            'trailerURL' => htmlspecialchars($movie->getTrailerURL()),
                            'rating' => htmlspecialchars($movie->getRating()),
                            'movieId' => htmlspecialchars($movie->getMovieId()),
                            'genres' => array_map(fn(Genre $genre) => $genre->getGenreId(), $genreController->getAllGenresByMovieId($movie->getMovieId())),
                        ]); ?>'
                        class="py-1 px-2 text-primary text-xs border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[0.2s] ease-in-out"
                        onclick="openEditMovieModal(this.dataset.movie)">
                    Edit
                </button>
          
                <?php if ($isArchived): ?>
                    <button onclick="openRestoreMovieModal('<?= htmlspecialchars($movie->getMovieId()); ?>')"
                            class="bg-green-400 text-textDark font-semibold py-1 px-2 text-xs border-[1px] border-green-500 rounded hover:bg-green-600 hover:border-green-600">
                        Restore
                    </button>
                <?php else: ?>
                    <button onclick="openArchiveMovieModal('<?= htmlspecialchars($movie->getMovieId()); ?>')"
                            class="bg-blue-400 text-textDark font-semibold py-1 px-2 text-xs border-[1px] border-blue-500 rounded hover:bg-blue-600 hover:border-blue-600">
                        Archive
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
?>
