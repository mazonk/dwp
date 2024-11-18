<?php
include_once "src/controller/MovieController.php";
include_once "src/view/components/MovieCard.php";
?>

<div>
    <div class="flex justify-between my-[2rem]">
        <h3 class="text-[1.5rem] font-semibold">Movies</h3>
        <button id="addMovieButton" class="bg-primary text-textDark py-2 px-4 rounded hover:bg-primaryHover">
            Add Movie
        </button>
    </div>

    <div id="tab-content" class="grid grid-cols-1 gap-4">
        <?php
        $movieController = new MovieController();
        $allMovies = $movieController->getAllMovies();

        if (isset($allMovies['errorMessage'])) {
            echo $allMovies['errorMessage'];
        } else {
            echo '<div class="flex items-start flex-wrap gap-[1rem]">';
            foreach ($allMovies as $movie) {
                MovieCard::render($movie, false);
            }
            echo '</div>';
        }
        ?>
    </div>

    <!-- Add Movie Form Modal -->
<div id="addMovieModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <!-- Modal -->
        <div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
            <h2 class="text-[1.5rem] text-center font-semibold mb-4">Add Movie</h2>
            <form id="addMovieForm" class="text-textLight">
                <!-- Title Field -->
                <div class="mb-4">
                    <label for="addTitleInput" class="block text-sm font-medium text-textLight">Title</label>
                    <input type="text" id="addTitleInput" name="title" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                </div>

                <!-- Description Field -->
                <div class="mb-4">
                    <label for="addDescriptionInput" class="block text-sm font-medium text-textLight">Description</label>
                    <textarea id="addDescriptionInput" name="description" rows="3" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out"></textarea>
                </div>

                <!-- Duration Field -->
                <div class="mb-4">
                    <label for="addDurationInput" class="block text-sm font-medium text-textLight">Duration (minutes)</label>
                    <input type="number" id="addDurationInput" name="duration" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Language Field -->
                <div class="mb-4">
                    <label for="addLanguageInput" class="block text-sm font-medium text-textLight">Language</label>
                    <input type="text" id="addLanguageInput" name="language" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Release Date Field -->
                <div class="mb-4">
                    <label for="addReleaseDateInput" class="block text-sm font-medium text-textLight">Release Date</label>
                    <input type="date" id="addReleaseDateInput" name="releaseDate" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Poster URL Field -->
                <div class="mb-4">
                    <label for="addPosterURLInput" class="block text-sm font-medium text-textLight">Poster URL</label>
                    <input type="url" id="addPosterURLInput" name="posterURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Promo URL Field -->
                <div class="mb-4">
                    <label for="addPromoURLInput" class="block text-sm font-medium text-textLight">Promo URL</label>
                    <input type="url" id="addPromoURLInput" name="promoURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Rating Field -->
                <div class="mb-4">
                    <label for="addRatingInput" class="block text-sm font-medium text-textLight">Rating</label>
                    <input type="number" step="0.1" max="10" min="0" id="addRatingInput" name="rating" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Trailer URL Field -->
                <div class="mb-4">
                    <label for="addTrailerURLInput" class="block text-sm font-medium text-textLight">Trailer URL</label>
                    <input type="url" id="addTrailerURLInput" name="trailerURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="flex justify-end">
                    <button type="submit" id="saveAddMovieButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
                    <button type="button" id="cancelAddMovieButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editMovieModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <!-- Modal -->
        <div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
            <h2 class="text-[1.5rem] text-center font-semibold mb-4">Edit Movie</h2>
            <form id="editMovieForm" class="text-textLight">
                <!-- Title Field -->
                <div class="mb-4">
                    <label for="editTitleInput" class="block text-sm font-medium text-textLight">Title</label>
                    <input type="text" id="editTitleInput" name="title" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                </div>

                <!-- Description Field -->
                <div class="mb-4">
                    <label for="editDescriptionInput" class="block text-sm font-medium text-textLight">Description</label>
                    <textarea id="editDescriptionInput" name="description" rows="3" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out"></textarea>
                </div>

                <!-- Duration Field -->
                <div class="mb-4">
                    <label for="editDurationInput" class="block text-sm font-medium text-textLight">Duration (minutes)</label>
                    <input type="number" id="editDurationInput" name="duration" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Language Field -->
                <div class="mb-4">
                    <label for="editLanguageInput" class="block text-sm font-medium text-textLight">Language</label>
                    <input type="text" id="editLanguageInput" name="language" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Release Date Field -->
                <div class="mb-4">
                    <label for="editReleaseDateInput" class="block text-sm font-medium text-textLight">Release Date</label>
                    <input type="date" id="editReleaseDateInput" name="releaseDate" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Poster URL Field -->
                <div class="mb-4">
                    <label for="editPosterURLInput" class="block text-sm font-medium text-textLight">Poster URL</label>
                    <input type="url" id="editPosterURLInput" name="posterURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Promo URL Field -->
                <div class="mb-4">
                    <label for="editPromoURLInput" class="block text-sm font-medium text-textLight">Promo URL</label>
                    <input type="url" id="editPromoURLInput" name="promoURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Rating Field -->
                <div class="mb-4">
                    <label for="editRatingInput" class="block text-sm font-medium text-textLight">Rating</label>
                    <input type="number" step="0.1" max="10" min="0" id="editRatingInput" name="rating" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Trailer URL Field -->
                <div class="mb-4">
                    <label for="editTrailerURLInput" class="block text-sm font-medium text-textLight">Trailer URL</label>
                    <input type="url" id="editTrailerURLInput" name="trailerURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="flex justify-end">
                    <button type="submit" id="saveEditMovieButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Save</button>
                    <button type="button" id="cancelEditMovieButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($allMovies['errorMessage'])) {
    echo "<p class='text-red-500 text-center font-medium'>" . htmlspecialchars($allMovies['errorMessage']) . "</p>";
} else {
    foreach ($allMovies as $movie) {
        $movieData = json_encode([
            'id' => $movie->getMovieId(),
            'title' => $movie->getTitle(),
            'description' => $movie->getDescription(),
            'duration' => $movie->getDuration(),
            'language' => $movie->getLanguage(),
            'releaseDate' => $movie->getReleaseDate(),
            'posterUrl' => $movie->getPosterUrl(),
            'promoUrl' => $movie->getPromoUrl(),
            'trailerUrl' => $movie->getTrailerUrl(),
            'rating' => $movie->getRating(),
        ]);
        echo "<button class='movieCard bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 cursor-pointer' 
                data-movie='" . htmlspecialchars($movieData) . "'>";
        echo "<p class='text-center font-medium text-gray-700'>" . htmlspecialchars($movie->getTitle()) . "</p>";
        echo "</button>";
    }
}
?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const movieDetails = document.getElementById('movieDetails');
    const addMovieModal = document.getElementById('addMovieModal');
    const addMovieButton = document.getElementById('addMovieButton');
    const addMovieForm = document.getElementById('addMovieForm');
    const errorAddMessageElement = document.getElementById('error-add-header');
    // const addImageURLInput = document.getElementById('addImageURLInput');

    // Display the modal
    addMovieButton.addEventListener('click', () => {
        addMovieModal.classList.remove('hidden');
    });

    // Close the modal
    document.getElementById('cancelAddMovieButton').addEventListener('click', () => {
        addMovieModal.classList.add('hidden');
        clearValues('add');
    });

    editMovieButton.addEventListener('click', () => {
        editMovieModal.classList.remove('hidden');
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const editMovieButton = document.getElementById('editMovieButton'); // Edit button
    const editForm = document.getElementById('editMovieForm'); // Form to edit movie info
    const movieInfoDisplay = document.getElementById('movieInfoDisplay'); // Placeholder where movie info is shown
    const errorMessageElement = document.createElement('p');
    errorMessageElement.classList.add('text-red-500', 'text-center', 'font-medium');
    movieInfoDisplay.prepend(errorMessageElement);

    // Toggle visibility and populate form fields on edit button click
    document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.edit-movie-btn');
    const editModal = document.getElementById('editMovieModal');
    const formFields = {
        title: document.getElementById('editTitleInput'),
        description: document.getElementById('editDescriptionInput'),
        duration: document.getElementById('editDurationInput'),
        language: document.getElementById('editLanguageInput'),
        releaseDate: document.getElementById('editReleaseDateInput'),
        posterURL: document.getElementById('editPosterURLInput'),
        promoURL: document.getElementById('editPromoURLInput'),
        rating: document.getElementById('editRatingInput'),
        trailerURL: document.getElementById('editTrailerURLInput')
    };

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            formFields.title.value = button.dataset.title;
            formFields.description.value = button.dataset.description;
            formFields.duration.value = button.dataset.duration;
            formFields.language.value = button.dataset.language;
            formFields.releaseDate.value = button.dataset.releasedate;
            formFields.posterURL.value = button.dataset.posterurl;
            formFields.promoURL.value = button.dataset.promourl;
            formFields.rating.value = button.dataset.rating;
            formFields.trailerURL.value = button.dataset.trailerurl;

            // Show the modal
            editModal.classList.remove('hidden');
        });
    });

    // Close modal logic (e.g., on clicking cancel)
    document.getElementById('cancelEditMovieButton').addEventListener('click', () => {
        editModal.classList.add('hidden');
    });
});

});
</script>
