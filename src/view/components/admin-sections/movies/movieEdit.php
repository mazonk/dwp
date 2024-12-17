<?php
include_once "src/controller/MovieController.php";
include_once "src/view/components/admin-sections/movies/MovieCardAdmin.php";
?>
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
        const errorEditMovieMessageGeneral = document.getElementById('error-edit-movie-general');

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

            let poster = '<?php echo $editMovieData->getPosterURL();?>;
            if (editPosterUrlInput.files.length == 1) {
                poster = editPosterUrlInput.files[0].name;
            }

            let promo = '<?php echo $editMovieData->getPromoURL();?>;
            if (editPromoUrlInput.files.length == 1) {
                promo = editPromoUrlInput.files[0].name;
            }

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
                movieId: editMovieIdInput.value
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
        });
    });
</script>