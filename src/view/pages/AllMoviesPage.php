<?php require_once 'session_config.php';
require_once "src/controller/MovieController.php";
include_once "src/view/components/MovieCard.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Movies</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <?php include_once("src/assets/tailwindConfig.php"); ?>
</head>

<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] bg-bgDark text-textLight">
  <!-- Navbar -->
  <?php include_once("src/view/components/Navbar.php"); ?>

  <main class="mt-[56px] p-4">
    <h1 class="text-[1.875rem] mb-4">All Movies</h1>
    <div class="grid grid-cols-5 gap-16">
      <?php
      // Create a new instance of MovieController and fetch all movies
      $movieController = new MovieController();
      $allMovies = $movieController->getAllActiveMovies();

      if (isset($allMovies['errorMessage'])) {
        echo $allMovies['errorMessage'];
      } else {
        foreach ($allMovies as $movie) {
          $releaseDate = $movie->getReleaseDate();
          $currentDate = new DateTime();

          // Check if the release date is in the future
          if ($releaseDate <= $currentDate) {
            MovieCard::render($movie, false);
          }
        }
      }
      ?>
    </div>
  </main>
  <!-- Footer -->
  <?php include_once("src/view/components/Footer.php"); ?>
</body>
</html>