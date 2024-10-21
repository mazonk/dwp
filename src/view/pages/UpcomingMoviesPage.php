<?php
include_once "src/controller/MovieController.php";
include_once "src/view/components/MovieCard.php";
require_once 'session_config.php';

// Get the current date
$currentDate = new DateTime();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upcoming Movies</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto px-[100px] bg-[#0d0101] text-white p-8">
<?php include_once("src/view/components/Navbar.php"); ?>
<main class="mt-[56px] p-4">
  <h1 class="text-[1.875rem] font-bold mb-6">Upcoming Movies</h1>
  <div class="grid grid-cols-5 gap-16">
    <?php
    $movieController = new MovieController();
    $allMovies = $movieController->getAllMovies();

    // Loop through each movie and render its movie card if the release date is in the future
    foreach ($allMovies as $movie) {
        $releaseDate = $movie->getReleaseDate();
        
        // Check if the release date is in the future
        if ($releaseDate > $currentDate) {
            MovieCard::render($movie, true);
        }
    }
    ?>
  </div>
</main>
</body>
</html>
