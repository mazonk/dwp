<?php
include_once "src/controller/MovieController.php";
include_once "src/view/components/admin-sections/movies/MovieCardAdmin.php";
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
                MovieCardAdmin::render($movie, $title, $releaseDate, $duration, $language, $description, $posterURL, $trailerURL, $promoURL, $rating);
            }
            echo '</div>'; // End of flex container}
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
            <div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
                <h2 class="text-[1.5rem] text-center font-semibold mb-4">Edit Movie</h2>
                <form id="editMovieForm" class="text-textLight">
                    <!-- Add form fields for editing movie details -->
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
        <div id="deleteMovieModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
            <div class="flex items-center justify-center min-h-screen">
                <!-- Modal -->
                <div class="bg-bgSemiDark w-[400px] rounded-lg p-6 border-[1px] border-borderDark">
                    <h2 class="text-[1.5rem] text-center font-semibold mb-4 text-red-500">Delete Movie</h2>
                    <p class="text-textLight text-center mb-6">Are you sure you want to delete this movie? This action cannot be undone.</p>

                    <!-- Hidden Input for Movie ID -->
                    <input type="hidden" id="deleteMovieIdInput" value="">

                    <!-- Confirm and Cancel Buttons -->
                    <div class="flex justify-center gap-4">
                        <button id="confirmDeleteMovieButton" class="bg-red-500 text-white py-2 px-4 rounded border border-transparent hover:bg-red-600 duration-[.2s] ease-in-out">
                            Delete
                        </button>
                        <button type="button" id="cancelDeleteMovieButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark duration-[.2s] ease-in-out">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>



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

            // Add movie form submission
            addMovieForm.addEventListener('submit', (event) => {
                event.preventDefault();
                const formData = new FormData(addMovieForm);
                const data = Object.fromEntries(formData);
                addMovie(data);
                addMovieModal.classList.add('hidden');
            });

            //  Edit movie form
        });
    </script>