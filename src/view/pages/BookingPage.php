<?php
require_once 'session_config.php';

$movieId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'No movie selected';
$showingTime = isset($_GET['showing_time']) ? htmlspecialchars($_GET['showing_time']) : 'No time selected';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showing Time</title>
</head>
<body>
    <h1>Selected Movie and Showing Time</h1>
    <p>Movie ID: <?php echo $movieId; ?></p>
    <p>Showing Time: <?php echo $showingTime; ?></p>
</body>
</html>

