<?php
include_once "src/controller/MovieController.php";
include_once "src/controller/GenreController.php";
include_once "src/view/components/admin-sections/movies/MovieCardAdmin.php";
?>

<div>
    <div class="flex justify-between my-[2rem]">
        <h3 class="text-[1.5rem] font-semibold">Movies</h3>
        <button id="addMovieButton" class="bg-primary text-textDark font-bold py-2 px-4 rounded hover:bg-primaryHover">
            Add Movie
        </button>
    </div>

    <div id="tab-content" class="grid grid-cols-1 gap-4">
        <?php
        $movieController = new MovieController();
        $genreController = new GenreController();
        $allMovies = $movieController->getAllMovies();
        $allGenres = $genreController->getAllGenres();

        if (isset($allMovies['errorMessage'])) {
            echo htmlspecialchars($allMovies['errorMessage']);
        } else {
            echo '<div class="flex items-start flex-wrap gap-[1rem]">';
            foreach ($allMovies as $movie) {
                MovieCardAdmin::render($movie); // Pass the Movie object
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
                        <label for="addPosterUrlInput" class="block text-sm font-medium text-textLight">Poster</label>
                        <input type="file" id="addPosterUrlInput" name="posterURL" class="mt-1 block w-full p-2 bg-bgDark 
                        border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" accept="image/*" required>
                    </div>

                    <!-- Promo URL Field -->
                    <div class="mb-4">
                        <label for="addPromoUrlInput" class="block text-sm font-medium text-textLight">Promo</label>
                        <input type="file" id="addPromoUrlInput" name="promoURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" accept="image/*" required>
                    </div>

                    <!-- Trailer URL Field -->
                    <div class="mb-4">
                        <label for="addTrailerUrlInput" class="block text-sm font-medium text-textLight">Trailer URL</label>
                        <input type="text" id="addTrailerUrlInput" name="trailerURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                    </div>

                    <!-- Rating Field -->
                    <div class="mb-4">
                        <label for="addRatingInput" class="block text-sm font-medium text-textLight">Rating</label>
                        <input type="number" step="0.1" max="10" min="0" id="addRatingInput" name="rating" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                    </div>

                    <!-- Genres Field -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-textLight mb-2">Genres</label>
                            <button type="button" id="clearGenres" class="text-sm text-red-500 hover:underline">
                                Clear All
                            </button>
                        </div>
                        <div id="addGenreCheckboxContainer" class="grid grid-cols-2 gap-4">
                            <?php foreach ($allGenres as $genre) : ?>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" id="genre-<?= $genre->getGenreId() ?>" name="genres[]" value="<?= $genre->getGenreId() ?>" class="mr-2">
                                    <label for="genre-<?= $genre->getGenreId() ?>" class="text-[1rem] leading-tight"><?= $genre->getName() ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div> <!-- Submit and Cancel Buttons -->
                    <div class="flex justify-end">
                        <button type="submit" id="saveAddMovieButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
                        <button type="button" id="cancelAddMovieButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editMovieModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
            <h2 class="text-[1.5rem] text-center font-semibold mb-4">Edit Movie</h2>
            <form id="editMovieForm" class="text-textLight">
                <input type="hidden" id="editMovieIdInput" name="id">
                <div class="mb-4">
                    <!-- Title Field -->
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
                    <label for="editPosterUrlInput" class="block text-sm font-medium text-textLight">Upload Poster Image</label>
                    <input type="file" name="image" id="editPosterUrlInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" accept="image/*">
                    <div id="posterImageNameDisplay" class="mt-2 text-sm text-textLight"></div>
                </div>

                <!-- Promo URL Field -->
                <div class="mb-4">
                    <label for="editPromoUrlInput" class="block text-sm font-medium text-textLight">Upload Promo Image</label>
                    <input type="file" name="image" id="editPromoUrlInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" accept="image/*">
                    <div id="promoImageNameDisplay" class="mt-2 text-sm text-textLight"></div>
                </div>

                <!-- Trailer URL Field -->
                <div class="mb-4">
                    <label for="editTrailerUrlInput" class="block text-sm font-medium text-textLight">Trailer URL</label>
                    <input type="text" id="editTrailerUrlInput" name="trailerURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>

                <!-- Rating Field -->
                <div class="mb-4">
                    <label for="editRatingInput" class="block text-sm font-medium text-textLight">Rating</label>
                    <input type="number" step="0.01" max="10" min="0" id="editRatingInput" name="rating" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                </div>
                <!-- Genres Field -->
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-textLight mb-2">Genres</label>
                        <button type="button" id="clearEditGenres" class="text-sm text-red-500 hover:underline">
                            Clear All
                        </button>
                    </div>
                    <div id="editGenreCheckboxContainer" class="grid grid-cols-2 gap-4">
                        <?php foreach ($allGenres as $genre) : ?>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="editGenre-<?= $genre->getGenreId() ?>" name="genres[]" value="<?= $genre->getGenreId() ?>" class="mr-2">
                                <label for="genre-<?= $genre->getGenreId() ?>" class="text-[1rem] leading-tight"><?= $genre->getName() ?></label>
                            </div>
                        <?php endforeach; ?>
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

<!-- Archive Movie Modal -->
<div id="archiveMovieModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <!-- Modal -->
        <div class="bg-bgSemiDark w-[500px] rounded-lg p-6 border-[1px] border-borderDark">
            <h2 class="text-[1.5rem] text-center font-semibold mb-4">Archive Movie</h2>
            <div class="text-center">
                <p class="text-textLight text-center">Are you sure you want to archive this movie?</p>
                <p>This movie will not be displayed on the website.</p>
            </div>
            <input type="hidden" id="archiveMovieIdInput" name="archiveMovieIdInput">
            <div class="flex justify-center mt-4">
                <button id="confirmArchiveMovieButton" class="bg-blue-500 text-white py-2 px-4 border-[1px] border-transparent rounded hover:bg-blue-600 duration-[.2s] ease-in-out">Archive</button>
                <button id="cancelArchiveMovieButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Restore Movie Modal -->
<div id="restoreMovieModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <!-- Modal -->
        <div class="bg-bgSemiDark w-[500px] rounded-lg p-6 border-[1px] border-borderDark">
            <h2 class="text-[1.5rem] text-center font-semibold mb-4">Restore Movie</h2>
            <div class="text-center">
                <p class="text-textLight text-center">Are you sure you want to restore this movie?</p>
                <p>This movie will be displayed on the website again.</p>
            </div>
            <input type="hidden" id="restoreMovieIdInput" name="restoreMovieIdInput">
            <div class="flex justify-center mt-4">
                <button id="confirmRestoreMovieButton" class="bg-blue-500 text-white py-2 px-4 border-[1px] border-transparent rounded hover:bg-blue-600 duration-[.2s] ease-in-out">Restore</button>
                <button id="cancelRestoreMovieButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        function sendFile(file) {
            const baseRoute = '<?php echo $_SESSION['baseRoute']; ?>';
            const formData = new FormData();
            formData.append('file', file); // Add the file to the FormData object
            const xhr = new XMLHttpRequest();
            xhr.open('POST', `${baseRoute}upload-image`, true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response;
                    try {
                        response = JSON.parse(xhr.response);
                    } catch (e) {
                        console.error('Could not parse response as JSON:', e);
                        return;
                    }
                }
            };
            xhr.send(formData); // Send the FormData object
        }

        // Add Movie
        const addMovieForm = document.getElementById('addMovieForm');
        const addMovieButton = document.getElementById('addMovieButton');
        const addMovieModal = document.getElementById('addMovieModal');
        const errorMessage = document.getElementById('errorMessage');
        const errorMessageElement = document.getElementById('error-message');
        const movieId = document.getElementById('movieId');
        const addTitleInput = document.getElementById('addTitleInput');
        const addDescriptionInput = document.getElementById('addDescriptionInput');
        const addDurationInput = document.getElementById('addDurationInput');
        const addLanguageInput = document.getElementById('addLanguageInput');
        const addReleaseDateInput = document.getElementById('addReleaseDateInput');
        const addPosterUrlInput = document.getElementById('addPosterUrlInput');
        const addPromoUrlInput = document.getElementById('addPromoUrlInput');
        const addTrailerUrlInput = document.getElementById('addTrailerUrlInput');
        const addRatingInput = document.getElementById('addRatingInput');
        const addGenresContainer = document.getElementById('genreCheckboxContainer');
        const clearGenresButton = document.getElementById('clearGenres');

        // Array to hold selected genres
        let selectedGenres = [];


        // Add event listener to checkboxes
        addGenreCheckboxContainer.addEventListener('change', (event) => {
            if (event.target.type === 'checkbox') {
                updateSelectedGenres();
            }
        });

        // Function to update selected genres array
        function updateSelectedGenres() {
            // Get all checkboxes inside the container
            const checkboxes = addGenreCheckboxContainer.querySelectorAll('input[type="checkbox"]:checked');
            // Update the array with the values of checked checkboxes
            selectedGenres = Array.from(checkboxes).map(checkbox => checkbox.value);
        }

        // Clear all selected genres
        clearGenresButton.addEventListener('click', () => {
            // Get all checkboxes inside the container
            const checkboxes = addGenreCheckboxContainer.querySelectorAll('input[type="checkbox"]');
            // Uncheck all checkboxes
            checkboxes.forEach(checkbox => (checkbox.checked = false));
            // Clear the selected genres array
            selectedGenres = [];
        });

        // Display the modal
        addMovieButton.addEventListener('click', () => {
            addMovieModal.classList.remove('hidden');
        });

        // Close the modal
        document.getElementById('cancelAddMovieButton').addEventListener('click', () => {
            addMovieModal.classList.add('hidden');
            clearValues('add');
        });

        window.openAddMovieModal = function(title, description, duration, language, releaseDate, posterUrl, promoURL, trailerUrl, rating, selectedGenres, id) {
            add.value = title;
            addDescriptionInput.value = description;
            addDurationInput.value = duration;
            addLanguageInput.value = language;
            addReleaseDateInput.value = releaseDate;
            addPosterUrlInput.value = posterUrl;
            addPromoUrlInput.value = promoUrl;
            addTrailerUrlInput.value = trailerUrl;
            addRatingInput.value = rating;
            console.log(selectedGenres);
            selectedGenres.forEach(genre => {
                const checkbox = addGenreCheckboxContainer.querySelector(`input[value="${genre}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            })
            addMovieIdInput.value = id;
            addMovieModal.classList.remove('hidden');
        };

        // Add movie form submission
        addMovieForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const xhr = new XMLHttpRequest();
            const baseRoute = '<?php echo $_SESSION['baseRoute']; ?>';
            xhr.open('POST', `${baseRoute}movies/add`, true);

            let poster = "";
            if (addPosterUrlInput.files.length == 1) {
                poster = addPosterUrlInput.files[0].name;
            }

            let promo = "";
            if (addPromoUrlInput.files.length == 1) {
                promo = addPromoUrlInput.files[0].name;
            }

            const movieData = {
                action: 'addMovie',
                title: addTitleInput.value,
                description: addDescriptionInput.value,
                duration: addDurationInput.value,
                language: addLanguageInput.value,
                releaseDate: addReleaseDateInput.value,
                posterUrl: poster,
                promoUrl: promo,
                trailerUrl: addTrailerUrlInput.value,
                rating: addRatingInput.value,
                genres: selectedGenres,
            }

            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                // If the request is done and successful
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response
                    try {
                        response = JSON.parse(xhr.response); // Parse the JSON response
                    } catch (e) {
                        console.error('Could not parse response as JSON:', e);
                        return;
                    }
                    if (response.success) {
                        sendFile(addPosterUrlInput.files[0]);
                        sendFile(addPromoUrlInput.files[0]);
                        alert('Success! Movie added successfully.');
                        window.location.reload();
                        clearValues('add');

                    } else {
                        // Display error messages
                        const errors = response.errors;
                        Object.keys(errors).forEach(key => {
                            const errorElement = document.getElementById(`error-add-movie-${key}`);
                            errorElement.textContent = errors[key];
                            errorElement.classList.remove('hidden');
                        });
                    }
                }
            };
            // Send data as URL-encoded string
            const params = Object.keys(movieData)
                .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(movieData[key])}`)
                .join('&');
            xhr.send(params);
        });

        /*== Edit Movie ==*/
        const editMovieIdInput = document.getElementById('editMovieIdInput');
        const editMovieModal = document.getElementById('editMovieModal');
        const editMovieForm = document.getElementById('editMovieForm');
        const editMovieButton = document.getElementById('editMovieButton');
        const editTitleInput = document.getElementById('editTitleInput');
        const editDescriptionInput = document.getElementById('editDescriptionInput');
        const editDurationInput = document.getElementById('editDurationInput');
        const editLanguageInput = document.getElementById('editLanguageInput');
        const editReleaseDateInput = document.getElementById('editReleaseDateInput');
        const editPosterUrlInput = document.getElementById('editPosterUrlInput');
        const editPromoUrlInput = document.getElementById('editPromoUrlInput');
        const promoImageNameDisplay = document.getElementById('promoImageNameDisplay');
        const posterImageNameDisplay = document.getElementById('posterImageNameDisplay');
        const editTrailerUrlInput = document.getElementById('editTrailerUrlInput');
        const editRatingInput = document.getElementById('editRatingInput');
        const clearEditGenres = document.getElementById('clearEditGenres');
        const editGenreCheckboxContainer = document.getElementById('editGenreCheckboxContainer');
        const errorEditMovieMessageGeneral = document.getElementById('error-edit-movie-general');

        let selectedEditGenres = [];

        // Add event listener to checkboxes
        editGenreCheckboxContainer.addEventListener('change', (event) => {
            if (event.target.type === 'checkbox') {
                updateSelectedEditGenres();
            }
        });

        // Function to update selected genres array
        function updateSelectedEditGenres() {
            // Get all checkboxes inside the container
            const checkboxes = editGenreCheckboxContainer.querySelectorAll('input[type="checkbox"]:checked');
            // Update the array with the values of checked checkboxes
            selectedEditGenres = Array.from(checkboxes).map(checkbox => checkbox.value);
        }

        // Clear all selected genres
        clearGenresButton.addEventListener('click', () => {
            // Get all checkboxes inside the container
            const checkboxes = addGenreCheckboxContainer.querySelectorAll('input[type="checkbox"]');
            // Uncheck all checkboxes
            checkboxes.forEach(checkbox => (checkbox.checked = false));
            // Clear the selected genres array
            selectEditGenres = [];
        });

        editPromoUrlInput.addEventListener("change", function(event) {
            const fileName = event.target.files[0]?.name || "No file selected";
            promoImageNameDisplay.textContent = fileName;
        });

        editPosterUrlInput.addEventListener("change", function(event) {
            const fileName = event.target.files[0]?.name || "No file selected";
            posterImageNameDisplay.textContent = fileName;
        });


        window.openEditMovieModal = function(anotherMovieData) {
            const movie = JSON.parse(anotherMovieData);
            editTitleInput.value = movie.title;
            editDescriptionInput.value = movie.description;
            editDurationInput.value = movie.duration;
            editLanguageInput.value = movie.language;
            editReleaseDateInput.value = movie.releaseDate;
            posterImageNameDisplay.textContent = movie.posterURL;
            promoImageNameDisplay.textContent = movie.promoURL;
            editTrailerUrlInput.value = movie.trailerURL;
            editRatingInput.value = movie.rating;
            genres: movie.genres.forEach(genre => {
                const checkbox = document.getElementById(`editGenre-${genre}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            }),
                editMovieIdInput.value = movie.id;
            editMovieModal.classList.remove('hidden');
        };

        editMovieButton.addEventListener('click', () => {
            editMovieButton.classList.remove('hidden');

        });

        // Close the Edit modal
        document.getElementById('cancelEditMovieButton').addEventListener('click', () => {
            editMovieModal.classList.add('hidden');
            clearValues('edit');
        });

        //Edit movie form submission
        editMovieForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const xhr = new XMLHttpRequest();
            const baseRoute = '<?php echo $_SESSION['baseRoute']; ?>';
            xhr.open('PUT', `${baseRoute}movies/edit`, true);

            let poster = posterImageNameDisplay.textContent;
            if (editPosterUrlInput.files.length == 1) {
                poster = editPosterUrlInput.files[0].name;
            }

            let promo = promoImageNameDisplay.textContent;
            if (editPromoUrlInput.files.length == 1) {
                promo = editPromoUrlInput.files[0].name;
            }
                console.log(selectedEditGenres);
            const editMovieData = {
                action: 'editMovie',
                title: editTitleInput.value,
                description: editDescriptionInput.value,
                duration: editDurationInput.value,
                language: editLanguageInput.value,
                releaseDate: editReleaseDateInput.value,
                posterURL: poster,
                promoURL: promo,
                trailerURL: editTrailerUrlInput.value,
                rating: editRatingInput.value,
                movieId: editMovieIdInput.value,
                genres: selectedEditGenres
            };

            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                // If the request is done and successful
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response;
                    console.log(xhr.response);
                    try {
                        response = JSON.parse(xhr.response);
                    } catch (e) {
                        console.error('Could not parse response as JSON:', e);
                        return;
                    }
                    if (response.success) {
                        sendFile(editPosterUrlInput.files[0]);
                        sendFile(editPromoUrlInput.files[0]);
                        alert('Success! Movie edited successfully.');
                        window.location.reload();
                        clearValues('edit');
                    }
                    // Display error messages
                    else {
                        if (response.errors['title']) {
                            errorEditMovieMessageTitle.textContent = response.errors['title'];
                            errorEditMovieMessageTitle.classList.remove('hidden');
                        }
                        if (response.errors['description']) {
                            errorEditMovieMessageDescription.textContent = response.errors['description'];
                            errorEditMovieMessageDescription.classList.remove('hidden');
                        }
                        if (response.errors['duration']) {
                            errorEditMovieMessageDuration.textContent = response.errors['duration'];
                            errorEditMovieMessageDuration.classList.remove('hidden');
                        }
                        if (response.errors['language']) {
                            errorEditMovieMessageLanguage.textContent = response.errors['language'];
                            errorEditMovieMessageLanguage.classList.remove('hidden');
                        }
                        if (response.errors['releaseDate']) {
                            errorEditMovieMessageReleaseDate.textContent = response.errors['releaseDate'];
                            errorEditMovieMessageReleaseDate.classList.remove('hidden');
                        }
                        if (response.errors['posterUrl']) {
                            errorEditMovieMessagePosterUrl.textContent = response.errors['posterUrl'];
                            errorEditMovieMessagePosterUrl.classList.remove('hidden');
                        }
                        if (response.errors['promoURL']) {
                            errorEditMovieMessagePromoUrl.textContent = response.errors['promoURL'];
                            errorEditMovieMessagePromoUrl.classList.remove('hidden');
                        }
                        if (response.errors['trailerUrl']) {
                            errorEditMovieMessageTrailerUrl.textContent = response.errors['trailerUrl'];
                            errorEditMovieMessageTrailerUrl.classList.remove('hidden');
                        }
                        if (response.errors['rating']) {
                            errorEditMovieMessageRating.textContent = response.errors['rating'];
                            errorEditMovieMessageRating.classList.remove('hidden');
                        }
                        if (response.errors['general']) {
                            errorEditMovieMessageGeneral.textContent = response.errors['general'];
                            errorEditMovieMessageGeneral.classList.remove('hidden');
                        }
                        if (response.errorMessage) {
                            console.error('Error:', response.errorMessage);
                        } else {
                            console.error('Error:', response.errors);
                        }
                    }
                }
            };

            //Send data as URL-encoded string
            const params = Object.keys(editMovieData)
                .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(editMovieData[key])}`)
                .join('&');
            xhr.send(params);
        });

        const archiveMovieModal = document.getElementById('archiveMovieModal');
        const archiveMovieIdInput = document.getElementById('archiveMovieIdInput');
        const confirmArchiveMovieButton = document.getElementById('confirmArchiveMovieButton');
        const cancelArchiveMovieButton = document.getElementById('cancelArchiveMovieButton');

        //Open the archive modal
        window.openArchiveMovieModal = function(movieId) {
            if (archiveMovieIdInput && archiveMovieModal) { //not necessary??
                archiveMovieIdInput.value = movieId;
                archiveMovieModal.classList.remove('hidden');
            } else {
                console.error('Required elements are missing from the DOM.');
            }
        };

        //Close the archive modal
        if (cancelArchiveMovieButton) {
            cancelArchiveMovieButton.addEventListener('click', () => {
                archiveMovieModal.classList.add('hidden');
            });
        }

        // Add click event listener for confirm archive movie button
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('confirmArchiveMovieButton')) {
                const movieId = event.target.dataset.movieId;
                archiveMovieIdInput.value = movieId;
            }
        });

        // Close the archive modal and clear the input value
        cancelArchiveMovieButton.addEventListener('click', () => {
            archiveMovieModal.classList.add('hidden');
            archiveMovieIdInput.value = '';
        });

        //Archive movie
        confirmArchiveMovieButton.addEventListener('click', function(event) {
            const xhr = new XMLHttpRequest();
            const baseRoute = '<?php echo $_SESSION['baseRoute']; ?>';
            const movieId = archiveMovieIdInput.value;

            xhr.open('PUT', `${baseRoute}movies/archive`, true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response
                    try {
                        response = JSON.parse(xhr.response);
                    } catch (e) {
                        console.error('Could not parse response as JSON:', e);
                        return;
                    }

                    if (response.success) {
                        alert('Success! Movie archived successfully.');
                        window.location.reload();
                        clearValues('archive');
                        archiveMovieModal.classList.add('hidden');
                    } else {
                        console.error('Error:', response.errorMessage);
                    }
                }
            };
            // Send the request with movieId in URL parameters or form data
            xhr.send(`movieId=${movieId}&action=archiveMovie`);
        });

        // Restore Movie Modal
        const restoreMovieModal = document.getElementById('restoreMovieModal');
        const restoreMovieIdInput = document.getElementById('restoreMovieIdInput');
        const confirmRestoreMovieButton = document.getElementById('confirmRestoreMovieButton');
        const cancelRestoreMovieButton = document.getElementById('cancelRestoreMovieButton');

        // Open the restore modal
        window.openRestoreMovieModal = function(movieId) {
            if (restoreMovieIdInput && restoreMovieModal) {
                restoreMovieIdInput.value = movieId;
                restoreMovieModal.classList.remove('hidden');
            } else {
                console.error('Required elements are missing from the DOM.');
            }
        };

        // Close the restore modal
        if (cancelRestoreMovieButton) {
            cancelRestoreMovieButton.addEventListener('click', () => {
                restoreMovieModal.classList.add('hidden');
                restoreMovieIdInput.value = '';
            });
        }

        // Confirm restore movie
        confirmRestoreMovieButton.addEventListener('click', function(event) {
            const xhr = new XMLHttpRequest();
            const baseRoute = '<?php echo $_SESSION['baseRoute']; ?>';
            const movieId = restoreMovieIdInput.value;

            xhr.open('PUT', `${baseRoute}movies/restore`, true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response;
                    try {
                        response = JSON.parse(xhr.response);
                    } catch (e) {
                        console.error('Could not parse response as JSON:', e);
                        return;
                    }

                    if (response.success) {
                        alert('Success! Movie restored successfully.');
                        window.location.reload();
                        restoreMovieModal.classList.add('hidden');
                    } else {
                        console.error('Error:', response.errorMessage);
                    }
                }
            };
            // Send the request with movieId in URL parameters or form data
            xhr.send(`movieId=${movieId}&action=restoreMovie`);
        });

        //Clear error messages and input values
        function clearValues(action) {
            if (action === 'edit') {
                editMovieForm.reset();
            } else if (action === 'add') {
                addMovieForm.reset();
            } else if (action === 'archive') {
                errorArchiveMovieMessageGeneral.classList.add('hidden');
                archiveMovieIdInput.value = '';
                archiveMovieForm.reset();
            }
        }
    });
</script>