<?php
require_once 'session_config.php';

include_once "src/controller/NewsController.php";
include_once "src/controller/ShowingController.php";
include_once 'src/controller/VenueController.php';

include_once "src/view/components/NewsCard.php";
include_once "src/view/components/MovieCard.php";

$venueController = new VenueController();
$selectedVenue = $_SESSION['selectedVenueName'] ?? $venueController->getVenueById(1)->getName();
$_SESSION['selectedVenueName'] = $selectedVenue;

$newsController = new NewsController();
$showingController = new ShowingController();

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'news'; // Default to 'news' if no tab is set in query string
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Set default page number

$moviesPerPage = 5;

// Get the total number of movies playing today
$moviesPlayingToday = $showingController->getMoviesPlayingToday(1); //TODO: change to get venueid from session
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
</head>
<body class="max-w-[1440px] w-[100%] mx-auto px-[100px] bg-bgDark text-textLight overflow-hidden">
    <!-- Navbar -->
    <?php include_once("src/view/components/Navbar.php"); ?>

    <main class="mt-16 p-4">
        <div class="flex items-center justify-between">
            <!-- Left Arrow - Previous -->
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="text-white p-2">
                    <i class="ri-arrow-left-s-line text-4xl"></i>
                </a>
            <?php else: ?>
                <!-- Empty space when no previous page -->
                <div class="w-[48px]"></div>
            <?php endif; ?>

            <!-- Daily showings -->
            <div class="grid grid-cols-5 gap-4 w-full">
                <?php
                    echo '<div class="flex flex-col gap-2">';
                        foreach ($moviesToDisplay as $movie) {
                            MovieCard::render($movie, false);
                        }
                        echo "<button class='w-full text-center text-lg border font-semibold'>Book a ticket</button>";
                    echo "</div>";
                ?>
            </div>

            <!-- Right Arrow - Next -->
            <?php if ($startIndex + $moviesPerPage < $totalMovies): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="text-white p-2">
                    <i class="ri-arrow-right-s-line text-4xl ml-8"></i>
                </a>
            <?php else: ?>
                <!-- Empty space when no next page -->
                <div class="w-[48px]"></div>
            <?php endif; ?>
        </div>

        <!-- News -->
        <!-- Tab Navigation -->
        <div class="flex space-x-4 justify-center mt-8 mb-8">
            <a href="?tab=news" class="text-white <?php echo $tab === 'news' ? 'underline font-semibold' : 'b'; ?>">News & Articles</a>
            <a href="?tab=company" class="text-white <?php echo $tab === 'company' ? 'underline font-semibold' : ''; ?>">Company Information</a>
            <a href="?tab=tickets" class="text-white <?php echo $tab === 'tickets' ? 'underline font-semibold' : ''; ?>">Ticket Prices</a>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <?php
            // Render content based on the selected tab
            if ($tab === 'news') {
                $allNews = $newsController->getNews();

                // Loop through each news item and render it using NewsCard
                echo '<div class="grid grid-cols-3 gap-4 flex flex-row items-center">';
                foreach ($allNews as $news) {
                    NewsCard::render($news->getNewsId(), $news->getHeader(), $news->getImageURL(), $news->getContent());
                }
                echo '</div>';
            } elseif ($tab === 'company') {
                echo '<h2 class="text-2xl font-bold text-white">Company Information</h2>';
                echo '<p class="text-lg text-gray-300 mt-4">space reserved for company info.</p>';
            } elseif ($tab === 'tickets') {
                echo '<h2 class="text-2xl font-bold text-white">Ticket Prices</h2>';
                echo '<p class="text-lg text-gray-300 mt-4">space reserved for ticket prices.</p>';
            }
            ?>
        </div>
    </main>
</body>
</html>
