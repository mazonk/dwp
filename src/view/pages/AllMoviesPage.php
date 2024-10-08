<?php
include_once "src/controller/MovieController.php";
include_once "src/view/components/MovieCard.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Movies</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #0d0101;
      color: white;
      padding: 2vw;
      margin: 0;
    }
    
    .movies-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
      padding: 20px;
    }
  </style>
</head>
<body>

  <h1>All Movies</h1>

  <div class="movies-container">
    <?php
    // Create a new instance of MovieController and fetch all movies
    $movieController = new MovieController();
    $allMovies = $movieController->getAllMovies();

    // Loop through each movie and render its movie card
    foreach ($allMovies as $movie) {
        MovieCard::render($movie->getTitle(), $movie->getPosterURL());
    }
    ?>
  </div>

</body>
</html>
