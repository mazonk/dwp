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
                        <label for="header" class="block text-sm font-medium text-text-textLight">Header</label>
                        <input type="text" id="header" name="header" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required>
                        <p id="error-header"  class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <!-- <div class="mb-4">
                        <label for="imageURL" class="block text-sm font-medium text-text-textLight">Image</label>
                        <input type="file" id="imageURL" name="imageURL" class="hidden" required>
                        <label for="imageURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">Choose a file</label>
                    </div> -->
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-text-textLight">Content</label>
                        <textarea id="content" name="content" rows="4" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required></textarea>
                        <p id="error-content" class="mt-1 text-red-500 hidden text-xs mb-[.25rem]"></p>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" id="saveAddNewsButton" class="bg-primary text-textDark py-2 px-4 rounded border border-transparent hover:bg-primaryHover duration-[.2s] ease-in-out">Add</button>
                        <button type="button" id="cancelAddNewsButton" class="text-textLight py-2 px-4 border-[1px] border-white rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Add News Modal
    const addNewsModal = document.getElementById('addNewsModal');
    const addNewsForm = document.getElementById('addNewsForm');
    const addNewsButton = document.getElementById('addNewsButton');
    const errorMessageHeader = document.getElementById('error-header');
    const errorMessageContent = document.getElementById('error-content');
    /* const imageInput = document.getElementById('imageURL'); */

    // Display the modal
    addNewsButton.addEventListener('click', () => {
        addNewsModal.classList.remove('hidden');
    });

    // Close the modal
    document.getElementById('cancelAddNewsButton').addEventListener('click', () => {
        addNewsModal.classList.add('hidden');
        clearValues();
    });

    // Clear error messages and input values
    function clearValues() {
        errorMessageHeader.classList.add('hidden');
        errorMessageContent.classList.add('hidden');
        addNewsForm.reset();
    }

    addNewsForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        const xhr = new XMLHttpRequest();
        const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
        xhr.open('PUT', `${baseRoute}news/add`, true);
        
        const newsData = {
            action: 'addNews',
            header: document.getElementById('header').value,
            /* imageURL: imageInput.files[0], */ // TODO: Implement image upload
            imageURL: 'gotham_news.jpg',
            content: document.getElementById('content').value
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
                    clearValues();
                } else {
                    // Display error messages
                    if (response.errors['header']) {
                        errorMessageHeader.textContent = response.errors['header'];
                        errorMessageHeader.classList.remove('hidden');
                    }
                    if (response.errors['content']) {
                        errorMessageContent.textContent = response.errors['content'];
                        errorMessageContent.classList.remove('hidden');
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
});
</script>