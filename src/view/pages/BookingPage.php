<?php
require_once 'session_config.php';
require_once 'src/model/entity/Seat.php';
include_once "src/model/entity/Showing.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Room.php";
include_once "src/controller/SeatController.php";

echo "<h2>Select seating</h2>";
$selectedShowing = unserialize($_SESSION['selectedShowing']);
echo $selectedShowing->getShowingDate()->format('d-m-Y');

$selectedVenue = $_SESSION['selectedVenueName'] ?? $venueController->getVenueById(1)->getName();
// Display the selected showing date
echo "<h2>Select seating for: " . htmlspecialchars($selectedShowing->getShowingDate()->format('d-m-Y')) . "</h2>";

$seatController = new SeatController();
$showingId = $selectedShowing->getShowingId(); // Get the showing ID
$allSeats = $seatController->getAllSeatsForShowing($showingId, $selectedVenueId); // Get seats for the showing and venue

// Check if any seats are returned
if (empty($allSeats)) {
    echo "<p class='text-red-500'>No seats are available for this showing. Please check back later or select a different showing.</p>";
} else {
    // Display available seats
    foreach ($allSeats as $seat) {
        echo "<div>Seat: Row " . $seat->getRow() . " Number " . $seat->getSeatNr() . "</div>";
    }
}
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
    <h1 class="text-[1.875rem] mb-4">B00KING</h1>
    <!-- The seat selection message will be displayed here -->
  </main>
</body>

</html>
