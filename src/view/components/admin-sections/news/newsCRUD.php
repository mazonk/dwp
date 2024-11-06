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
            echo '<div class="flex items-center gap-[1rem]">';
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
                    </div>
                    <div class="mb-4">
                        <label for="imageURL" class="block text-sm font-medium text-text-textLight">Image</label>
                        <input type="file" id="imageURL" name="imageURL" class="hidden" required>
                        <label for="imageURL" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out">Choose a file</label>
                        
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-text-textLight">Content</label>
                        <textarea id="content" name="content" rows="4" class="mt-1 block w-full p-2 bg-bgDark border border-borderDark rounded-md outline-none focus:border-textNormal duration-[.2s] ease-in-out" required></textarea>
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
    const saveAddNewsButton = document.getElementById('saveAddNewsButton');
    const cancelAddNewsButton = document.getElementById('cancelAddNewsButton');
    const imageInput = document.getElementById('imageURL');

    // Display the modal
    addNewsButton.addEventListener('click', () => {
        addNewsModal.classList.remove('hidden');
    });

    // Hide the modal
    cancelAddNewsButton.addEventListener('click', () => {
        addNewsModal.classList.add('hidden');
    });

    saveButton.addEventListener('click', () => {
        
    });
});
</script>