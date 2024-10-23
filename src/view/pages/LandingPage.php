<?php
require_once 'session_config.php';

include_once "src/controller/NewsController.php";
include_once "src/controller/ShowingController.php";

include_once "src/view/components/NewsCard.php";
include_once "src/view/components/MovieCard.php";

$newsController = new NewsController();
$showingController = new ShowingController();

$tab = 'news'; // Default to 'news'
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Set default page number

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tab'])) {
        // Render content based on the selected tab
        if ($_POST['tab'] === 'news') {
            $allNews = $newsController->getNews();
            echo '<div class="grid grid-cols-3 gap-4 flex flex-row items-center">';
            foreach ($allNews as $news) {
                NewsCard::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
            }
            echo '</div>';
        } elseif ($_POST['tab'] === 'company') {
            echo '<h2 class="text-2xl font-bold text-white">Company Information</h2>';
            echo '<p class="text-lg text-gray-300 mt-4">Space reserved for company info.</p>';
        } elseif ($_POST['tab'] === 'tickets') {
            echo '<h2 class="text-2xl font-bold text-white">Ticket Prices</h2>';
            echo '<p class="text-lg text-gray-300 mt-4">Space reserved for ticket prices.</p>';
        }
        exit; // End script after handling tab content
    }

}

$moviesPerPage = 5;

// Get the total number of movies playing today
$moviesPlayingToday = $showingController->getMoviesPlayingToday($_SESSION['selectedVenueId']); //TODO: change to get venueid from session
$totalMovies = count($moviesPlayingToday);

// Calculate the starting index
$startIndex = ($page - 1) * $moviesPerPage;

// Check if we have enough movies for the current page
if ($startIndex + $moviesPerPage > $totalMovies) {
    $startIndex = max(0, $totalMovies - $moviesPerPage); // Adjust startIndex if we exceed total movies
}

// Fetch the subset of movies for the current page
$moviesToDisplay = array_slice($moviesPlayingToday, $startIndex, $moviesPerPage);

// Ensure the display logic is correct for the last page
if ($page > 1 && $startIndex === 0) {
    // On the first page and there are more than 5 movies
    // Show the last 5 movies if available
    $moviesToDisplay = array_slice($moviesPlayingToday, -$moviesPerPage);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWP Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            //get html elements
            const prevPageButton = document.getElementById('prevPage');
            const nextPageButton = document.getElementById('nextPage');
            const tabs = document.querySelectorAll('.tab');

            //init values
            let currentPage = <?php echo $page; ?>;
            let currentTab = '<?php echo $tab; ?>';

            tabs.forEach((tab) => {
                tab.addEventListener('click', () => {
                    const selectedTab = tab.dataset.tab;
                    currentTab = selectedTab;
                    fetchTabContent(selectedTab);
                });
            });

            function fetchTabContent(tab) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById('tab-content').innerHTML = xhr.responseText;
                    }
                    // Update tab classes to reflect the active tab with underlining
                    tabs.forEach((t) => {
                        if (t.dataset.tab === tab) {
                            t.classList.add('underline', 'font-semibold');
                        } else {
                            t.classList.remove('underline', 'font-semibold');
                        }
                    });
                };
                xhr.send(`tab=${tab}`); // Send selected tab to the server
            }
        });
    </script>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto px-[100px] bg-bgDark text-textLight overflow-hidden">
    <!-- Navbar -->
    <?php include_once("src/view/components/Navbar.php"); ?>
    
    <main class="mt-16 p-4">
        <div class="flex items-center justify-between">
            <!-- Left Arrow - Previous -->
            <?php if ($page > 1): ?>
                <butto id="prevPage" class="text-white p-2">
                    <i class="ri-arrow-left-s-line text-4xl"></i>
                </button>
            <?php else: ?>
                <!-- Empty space when no previous page -->
                <div class="w-[48px]"></div>
            <?php endif; ?>

            <!-- Daily showings -->
            <div id="dailyShowingsList" class="grid grid-cols-5 gap-4 w-full">
                <?php
                        foreach ($moviesToDisplay as $movie) {
                            MovieCard::render($movie, false);
                        }
                ?>
            </div>

            <!-- Right Arrow - Next -->
            <?php if ($startIndex + $moviesPerPage < $totalMovies): ?>
                <button id="nextPage" class="text-white p-2">
                    <i class="ri-arrow-right-s-line text-4xl ml-8"></i>
                </button>
            <?php else: ?>
                <!-- Empty space when no next page -->
                <div class="w-[48px]"></div>
            <?php endif; ?>
        </div>

        <!-- News/companyinfo/prices -->
        <!-- Tab Navigation -->
        <div class="flex space-x-4 justify-center mt-8 mb-8">
            <a data-tab="news" class="tab text-white cursor-pointer <?php echo $tab === 'news' ? 'underline font-semibold' : ''; ?>">News & Articles</a>
            <a data-tab="company" class="tab text-white cursor-pointer">Company Information</a>
            <a data-tab="tickets" class="tab text-white cursor-pointer">Ticket Prices</a>
        </div>

        <div id="tab-content" class="grid grid-cols-1 gap-4">
            <?php
            // Render news (rest is rendered above at the top of the file)
            if ($tab === 'news') {
                $allNews = $newsController->getNews();

                // Loop through each news item and render it using NewsCard
                echo '<div class="grid grid-cols-3 gap-4 flex flex-row items-center">';
                foreach ($allNews as $news) {
                    NewsCard::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
                }
                echo '</div>';
            }
            ?>
        </div>
    </main>
</body>
</html>
