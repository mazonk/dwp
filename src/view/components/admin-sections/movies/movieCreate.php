<?php
include_once "src/controller/MovieController.php";
include_once "src/view/components/admin-sections/movies/MovieCardAdmin.php";
?>
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
                    <input type="file" id="addPosterUrlInput" name="posterURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" accept="image/*" required>
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
                        <!-- Genre Item -->
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-1" name="genres[]" value="1" class="mr-2">
                            <label for="genre-1" class="text-[1rem] leading-tight">Action</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-2" name="genres[]" value="2" class="mr-2">
                            <label for="genre-2" class="text-[1rem] leading-tight">Drama</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-3" name="genres[]" value="3" class="mr-2">
                            <label for="genre-3" class="text-[1rem] leading-tight">Sci-fi</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-4" name="genres[]" value="4" class="mr-2">
                            <label for="genre-4" class="text-[1rem] leading-tight">Comedy</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-5" name="genres[]" value="5" class="mr-2">
                            <label for="genre-5" class="text-[1rem] leading-tight">Horror</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-6" name="genres[]" value="6" class="mr-2">
                            <label for="genre-6" class="text-[1rem] leading-tight">Fantasy</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-7" name="genres[]" value="7" class="mr-2">
                            <label for="genre-7" class="text-[1rem] leading-tight">Thriller</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-8" name="genres[]" value="8" class="mr-2">
                            <label for="genre-8" class="text-[1rem] leading-tight">Animation</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-9" name="genres[]" value="9" class="mr-2">
                            <label for="genre-9" class="text-[1rem] leading-tight">Mystery</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-10" name="genres[]" value="10" class="mr-2">
                            <label for="genre-10" class="text-[1rem] leading-tight">Romance</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-11" name="genres[]" value="11" class="mr-2">
                            <label for="genre-11" class="text-[1rem] leading-tight">Adventure</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-12" name="genres[]" value="12" class="mr-2">
                            <label for="genre-12" class="text-[1rem] leading-tight">Documentary</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="genre-13" name="genres[]" value="13" class="mr-2">
                            <label for="genre-13" class="text-[1rem] leading-tight">Musical</label>
                        </div>
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
            console.log(selectedGenres); // Log the selected genres array
        }

        // Clear all selected genres
        clearGenresButton.addEventListener('click', () => {
            // Get all checkboxes inside the container
            const checkboxes = addGenreCheckboxContainer.querySelectorAll('input[type="checkbox"]');
            // Uncheck all checkboxes
            checkboxes.forEach(checkbox => (checkbox.checked = false));
            // Clear the selected genres array
            selectedGenres = [];
            console.log(selectedGenres); // Log the cleared array
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
                rating: addRatingInput.value
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
    });
    </script>