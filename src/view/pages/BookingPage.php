<?php
require_once 'session_config.php';
require_once 'src/model/entity/Seat.php';
include_once "src/model/entity/Showing.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Room.php";
include_once "src/controller/SeatController.php";

$selectedShowing = unserialize($_SESSION['selectedShowing']);
$selectedVenueId = $_SESSION['selectedVenueId'] ?? 1; // Get the selected venue name and ID

echo "<h2>Select seating for: " . htmlspecialchars($selectedShowing->getShowingDate()->format('d-m-Y')) . "</h2>"; // Display the selected showing date

$seatController = new SeatController();
$showingId = $selectedShowing->getShowingId(); // Get the showing ID
$allSeats = $seatController->getAllSeatsForShowing($showingId, $selectedVenueId); // Get seats for the showing and venue

// Check if any seats are returned
if (empty($allSeats)) {
    echo "<p class='text-red-500'>No seats are available for this showing. Please check back later or select a different showing time.</p>";
} else {
    // Group seats by row
    $seatsByRow = [];
    foreach ($allSeats as $seat) {
        $seatsByRow[$seat['row']][] = $seat;
    }

    // Display each row of seats
    foreach ($seatsByRow as $rowSeats) {
        echo "<div class='seat-row'>";
        foreach ($rowSeats as $seat) {
            $isOccupied = $seat['isOccupied'] ?? false;
            $seatClass = $isOccupied ? 'seat occupied' : 'seat available';
            echo "<div class='$seatClass'></div>";
        }
        echo "</div>";
    }
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
    .seat-row {
      display: flex;
      justify-content: center;
      margin-bottom: 8px;
    }
    .seat {
      width: 30px;
      height: 30px;
      margin: 4px;
      border-radius: 4px;
    }
    .available {
      background-color: #4CAF50; /* Green for available seats */
      cursor: pointer;
    }
    .occupied {
      background-color: #e53935; /* Red for occupied seats */
      cursor: not-allowed;
    }
  </style>
</head>

<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] bg-bgDark text-textLight">
  <?php include_once("src/view/components/Navbar.php"); ?>
  <main class="mt-[56px] p-4">
    <!-- Seat grid will be displayed here from PHP output -->
  </main>
</body>
</html>
