<?php   require_once 'session_config.php';
require_once "src/controller/MovieController.php";
require_once "src/controller/ShowingController.php";
require_once "src/model/entity/Showing.php";
include_once "src/view/components/MovieCard.php";
include_once "src/view/components/ShowingCard.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$showingController = new ShowingController();
$movieController = new MovieController();
$movie = $movieController->getMovieById($id);


if (is_array($movie) && isset($movie['errorMessage'])) {
    // Display the error message
    echo $movie['errorMessage'] . ' ' . '<a class="underline text-blue-300" href="javascript:window.history.back()"><-Go back!</a>';
} else {
  $showingsForMovie = $showingController->getAllShowingsForMovie($movie->getMovieId());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <?php include_once("src/assets/tailwindConfig.php"); ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Details</title>
</head>
<body class="max-w-[90rem] w-[100%] mx-auto mt-[4.5rem] px-[6.25rem] font-sans bg-[#0d0101] text-white m-0 p-[2vw]">
  <?php include_once("src/view/components/Navbar.php"); ?>
  <div class="flex flex-row justify-start movie-header gap-[1.25rem]">
    <img class="w-[300px] h-auto rounded-[0.625rem] m-[0.625rem] bg-center bg-cover" src="../src/assets/<?php echo $movie->getPosterURL(); ?>" alt="Movie Poster">
    <div class="ml-[20px]">
      <div class="text-[2.5rem] font-bold mb-2.5">
        <?php echo htmlspecialchars($movie->getTitle()); ?>
      </div>
      <div class="text-[1.2rem] mb-5">
        <?php echo $movie->getDescription(); ?>
      </div>
      <div class="movie-info mb-2">
        <span class="font-bold">Duration: </span> <?php echo $movie->getDuration(); ?> minutes
      </div>
      <div class="movie-info mb-2">
        <span class="font-bold">Language: </span> <?php echo $movie->getLanguage(); ?>
      </div>
      <div class="movie-info mb-2">
        <span class="font-bold">Release Date: </span> <?php echo $movie->getReleaseDate()->format('d-m-Y'); ?>
      </div>
      <div class="movie-info mb-2">
        <span class="font-bold">Rating: </span> <?php echo $movie->getRating() . ' / 10';?> ⭐
      </div>
      <div>
                <span class="font-bold">Actors: </span><?php
                if (empty($movie-> getActors())) {
                    echo "No actors found for this movie.";
                }
                $actors = array_map(function($actor) {
                    return htmlspecialchars($actor->getFirstName()). ' ' .$actor->getLastName();
                }, $movie-> getActors());
                echo implode(', ', $actors); ?></span>
            </div>
            <div>
            <span class="font-bold">Directors: </span><?php 
                if (empty($movie-> getDirectors())) {
                    echo "No director(s) found for this movie.";
                }
                $directors = array_map(function($director) {
                    return htmlspecialchars($director->getFirstName()). ' ' .$director->getLastName();
                }, $movie-> getDirectors());
                echo implode(', ', $directors); ?></span>
            </div>
        </div>
    <div class="trailer-video mt-10">
        <iframe class="w-full h-[300px] m-[0.625rem] rounded-[1.5rem]" src="https://www.youtube.com/embed/<?php echo $movie->getTrailerURL(); ?>" frameborder="0" allowfullscreen></iframe>
    </div>
        </div>

    <div class="bg-yellow-900 text-white p-4 mt-6 rounded-md">
        <h2 class="text-2xl text-center font-bold mb-4">Showing Times</h2>
        <div class="flex gap-4">
            <?php
            $today = new DateTime();
            if (isset($showingsForMovie['errorMessage'])) {
                // Display the error message
                echo $showingsForMovie['errorMessage'];
            } else {
            for ($i = 0; $i < 7; $i++) {
                $currentDay = clone $today;
                $currentDay->modify("+$i day");
                $formatedDay = $currentDay->format('l d, M');
                echo '<div class="bg-bgLight text-white py-2 px-4 my-2 rounded-md w-full text-center">';
                echo "$formatedDay";
                echo '<div class="flex flex-col items-center">';
                  foreach ($showingsForMovie as $showing) {
                      $showingDate = $showing->getShowingDate();
                      $showingTime = $showing->getShowingTime();
                      
                      // Check if the showing is today
                      if ($showingDate->format('Y-m-d') === $today->format('Y-m-d') && $showingDate->format('l d, M') === $formatedDay) {
                          // For today's showings, compare the time (show only later showings than now)
                          if ($showingTime->format('H:i:s') > $today->format('H:i:s')) {
                              ShowingCard::render($showing);
                          }
                      } else {
                          // For other days, match the formatted day
                          if ($showingDate->format('l d, M') === $formatedDay) {
                              ShowingCard::render($showing);
                          }
                      }
                  }
                echo '</div>';
                echo "</div>";
            }
        }
            ?>
        </div>
    </div>
  </div>
  <?php include_once("src/view/components/Footer.php"); ?>
</body>