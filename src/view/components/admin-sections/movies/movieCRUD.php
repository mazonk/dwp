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
                        <label for="addPosterURLInput" class="block text-sm font-medium text-textLight">Poster URL</label>
                        <input type="url" id="addPosterURLInput" name="posterURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                    </div>

                    <!-- Promo URL Field -->
                    <div class="mb-4">
                        <label for="addPromoURLInput" class="block text-sm font-medium text-textLight">Promo URL</label>
                        <input type="url" id="addPromoURLInput" name="promoURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                    </div>

                    <!-- Trailer URL Field -->
                    <div class="mb-4">
                        <label for="addTrailerURLInput" class="block text-sm font-medium text-textLight">Trailer URL</label>
                        <input type="url" id="addTrailerURLInput" name="trailerURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                    </div>

                    <!-- Rating Field -->
                    <div class="mb-4">
                        <label for="addRatingInput" class="block text-sm font-medium text-textLight">Rating</label>
                        <input type="number" step="0.1" max="10" min="0" id="addRatingInput" name="rating" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
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
                        <label for="editPosterURLInput" class="block text-sm font-medium text-textLight">Poster URL</label>
                        <input type="url" id="editPosterURLInput" name="posterURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                    </div>

                    <!-- Promo URL Field -->
                    <div class="mb-4">
                        <label for="editPromoURLInput" class="block text-sm font-medium text-textLight">Promo URL</label>
                        <input type="url" id="editPromoURLInput" name="promoURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                    </div>

                    <!-- Trailer URL Field -->
                    <div class="mb-4">
                        <label for="editTrailerURLInput" class="block text-sm font-medium text-textLight">Trailer URL</label>
                        <input type="url" id="editTrailerURLInput" name="trailerURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
                    </div>

                    <!-- Rating Field -->
                    <div class="mb-4">
                        <label for="editRatingInput" class="block text-sm font-medium text-textLight">Rating</label>
                        <input type="number" step="0.1" max="10" min="0" id="editRatingInput" name="rating" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">
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

    <!-- Delete Movie Modal -->
    <div id="deleteMovieModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="bg-bgSemiDark w-[500px] rounded-lg p-6 border-[1px] border-borderDark">
                <h2 class="text-[1.5rem] text-center font-semibold mb-4">Delete Movie</h2>
                <p class="text-textLight text-center">Are you sure you want to delete this movie?</p>
                <input type="hidden" id="deleteMovieId" name="deleteMovieId">
                <div class="flex justify-center mt-4">
                    <button id="confirmDeleteMovieButton" class="bg-red-500 text-white py-2 px-4 border-[1px] border-transparent rounded hover:bg-red-600 duration-[.2s] ease-in-out">Delete</button>
                    <button id="cancelDeleteMovieButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const addMovieForm = document.getElementById('addMovieForm');
    const addMovieButton = document.getElementById('addMovieButton');
    const addMovieModal = document.getElementById('addMovieModal');
    const errorMessage = document.getElementById('errorMessage');
    const errorMessageElement = document.getElementById('error-message');
    const movieId = document.getElementById('movieId');
    const title = document.getElementById('title');
    const description = document.getElementById('description');
    const releaseDate = document.getElementById('releaseDate');
    const posterURL = document.getElementById('posterURL');
    const promoURL = document.getElementById('promoURL');
    const trailerURL = document.getElementById('trailerURL');
    const rating = document.getElementById('rating');

    // Display the modal
    addMovieButton.addEventListener('click', () => {
        addMovieModal.classList.remove('hidden');
    });

    // Close the modal
    document.getElementById('cancelAddMovieButton').addEventListener('click', () => {
        addMovieModal.classList.add('hidden');
        clearValues('add');
    });

    // document.querySelectorAll('.movieCard').forEach((movieCard) => {
    //     movieCard.addEventListener('click', () => {
    //         const movie = JSON.parse(movieCard.dataset.movie);
    //         movieId.value = movie.id;
    //         title.value = movie.title;
    //         description.value = movie.description;
    //         releaseDate.value = movie.releaseDate;
    //         posterURL.value = movie.posterURL;
    //         promoURL.value = movie.promoURL;
    //         trailerURL.value = movie.trailerURL;
    //         rating.value = movie.rating;
    //     })
    // });


    // Add movie form submission
    addMovieForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const xhr = new XMLHttpRequest();
        const baseRoute = '<?php echo $_SESSION['baseRoute']; ?>';
        xhr.open('POST', `${baseRoute}movie/add`, true);

        const movieData = {
            action: 'addMovie',
            title: document.getElementById('addTitleInput').value,
            description: document.getElementById('addDescriptionInput').value,
            releaseDate: document.getElementById('addReleaseDateInput').value,
            // posterURL: document.getElementById('addPosterURLInput').value,
            imageURL: 'gotham_news.jpg',
            trailerURL: document.getElementById('addTrailerURLInput').value,
            promoURL: document.getElementById('addPromoURLInput').value,
            rating: document.getElementById('addRatingInput').value
        }

        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            // If the request is done and successful
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response
                console.log(xhr.response);
                try {
                    response = JSON.parse(xhr.response); // Parse the JSON response
                } catch (e) {
                    console.error('Could not parse response as JSON:', e);
                    return;
                }
                if (response.success) {
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
    const editMovieModal = document.getElementById('editMovieModal');
    const editMovieForm = document.getElementById('editMovieForm');
    const editMovieButton = document.getElementById('editMovieButton');
    const editTitleInput = document.getElementById('editTitleInput');
    const editDescriptionInput = document.getElementById('editDescriptionInput');
    const editDurationInput = document.getElementById('editDurationInput');
    const editLanguageInput = document.getElementById('editLanguageInput');
    const editReleaseDateInput = document.getElementById('editReleaseDateInput');
    const editPosterUrlInput = document.getElementById('editPosterUrlInput');
    const editTrailerUrlInput = document.getElementById('editTrailerUrlInput');
    const editRatingInput = document.getElementById('editRatingInput');
    const errorEditMovieMessageGeneral = document.getElementById('error-edit-movie-general');

    window.openEditMovieModal = function(title, description, duration, language, releaseDate, posterUrl, trailerUrl, rating) {
        editTitleInput.value = title;
        editDescriptionInput.value = description;
        editDurationInput.value = duration;
        editLanguageInput.value = language;
        editReleaseDateInput.value = releaseDate;
        editPosterUrlInput.value = posterUrl;
        editPromoUrlInput.value = promoURL;
        editTrailerUrlInput.value = trailerUrl;
        editRatingInput.value = rating;
        editMovieModal.classList.remove('hidden');
    };

    // Close the Edit modal
    document.getElementById('cancelEditMovieButton').addEventListener('click', () => {
        editMovieModal.classList.add('hidden');
        clearValues('edit');
    });

    //Edit movie form submission
    editMovieForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const xhr = new XMLHttpRequest();
        const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
        xhr.open('PUT', `${baseRoute}movies/edit`, true);

        const editMovieData = {
            action: 'editMovie',
            title: editTitleInput.value,
            description: editDescriptionInput.value,
            duration: editDurationInput.value,
            language: editLanguageInput.value,
            releaseDate: editReleaseDateInput.value,
            posterUrl: editPosterUrlInput.value,
            promoURL: editPromoUrlInput.value,
            trailerUrl: editTrailerUrlInput.value,
            rating: editRatingInput.value
        };

        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            // If the request is done and successful
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response;
                try {
                    response = JSON.parse(xhr.response);
                } catch (e) {
                    console.error('Could not parse response as JSON:', e);
                    return;
                }
                if (response.success) {
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

    const deleteMovieModal = document.getElementById('deleteMovieModal');
    const confirmDeleteMovieButton = document.getElementById('confirmDeleteMovieButton');
    const cancelDeleteMovieButton = document.getElementById('cancelDeleteMovieButton');

    //Open the delete modal
    window.openDeleteMovieModal = function(movieId) {
        deleteMovieIdInput.value = movieId;
        deleteMovieModal.classList.remove('hidden');
    };

    //Close the delete modal
    cancelDeleteMovieButton.addEventListener('click', () => {
        deleteMovieModal.classList.add('hidden');
    })

    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('confirmDeleteMovieButton')) {
            const movieId = event.target.dataset.movieId;
            deleteMovieIdInput.value = movieId;
            deleteMovieModal.classList.remove('hidden');
        }
    });

    cancelDeleteMovieButton.addEventListener('click', () => {
        deleteMovieModal.classList.add('hidden');
        deleteMovieIdInput.value = '';
    });

    //Delete movie
    confirmDeleteMovieButton.addEventListener('click', () => {
        const movieId = confirmDeleteMovieButton.value;
        const xhr = new XMLHttpRequest();
        const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
        xhr.open('DELETE', `${baseRoute}movie/delete?movieId=${encodeURIComponent(movieId)}&action=deleteMovie`, true);

        xhr.onreadystatechange = function() {
            // If the request is done and successful
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response;
                try {
                    response = JSON.parse(xhr.response);
                } catch (e) {
                    console.error('Could not parse response as JSON:', e);
                    return;
                }
                if (response.success) {
                    alert('Success! Movie deleted successfully.');
                    window.location.reload();
                } else {
                    console.error('Error:', response.errorMessage);
                }
            }
        };
        xhr.send();
    });
    //Clear error messages and input values
    function clearValues(action) {
        if (action === 'edit') {
            errorEditMovieMessageTitle.classList.add('hidden');
            errorEditMovieMessageDescription.classList.add('hidden');
            errorEditMovieMessageDuration.classList.add('hidden');
            errorEditMovieMessageLanguage.classList.add('hidden');
            errorEditMovieMessageReleaseDate.classList.add('hidden');
            errorEditMovieMessagePosterUrl.classList.add('hidden');
            errorEditMovieMessagePromoUrl.classList.add('hidden');
            errorEditMovieMessageTrailerUrl.classList.add('hidden');
            errorEditMovieMessageRating.classList.add('hidden');
            errorEditMovieMessageGeneral.classList.add('hidden');
            editMovieForm.reset();
        }
        else if (action === 'add') {
            errorAddMovieMessageTitle.classList.add('hidden');
            errorAddMovieMessageDescription.classList.add('hidden');
            errorAddMovieMessageDuration.classList.add('hidden');
            errorAddMovieMessageLanguage.classList.add('hidden');
            errorAddMovieMessageReleaseDate.classList.add('hidden');
            errorAddMovieMessagePosterUrl.classList.add('hidden');
            errorAddMovieMessagePromoUrl.classList.add('hidden');
            errorAddMovieMessageTrailerUrl.classList.add('hidden');
            errorAddMovieMessageRating.classList.add('hidden');
            errorAddMovieMessageGeneral.classList.add('hidden');
            addMovieForm.reset();
        }
    }
});
</script>
