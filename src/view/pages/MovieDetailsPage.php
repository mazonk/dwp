<!-- In the URL -> http://localhost/dwp/movies/1 - this is how you send query string with req. URL -->
<?php 
require_once 'session_config.php';
include_once "src/controller/MovieController.php";
include_once "src/view/components/MovieCard.php";
include_once "src/controller/ShowingController.php";
include_once "src/view/components/ShowingCard.php";
include_once "src/model/entity/Showing.php";

$id = $_GET['id'];
//echo 'The id you entered is: '. $id;
$showingController = new ShowingController();
$movieController = new MovieController();
$movie = $movieController->getMovieById($id);

if (!$movie) {
  echo "No movie found with the given ID.";
  exit;
} else {
  $showingsForMovie = $showingController->getAllShowingsForMovie($movie->getMovieId());
  if (empty($showingsForMovie)) {
    echo "No showings found for this movie.";
    exit;
  } else {
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
      display: flex;
      justify-content: flex-start;
      align-items: flex-start;
      gap: 20px;
      }

      .showings {
      display: flex;
      flex-direction: column;
      gap: 10px;}

    .movie-header {
      display: flex;
      align-items: flex-start;
      gap: 20px;
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
  <?php MovieCard::render($movie); ?> 
      </div>
      <div class="movie-details">
    <div class="movie-title">
      <?php echo htmlspecialchars($movie->getTitle()); ?>
    </div>
    <div class="movie-description"> 
     <?php echo $movie->getDescription(); ?>
    </div>
    <div class="movie-info"><span>Duration: </span> <?php echo $movie->getDuration(); ?></div>
    <div class="movie-info"><span>Language: </span> <?php echo $movie->getLanguage(); ?></div>
    <div class="movie-info"><span>Release Date: </span><?php echo $movie->getReleaseDate()->format('Y-m-d');?></div>
    <div class="movie-info"><span>Rating: </span> <?php echo $movie->getRating(); ?></div>
  </div>
    </div>

    <div class="trailer-video">
      <iframe src= "https://www.youtube.com/embed/<?php echo $movie->getTrailerURL(); ?>" frameborder="0" allowfullscreen></iframe> <!--this doesnt work yet-->
    </div>
  </div>

</body>
</html>