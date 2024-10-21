<?php
// BookingPage.php

// Check if the required parameters are set
if (isset($_GET['id']) && isset($_GET['showing_time'])) {
    $movieId = $_GET['id'];
    $showingTime = $_GET['showing_time'];

    // Use these parameters to fetch movie details or show confirmation, etc.
    // Example: Fetch the movie details using the movie ID
    // $movieDetails = getMovieDetails($movieId); // Assume you have this function

    // Display the information
    echo "<h1>Booking for Movie ID: $movieId</h1>";
    echo "<p>Showing Time: $showingTime</p>";
} else {
    echo "<h1>Error: Missing booking information.</h1>";
}
?>
