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

<script>
document.addEventListener('DOMContentLoaded', () => {
    /*== Add News ==*/
    const addNewsModal = document.getElementById('addNewsModal');
    const addNewsForm = document.getElementById('addNewsForm');
    const addNewsButton = document.getElementById('addNewsButton');
    const errorAddMessageHeader = document.getElementById('error-add-header');
    const errorAddMessageContent = document.getElementById('error-add-content');
    // const addImageURLInput = document.getElementById('addImageURLInput');

    // Display the modal
    addNewsButton.addEventListener('click', () => {
        addNewsModal.classList.remove('hidden');
    });

    // Close the modal
    document.getElementById('cancelAddNewsButton').addEventListener('click', () => {
        addNewsModal.classList.add('hidden');
        clearValues('add');
    });
});
</script>


