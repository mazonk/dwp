<?php
require_once 'session_config.php';

if (isset($_GET['id']) && isset($_GET['showing_time']) && isset($_GET['showing_date'])) {
    $movieId = $_GET['id'];
    $showingDate = $_GET['showing_date'];
    $showingTime = $_GET['showing_time'];

    echo "<h1>Booking for Movie ID: $movieId</h1>";
    echo "<p>Showing Date: $showingDate</p>";
    echo "<p>Showing Time: $showingTime</p>";
} else {
    echo "<h1>Error: Missing booking information.</h1>";
}
?>
