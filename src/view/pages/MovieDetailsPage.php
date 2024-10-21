<!-- In the URL -> http://localhost/dwp/movies/1 - this is how you send query string with req. URL -->
<?php 
require_once 'session_config.php';
include_once "src/controller/MovieController.php";
include_once "src/view/components/MovieCard.php";
include_once "src/controller/ShowingController.php";
include_once "src/view/components/ShowingCard.php";

$id = $_GET['id'];
echo 'The id you entered is: '. $id;
$showingController = new ShowingController();
$movieController = new MovieController();
$movie = $movieController->getMovieById($id);

if (!$movie) {
  echo "No movie found with the given ID.";
  exit;
} else {
  $showings = $showingController->getAllShowingsForVenue(2);
  if (empty($showings)) {
    echo "No showings found for this venue.";
  } else {
  $showingsForMovie = $showingController->getAllShowingsForMovie($movie->getMovieId(), $showings);
  echo '<div class="grid grid-cols-3 gap-4 flex flex-row items-center">';
  foreach ($showingsForMovie as $showing) {
    ShowingCard::render($showing);
  }
  echo '</div>';
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #0d0101;
      color: white;
      margin: 0;
      padding: 2vw;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .movie-header {
      display: flex;
      align-items: flex-start;
      gap: 20px;
    }

    .movie-poster {
      width: 300px;
      height: 450px;
      background-color: #ddd;
      background-size: cover;
      background-position: center;
      border-radius: 1vw;
    }

    .movie-details {
      flex: 1;
    }

    .movie-title {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .movie-description {
      font-size: 1.2rem;
      margin-bottom: 20px;
    }

    .movie-info {
      margin-bottom: 10px;
    }

    .movie-info span {
      font-weight: bold;
    }

    .movie-actions {
      margin-top: 30px;
    }

    .movie-actions a {
      text-decoration: none;
      background-color: #fabb2c;
      color: black;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 5vw;
      margin-right: 10px;
    }

    .movie-actions a:hover {
      background-color: #123A6B;
    }

    .trailer-video {
      margin-top: 40px;
    }

    .trailer-video iframe {
      width: 100%;
      height: 500px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="movie-header">
      <div class="movie-poster" style="background-image: url('placeholder-poster.jpg');">
        <!-- Placeholder for movie poster -->
      </div>
      <div class="movie-details">
        <div class="movie-title">Movie Title Placeholder</div>
        <div class="movie-description">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
          Proin blandit justo at mauris efficitur, vitae dictum nibh placerat.
        </div>
        <div class="movie-info"><span>Duration:</span> 120 minutes</div>
        <div class="movie-info"><span>Language:</span> English</div>
        <div class="movie-info"><span>Release Date:</span> 2024-10-01</div>
        <div class="movie-info"><span>Rating:</span> 8.5/10</div>

        <div class="movie-actions">
          <a href="#">Watch Promo</a>
          <a href="#">Buy Tickets</a>
        </div>
      </div>
    </div>

    <div class="trailer-video">
      <iframe src="https://www.youtube.com/embed/trailer-url-placeholder" allowfullscreen></iframe>
    </div>
  </div>

</body>
</html>
