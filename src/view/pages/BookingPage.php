<?php
require_once 'session_config.php';
require_once 'src/controller/SeatController.php';

$selectedVenueId = $_SESSION['selectedVenueId']; // Get the selected venue name and ID

// Unserialize the selected showing
$selectedShowing = isset($_SESSION['selectedShowing']) ? unserialize($_SESSION['selectedShowing']) : null;

if ($selectedShowing) {
    echo "<h1>Showing Id: " . htmlspecialchars($selectedShowing->getShowingId()) . "</h1>";

    $seatController = new SeatController();
    $showingId = $selectedShowing->getShowingId(); // Get the showing ID

    // Get available seats for the showing and venue
    $availableSeats = $seatController->getAvailableSeatsForShowing($showingId, $selectedVenueId); 
    // Fetch all seats
    $totalSeats = $seatController->getAllSeatsForShowing($showingId, $selectedVenueId); 

    $totalAvailableSeats = serialize($availableSeats); // Count of available seats

    // Display total number of seats available
    echo "<p>Total Seats: " . count($totalSeats) . "</p>"; // Total seats
    echo "<p>Total Seats Available: " . $totalAvailableSeats . "</p>";
    
    if ($totalAvailableSeats === 0) {
        echo "<p class='text-red-500'>No seats are available for this showing. Please check back later or select a different showing time.</p>";
    } 
} else {
    echo "<p class='text-red-500'>No showing selected. Please go back and select a showing.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
    <style>
        body {
            background-color: #342217; /* Your dark blue background */
            color: #192233; /* Your text color */
        }
    </style>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] text-textLight">
    <?php include_once("src/view/components/Navbar.php"); ?>
    <main class="mt-[56px] p-4">
        <!-- Additional content can be added here -->
    </main>
    <?php include_once("src/view/components/Footer.php"); ?>
</body>
</html>
