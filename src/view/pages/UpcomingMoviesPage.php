<?php
include_once "src/controller/MovieController.php";
include_once "src/view/components/MovieCard.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Movies</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0d0101] text-white p-8">

  <h1 class="text-[1.875rem] font-bold mb-6">Upcoming Movies</h1>

  <div class="grid grid-cols-1 gap-6">
    <?php
    // Create a new instance of MovieController and fetch all movies
    $movieController = new MovieController();
    $allMovies = $movieController->getAllMovies();

    // Loop through each movie and render its movie card
    foreach ($allMovies as $movie) {
        MovieCard::render($movie->getTitle(), $movie->getPosterURL(), $movie->getReleaseDate()->format('Y-m-d'));
    }
    ?>
  </div>

</body>
</html>
