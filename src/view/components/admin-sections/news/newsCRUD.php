<?php
include_once "src/controller/NewsController.php";
include_once "src/view/components/admin-sections/news/NewsCardAdmin.php";
?>

<div>
    <div class="flex justify-between my-[2rem]">
        <h3 class="text-[1.5rem] font-semibold">News</h3>
        <button id="addNewsButton" class="bg-primary font-bold text-textDark py-2 px-4 rounded hover:bg-primaryHover">
            Add News
        </button>
    </div>
    <!-- Display all news in cards -->
    <?php
    $newsController = new NewsController();
    $allNews = $newsController->getAllNews();

    if (isset($allNews['errorMessage'])) {
        echo htmlspecialchars($allNews['errorMessage']);
    } else {
        // Loop through each news item and render it using NewsCard
        echo '<div class="grid grid-cols-4 gap-4">';
        foreach ($allNews as $news) {
            NewsCardAdmin::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
        }
        echo '</div>';
    }
    ?>

    <!-- Add News Form Modal -->
    <div id="addNewsModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
                <h2 class="text-[1.5rem] text-center font-semibold mb-4">Add News</h2>
                <form id="addNewsForm" class="text-textLight">
                    <div class="mb-4">
                        <label for="addHeaderInput" class="block text-sm font-medium text-text-textLight">Header</label>
                        <input type="text" id="addHeaderInput" name="addHeaderInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                        <p id="error-add-news-header"  class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <div class="mb-4">
                        <label for="addImageURLInput" class="block text-sm font-medium text-text-textLight">Image</label>
                        <input type="file" id="addImageURLInput" name="addImageURLInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out"accept="image/*" required>
                    </div>
                    <div class="mb-4">
                        <label for="addContentInput" class="block text-sm font-medium text-text-textLight">Content</label>
                        <textarea id="addContentInput" name="addContentInput" rows="4" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required></textarea>
                        <p id="error-add-news-content" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <p id="error-add-news-general" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    <div class="flex justify-end">
                        <button type="submit" id="saveAddNewsButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
                        <button type="button" id="cancelAddNewsButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit News Form Modal -->
    <div id="editNewsModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="bg-bgSemiDark w-[600px] rounded-lg p-6 border-[1px] border-borderDark">
                <h2 class="text-[1.5rem] text-center font-semibold mb-4">Edit News</h2>
                <form id="editNewsForm" class="text-textLight">
                    <input type="hidden" id="editNewsId" name="editNewsId">
                    <div class="mb-4">
                        <label for="editHeaderInput" class="block text-sm font-medium text-text-textLight">Header</label>
                        <input type="text" id="editHeaderInput" name="editHeaderInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                        <p id="error-edit-news-header"  class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <div class="mb-4">
                        <label for="editImageURLInput" class="block text-sm font-medium text-text-textLight">Image</label>
                        <input type="file" id="editImageURLInput" name="editImageURLInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" accept="image/*" required>
                        <div id="editImageURLInputDisplay" class="mt-2 text-sm text-textLight"></div>
                    </div>
                    <div class="mb-4">
                        <label for="editContentInput" class="block text-sm font-medium text-text-textLight">Content</label>
                        <textarea id="editContentInput" name="editContentInput" rows="4" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required></textarea>
                        <p id="error-edit-news-content" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <p id="error-edit-news-general" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    <div class="flex justify-end">
                        <button type="submit" id="saveEditNewsButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Save</button>
                        <button type="button" id="cancelEditNewsButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete News Modal -->
    <div id="deleteNewsModal" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="bg-bgSemiDark w-[500px] rounded-lg p-6 border-[1px] border-borderDark">
                <h2 class="text-[1.5rem] text-center font-semibold mb-4">Delete News</h2>
                <p class="text-textLight text-center">Are you sure you want to delete this news?</p>
                <p id="deleteModalNewsHeader" class="text-gray-400 text-center"></p>
                <input type="hidden" id="deleteNewsId" name="deleteNewsId">
                <div class="flex justify-center mt-4">
                    <button id="confirmDeleteNewsButton" class="bg-red-500 text-white py-2 px-4 border-[1px] border-transparent rounded hover:bg-red-600 duration-[.2s] ease-in-out">Delete</button>
                    <button id="cancelDeleteNewsButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                </div>
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
    /*== Add News ==*/
    const addNewsModal = document.getElementById('addNewsModal');
    const addNewsForm = document.getElementById('addNewsForm');
    const addNewsButton = document.getElementById('addNewsButton');
    const errorAddNewsMessageHeader = document.getElementById('error-add-news-header');
    const errorAddNewsMessageContent = document.getElementById('error-add-news-content');
    const errorAddNewsGeneral = document.getElementById('error-add-news-general');
    const addImageURLInput = document.getElementById('addImageURLInput');

    // Display the modal
    addNewsButton.addEventListener('click', () => {
        addNewsModal.classList.remove('hidden');
    });

    // Close the modal
    document.getElementById('cancelAddNewsButton').addEventListener('click', () => {
        addNewsModal.classList.add('hidden');
        clearValues('add');
    });

    // Add news form submission
    addNewsForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        const xhr = new XMLHttpRequest();
        const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
        xhr.open('POST', `${baseRoute}news/add`, true);

        let image = "";
        if (addImageURLInput.files.length == 1) {
            image = addImageURLInput.files[0].name;
        }
        
        const newsData = {
            action: 'addNews',
            header: document.getElementById('addHeaderInput').value,
            imageURL: image,
            content: document.getElementById('addContentInput').value
        }

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            // If the request is done and successful
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response;
                console.log(xhr.response);
                try {
                    response = JSON.parse(xhr.response); // Parse the JSON response
                } catch (e) {
                    console.error('Could not parse response as JSON:', e);
                    return;
                }

                if (response.success) {
                    sendFile(addImageURLInput.files[0]);
                    alert('Success! News added successfully.');
                    window.location.reload();
                    clearValues('add');
                } else {
                    // Display error messages
                    if (response.errors['header']) {
                        errorAddNewsMessageHeader.textContent = response.errors['header'];
                        errorAddNewsMessageHeader.classList.remove('hidden');
                    }
                    if (response.errors['content']) {
                        errorAddNewsMessageContent.textContent = response.errors['content'];
                        errorAddNewsMessageContent.classList.remove('hidden');
                    }
                    if (response.errors['general']) {
                        errorAddNewsGeneral.textContent = response.errors['general'];
                        errorAddNewsGeneral.classList.remove('hidden');
                    }
                    if (response.errorMessage) {
                        console.error('Error:', response.errorMessage);
                    } else {
                        console.error('Error:', response.errors);
                    }
                }
            }
        };

        // Send data as URL-encoded string
        const params = Object.keys(newsData)
            .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(newsData[key])}`)
            .join('&');
        xhr.send(params);
    });

    /*== Edit News ==*/
    const editNewsModal = document.getElementById('editNewsModal');
    const editNewsForm = document.getElementById('editNewsForm');
    const editNewsId = document.getElementById('editNewsId');
    const editImageURLInput = document.getElementById('editImageURLInput');
    const editHeaderInput = document.getElementById('editHeaderInput');
    const editContentInput = document.getElementById('editContentInput');
    const errorEditNewsMessageHeader = document.getElementById('error-edit-news-header');
    const errorEditNewsMessageContent = document.getElementById('error-edit-news-content');
    const errorEditNewsGeneral = document.getElementById('error-edit-news-general');

    editImageURLInput.addEventListener('change', function(event) {
        const fileName = event.target.files[0]?.name || "No file selected";
        editImageURLInputDisplay.textContent = fileName;
    })

    // Open the Edit Modal and populate it with data
    window.openEditModal = function(newsId, header, imageURL, content) {
        editNewsId.value = newsId;
        editHeaderInput.value = header;
        editImageURLInputDisplay.textContent = imageURL;
        editContentInput.value = content;
        editNewsModal.classList.remove('hidden');
    };

    // Close the Edit Modal
    document.getElementById('cancelEditNewsButton').addEventListener('click', () => {
        editNewsModal.classList.add('hidden');
        clearValues('edit');
    });

    // Edit news form submission
    editNewsForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const xhr = new XMLHttpRequest();
        const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
        xhr.open('PUT', `${baseRoute}news/edit`, true);

        let image = "";
        if (editImageURLInput.files.length == 1) {
            image = editImageURLInput.files[0].name;
        }

        const newsData = {
            action: 'editNews',
            newsId: editNewsId.value,
            header: editHeaderInput.value,
            imageURL: image,
            content: editContentInput.value
        };

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
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
                    sendFile(editImageURLInput.files[0]);
                    alert('Success! News edited successfully.');
                    window.location.reload();
                    clearValues('edit');
                }
                // Display error messages
                else {
                    if (response.errors['header']) {
                        errorEditNewsMessageHeader.textContent = response.errors['header'];
                        errorEditNewsMessageHeader.classList.remove('hidden');
                    }
                    if (response.errors['content']) {
                        errorEditNewsMessageContent.textContent = response.errors['content'];
                        errorEditNewsMessageContent.classList.remove('hidden');
                    }
                    if (response.errors['general']) {
                        errorEditNewsGeneral.textContent = response.errors['general'];
                        errorEditNewsGeneral.classList.remove('hidden');
                    }
                    if (response.errorMessage) {
                        console.error('Error:', response.errorMessage);
                    } else {
                        console.error('Error:', response.errors);
                    }
                }
            }
        };

        // Send data as URL-encoded string
        const params = Object.keys(newsData)
            .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(newsData[key])}`)
            .join('&');
        xhr.send(params);
    });

    /*== Delete News ==*/
    const deleteNewsModal = document.getElementById('deleteNewsModal');
    const deleteModalNewsHeader = document.getElementById('deleteModalNewsHeader');
    const confirmDeleteNewsButton = document.getElementById('confirmDeleteNewsButton');
    const cancelDeleteNewsButton = document.getElementById('cancelDeleteNewsButton');
    const deleteNewsId = document.getElementById('deleteNewsId');

    // Open the Delete Modal
    window.openDeleteModal = function(newsId, header) {
        deleteNewsId.value = newsId;
        deleteModalNewsHeader.textContent = header;
        deleteNewsModal.classList.remove('hidden');
    };

    // Close the Delete Modal
    cancelDeleteNewsButton.addEventListener('click', () => {
        deleteNewsModal.classList.add('hidden');
    });

    // Delete news
    confirmDeleteNewsButton.addEventListener('click', () => {
        const xhr = new XMLHttpRequest();
        const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
        const newsId = deleteNewsId.value;

        xhr.open('DELETE', `${baseRoute}news/delete?newsId=${encodeURIComponent(newsId)}&action=deleteNews`, true); // newsId as query parameter

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
                    alert('Success! News deleted successfully.');
                    window.location.reload();
                } else {
                    console.error('Error:', response.errorMessage);
                }
            }
        };

        xhr.send();
    });

    // Clear error messages and input values
    function clearValues(action) {
        if (action === 'edit') {
            errorEditNewsMessageHeader.classList.add('hidden');
            errorEditNewsMessageContent.classList.add('hidden');
            errorEditNewsGeneral.classList.add('hidden');
            editNewsForm.reset();
        }
        else if (action === 'add') {
            errorAddNewsMessageHeader.classList.add('hidden');
            errorAddNewsMessageContent.classList.add('hidden');
            errorAddNewsGeneral.classList.add('hidden');
            addNewsForm.reset();
        }
    }
});


</script>