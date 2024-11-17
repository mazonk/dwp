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

<script>
document.addEventListener('DOMContentLoaded', () => {
    /*== Add News ==*/
    const addMovieModal = document.getElementById('addMovieModal');
    const addMovieButton = document.getElementById('addMovieButton');
    const addMovieForm = document.getElementById('addMovieForm');
    const errorAddMessageHeader = document.getElementById('error-add-header');
    const errorAddMessageContent = document.getElementById('error-add-content');
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
    const editButton = document.getElementById('editMovieButton'); // Edit button
    const editForm = document.getElementById('editMovieForm'); // Form to edit movie info
    const movieInfoDisplay = document.getElementById('movieInfoDisplay'); // Placeholder where movie info is shown
    const errorMessageElement = document.createElement('p');
    errorMessageElement.classList.add('text-red-500', 'text-center', 'font-medium');
    movieInfoDisplay.prepend(errorMessageElement);

    // Toggle visibility and populate form fields on edit button click
    editButton.addEventListener('click', () => {
        editForm.classList.remove('hidden');
        
        const movieTitle = document.getElementById('movieTitleDisplay').textContent.trim();
        const movieDescription = document.getElementById('movieDescriptionDisplay').textContent.trim();
        const movieDuration = document.getElementById('movieDurationDisplay').textContent.trim();
        const movieLanguage = document.getElementById('movieLanguageDisplay').textContent.trim();
        const movieReleaseDate = document.getElementById('movieReleaseDateDisplay').textContent.trim();
        const moviePosterURL = document.getElementById('moviePosterURLDisplay').textContent.trim();
        const moviePromoURL = document.getElementById('moviePromoURLDisplay').textContent.trim();
        const movieRating = document.getElementById('movieRatingDisplay').textContent.trim();
        const movieTrailerURL = document.getElementById('movieTrailerURLDisplay').textContent.trim();

        document.getElementById('movieTitle').value = movieTitle;
        document.getElementById('movieDescription').value = movieDescription;
        document.getElementById('movieDuration').value = movieDuration;
        document.getElementById('movieLanguage').value = movieLanguage;
        document.getElementById('movieReleaseDate').value = movieReleaseDate;
        document.getElementById('moviePosterURL').value = moviePosterURL;
        document.getElementById('moviePromoURL').value = moviePromoURL;
        document.getElementById('movieRating').value = movieRating;
        document.getElementById('movieTrailerURL').value = movieTrailerURL;
    });
});
</script>


