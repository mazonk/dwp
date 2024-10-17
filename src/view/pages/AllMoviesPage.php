<?php
include_once "src/controller/MovieController.php";
include_once "src/view/components/MovieCard.php";
require_once 'session_config.php';
include_once "src/controller/ShowingController.php";
include_once "src/view/components/ShowingCard.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>All Movies</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
  </head>
  <body class="max-w-[1440px] w-[100%] mx-auto px-[100px] bg-bgDark text-textLight">
    <!-- Navbar -->
    <?php include_once("src/view/components/Navbar.php"); ?>
    <main class="mt-[56px] p-4">
      <h1 class="text-[1.875rem] mb-4">All Movies</h1>
      <div class="grid grid-cols-5 gap-16">
        <?php
        // Create a new instance of MovieController and fetch all movies
        $movieController = new MovieController();
        $allMovies = $movieController->getAllMovies();
        if (empty($allMovies)) {
          echo "No movies found for this venue.";
        } else {
        // Loop through each movie and render its movie card
        foreach ($allMovies as $movie) {
          MovieCard::render($movie);

      }
    }
        ?>
      </div>
      <div>
        <?php
        $showingController = new ShowingController();
        $showings = $showingController->getAllShowingsForVenue(1);
        if (empty($showings)) {
            echo "No showings found for this venue.";
        } else {
            echo "Showings fetched from database: <br>";
            foreach ($showings as $showing) {
                echo "Showing ID: " . $showing->getShowingId() . "<br>";
                echo "Movie Title: " . $showing->getMovie()->getTitle() . "<br>";
                echo "Room Number: " . $showing->getRoom()->getRoomNumber() . "<br>";
                echo "Showing Date: " . $showing->getShowingDate()->format('Y-m-d') . "<br>";
                echo "Showing Time: " . $showing->getShowingTime()->format('H:i') . "<br>";
            }
        }
        ?>
      </div>
        </div>
    </main>
  </body>
</html>
