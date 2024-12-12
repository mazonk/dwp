<?php 
include_once "src/controller/MovieController.php";

$movieController = new MovieController();
$movies = $movieController->getMoviesWithShowings();
?>

<div class="p-6 min-h-screen">
    <div class="w-full">
        <h1 class="text-2xl font-bold mb-4">Select a movie to navigate to the details:</h1>

        <?php if (isset($movies['errorMessage']) && $movies['errorMessage']) { ?>
            <div class="text-red-500 bg-red-100 border border-red-300 p-4 rounded-md">
                <?php echo htmlspecialchars($movies['errorMessage']); ?>
            </div>
        <?php } else { ?>

        <!-- Search Bar -->
        <div class="mb-6">
            <input 
                type="text" 
                id="searchBar" 
                onkeyup="filterMovies()" 
                placeholder="Search for a movie..." 
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black"/>
        </div>

        <!-- Movies List -->
        <div id="moviesList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($movies as $movie) { ?>
                <a 
                    href="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>&selectedMovie=<?php echo $movie['movieId']; ?>" 
                    class="bg-white p-4 rounded-lg shadow-md border border-gray-200 block">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2"> <?php echo $movie['title']; ?> </h3>
                    <p class="text-gray-600">Number of Showings: <?php echo $movie['numberOfShowings']; ?></p>
                </a>
            <?php } ?>
        </div>

        <?php } ?>
    </div>
</div>

<script>
    function filterMovies() {
        const searchBar = document.getElementById('searchBar');
        const filter = searchBar.value.toLowerCase();
        const moviesList = document.getElementById('moviesList');
        const movies = moviesList.getElementsByTagName('div');

        Array.from(movies).forEach(movie => {
            const title = movie.querySelector('h3').textContent.toLowerCase();
            if (title.includes(filter)) {
                movie.style.display = "block";
            } else {
                movie.style.display = "none";
            }
        });
    }
</script>