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