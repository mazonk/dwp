<?php
include_once "src/controller/NewsController.php";

include_once "src/view/components/admin-sections/news/NewsCardAdmin.php";
?>

<div>
    <div class="flex justify-between my-[2rem]">
        <h3 class="text-[1.5rem] font-semibold">News</h3>
        <button id="addNewsButton" class="bg-primary text-textDark py-2 px-4 rounded hover:bg-primaryHover">
            Add News
        </button>
    </div>
    <!-- Display all news in cards -->
    <div id="tab-content" class="grid grid-cols-1 gap-4">
        <?php
        $newsController = new NewsController();
        $allNews = $newsController->getAllNews();

        if (isset($allNews['errorMessage'])) {
            echo $allNews['errorMessage'];
        } else {
            // Loop through each news item and render it using NewsCard
            echo '<div class="flex items-start flex-wrap gap-[1rem]">';
            foreach ($allNews as $news) {
                NewsCardAdmin::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
            }
            echo '</div>';
        }
        ?>
    </div>

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
                        <p id="error-add-header"  class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- <div class="mb-4">
                        <label for="addImageURLInput" class="block text-sm font-medium text-text-textLight">Image</label>
                        <input type="file" id="addImageURLInput" name="addImageURLInput" class="hidden" required>
                        <label for="addImageURLInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">Choose a file</label>
                    </div> -->
                    <div class="mb-4">
                        <label for="addContentInput" class="block text-sm font-medium text-text-textLight">Content</label>
                        <textarea id="addContentInput" name="addContentInput" rows="4" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required></textarea>
                        <p id="error-add-content" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
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
                        <p id="error-edit-header"  class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- <div class="mb-4">
                        <label for="editImageURLInput" class="block text-sm font-medium text-text-textLight">Image</label>
                        <input type="file" id="editImageURLInput" name="editImageURLInput" class="hidden" required>
                        <label for="editImageURLInput" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">Choose a file</label>
                    </div> -->
                    <div class="mb-4">
                        <label for="editContentInput" class="block text-sm font-medium text-text-textLight">Content</label>
                        <textarea id="editContentInput" name="editContentInput" rows="4" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required></textarea>
                        <p id="error-edit-content" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" id="saveEditNewsButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Save</button>
                        <button type="button" id="cancelEditNewsButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                    </div>
                </form>
            </div>
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
    /* const addImageURLInput = document.getElementById('addImageURLInput'); */

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
        xhr.open('PUT', `${baseRoute}news/add`, true);
        
        const newsData = {
            action: 'addNews',
            header: document.getElementById('addHeaderInput').value,
            /* imageURL: imageInput.files[0], */ // TODO: Implement image upload
            imageURL: 'gotham_news.jpg',
            content: document.getElementById('addContentInput').value
        }

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            // If the request is done and successful
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response;
                try {
                    response = JSON.parse(xhr.response); // Parse the JSON response
                } catch (e) {
                    console.error('Could not parse response as JSON:', e);
                    return;
                }

                if (response.success) {
                    alert('Success! News added successfully.');
                    window.location.reload();
                    clearValues('add');
                } else {
                    // Display error messages
                    if (response.errors['header']) {
                        errorAddMessageHeader.textContent = response.errors['header'];
                        errorAddMessageHeader.classList.remove('hidden');
                    }
                    if (response.errors['content']) {
                        errorAddMessageContent.textContent = response.errors['content'];
                        errorAddMessageContent.classList.remove('hidden');
                    }
                    console.error('Error:', response.errors);
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
    /* const editImageURLInput = document.getElementById('editImageURLInput'); */
    const editHeaderInput = document.getElementById('editHeaderInput');
    const editContentInput = document.getElementById('editContentInput');
    const errorEditMessageHeader = document.getElementById('error-edit-header');
    const errorEditMessageContent = document.getElementById('error-edit-content');

    // Open the Edit Modal and populate it with data
    window.openEditModal = function(newsId, header, imageURL, content) {
        editNewsId.value = newsId;
        editHeaderInput.value = header;
        /* editImageURLInput.value = imageURL; */
        editContentInput.value = content;
        editNewsModal.classList.remove('hidden');
    };

    // Clear error messages and input values
    function clearValues(action) {
        if (action === 'edit') {
            errorEditMessageHeader.classList.add('hidden');
            errorEditMessageContent.classList.add('hidden');
            editNewsForm.reset();
        }
        else if (action === 'add') {
            errorAddMessageHeader.classList.add('hidden');
            errorAddMessageContent.classList.add('hidden');
            addNewsForm.reset();
        }
    }
});
</script>