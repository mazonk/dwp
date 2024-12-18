<?php  require_once 'session_config.php';

require_once "src/controller/NewsController.php";
require_once "src/controller/ShowingController.php";
require_once 'src/controller/VenueController.php';
require_once 'src/controller/CompanyInfoController.php';
require_once 'src/controller/TicketController.php';

include_once "src/view/components/NewsCard.php";
include_once "src/view/components/MovieCard.php";

$venueController = new VenueController();
$newsController = new NewsController();
$showingController = new ShowingController();
$companyInfoController = new CompanyInfoController();
$ticketController = new TicketController();

$selectedVenue = $_SESSION['selectedVenueName'] ?? $venueController->getVenueById(1)->getName();
$_SESSION['selectedVenueName'] = $selectedVenue;

$tab = 'news'; // Default to 'news'
$page = 1; // Set default page number
$moviesPerPage = 5;

$companyInfo = $companyInfoController->getCompanyInfo();

$ticketTypes = $ticketController->getAllTicketTypes();

 //Fetch and render movies playing today based on pagination.
function renderMovies($showingController, $page, $moviesPerPage) {
    $moviesPlayingToday = $showingController->getMoviesPlayingToday($_SESSION['selectedVenueId']);
    if (isset($moviesPlayingToday['errorMessage'])) {
        echo "<div class='text-sm text-textNormal text-center leading-snug'>". htmlspecialchars($moviesPlayingToday['errorMessage']). "</div>";
        return;
    }
    $totalMovies = count($moviesPlayingToday);
    $startIndex = ($page - 1) * $moviesPerPage;

    // Ensure the start index doesn't exceed the total number of movies
    $startIndex = min($startIndex, max(0, $totalMovies - $moviesPerPage));

    $moviesToDisplay = array_slice($moviesPlayingToday, $startIndex, $moviesPerPage);

    // Render movie cards
    foreach ($moviesToDisplay as $movie) {
        MovieCard::render($movie, false);
    }
    echo "<script>const totalMovies = $totalMovies; const moviesPerPage = $moviesPerPage;</script>"; // adding js variables here so the script tag can use them

    return $totalMovies;
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tab'])) {
        // Render content based on the selected tab
        if ($_POST['tab'] === 'news') {
            $allNews = $newsController->getAllNews();
            
            if (isset($allNews['errorMessage'])) {
                echo $allNews['errorMessage'];
            } else {
                // Loop through each news item and render it using NewsCard
                echo '<div class="grid grid-cols-3 gap-4 flex flex-row items-center">';
                foreach ($allNews as $news) {
                    NewsCard::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
                }
                echo '</div>';
            }
        } elseif ($_POST['tab'] === 'company') {
            if (is_array($companyInfo) && isset($companyInfo['errorMessage'])) {
                echo $companyInfo['errorMessage'];
            } else {
                echo '<div class="flex items-center mb-4">';
                    echo '<img src="src/assets/'.htmlspecialchars($companyInfo->getLogoUrl()).'" alt="Company Logo" class="w-24 h-24 object-cover rounded-full mr-4">';
                    echo '<div>';
                        echo '<h2 class="text-xl font-semibold text-white" id="companyNameDisplay">'.htmlspecialchars($companyInfo->getCompanyName()).'</h2>';
                        echo '<p class="text-lg text-gray-300 mt-4 mb-4">'. $companyInfo->getCompanyDescription() .'</p>';
                        echo '<div class="flex flex-row space-x-1.5 text-white mb-2">';
                            $companyAddress = $companyInfo->getAddress();
                            echo '<p id="companyStreetNrDisplay">'.htmlspecialchars($companyAddress->getStreetNr()).'</p>';
                            echo '<p id="companyStreetDisplay">'.htmlspecialchars($companyAddress->getStreet()).',</p>';
                            echo '<p id="companyPostalCodeDisplay">'.htmlspecialchars($companyAddress->getPostalCode()->getPostalCode()).'</p>';
                            echo '<p id="companyCityDisplay">'.htmlspecialchars($companyAddress->getPostalCode()->getCity()).'</p>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
        } elseif ($_POST['tab'] === 'tickets') {
            echo '<h2 class="text-2xl font-bold text-white">Ticket Prices</h2>';
            echo '<div class="mt-4 grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">';
            if (isset($ticketTypes['errorMessage'])) {
                echo $ticketTypes['errorMessage'];
            } else {
                foreach ($ticketTypes as $ticketType) {
                    echo '<div class="bg-gray-800 p-4 rounded-lg shadow-md">';
                        echo '<h3 class="text-xl font-semibold text-yellow-300">' . htmlspecialchars($ticketType->getName()) . '</h3>';
                        echo '<p class="text-gray-300 mt-2">Price: $' . number_format($ticketType->getPrice(), 2) . '</p>';
                        echo '<p class="text-gray-400 mt-2">' . htmlspecialchars($ticketType->getDescription()) . '</p>';
                    echo '</div>';
                }
                echo '</div>';
            }
        }
        exit;
    }
    if (isset($_POST['page'])) {
        renderMovies($showingController, (int)$_POST['page'], $moviesPerPage);
        exit;
    }
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
            const prevPageButton = document.querySelector('#prev-page');
            const nextPageButton = document.querySelector('#next-page');
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

            // Handle pagination for daily showings
            prevPageButton?.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    fetchMovies();
                }
            });

            nextPageButton?.addEventListener('click', () => {
                currentPage++;
                fetchMovies();
            });

            function fetchMovies() {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '', true); //new post request to fulfil 
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById('dailyShowingsList').innerHTML = xhr.responseText;
                        prevPageButton.disabled = currentPage === 1;
                        const totalPages = Math.ceil(totalMovies / moviesPerPage);
                        nextPageButton.disabled = currentPage >= totalPages;
                        
                    }
                };
                xhr.send(`page=${currentPage}`); // Send current page to the server
            }

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
                            t.classList.add('underline', 'text-yellow-400' , 'font-semibold');
                        } else {
                            t.classList.remove('underline', 'text-yellow-400' ,'font-semibold');
                        }
                    });
                };
                xhr.send(`tab=${tab}`); // Send selected tab to the server
            }
        });
    </script>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto px-[100px] bg-bgDark text-textLight overflow-y-auto">
    <!-- Navbar -->
    <?php include_once("src/view/components/Navbar.php"); ?>

    <main class="mt-16 p-4">
        <div class="flex items-center justify-between">
            <!-- Left Arrow - Previous -->  
            <!-- Set button to disable, so they can't navigate to page < 1 -->
            <button disabled id="prev-page" class="text-white p-2 disabled:text-gray-500">
                <i class="ri-arrow-left-s-line text-4xl"></i>
            </button>

            <!-- Daily showings -->
            <div id="dailyShowingsList" class="grid grid-cols-5 gap-4 w-full">
                <?php
                renderMovies($showingController, $page, $moviesPerPage);
                ?>
            </div>

            <!-- Right Arrow - Next -->
            <button id="next-page" class="text-white p-2 disabled:text-gray-500">
                <i class="ri-arrow-right-s-line text-4xl ml-8"></i>
            </button>
        </div>

        <!-- News/companyinfo/prices -->
        <!-- Tab Navigation -->
        <div class="flex space-x-4 justify-center mt-8 mb-8">
            <a data-tab="news" class="tab text-white cursor-pointer <?php echo $tab === 'news' ? 'underline text-yellow-400 font-semibold' : ''; ?>">News & Articles</a>
            <a data-tab="company" class="tab text-white cursor-pointer">Company Information</a>
            <a data-tab="tickets" class="tab text-white cursor-pointer">Ticket Prices</a>
        </div>

        <div id="tab-content" class="grid grid-cols-1 gap-4">
            <?php
            // Render news (rest is rendered above at the top of the file)
            if ($tab === 'news') {
                $allNews = $newsController->getAllNews();

                if (isset($allNews['errorMessage'])) {
                    echo $allNews['errorMessage'];
                } else {
                    // Loop through each news item and render it using NewsCard
                    echo '<div class="grid grid-cols-3 gap-4 flex flex-row items-center">';
                    foreach ($allNews as $news) {
                        NewsCard::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
    </main>
</body>
<?php include_once("src/view/components/Footer.php"); ?>
</html>