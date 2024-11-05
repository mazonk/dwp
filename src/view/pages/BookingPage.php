<?php
require_once 'session_config.php';
require_once 'src/controller/SeatController.php';
include_once "src/controller/TicketController.php";
include_once "src/model/repositories/TicketRepository.php";

$selectedVenueId = $_SESSION['selectedVenueId']; // Get the selected venue name and ID

// Unserialize the selected showing
$selectedShowing = isset($_SESSION['selectedShowing']) ? unserialize($_SESSION['selectedShowing']) : null;

if ($selectedShowing) {
    $seatController = new SeatController();
    $ticketController = new TicketController(); 
    $showingId = $selectedShowing->getShowingId(); // Get the showing ID
    $unavailableTickets = $ticketController->getAllTicketsForShowing($selectedShowing->getShowingId(), $selectedVenueId);

    // Get available seats for the showing and venue
    $availableSeats = $seatController->getAvailableSeatsForShowing($showingId, $selectedVenueId); 
    // Fetch all seats
    $totalSeats = $seatController->getAllSeatsForShowing($showingId, $selectedVenueId); 

    $totalAvailableSeats = serialize($availableSeats); // Count of available seats

    // Display total number of seats available
    echo "<p>Total Seats: " . serialize($totalSeats) . "</p>"; // Total seats
    echo "<p>Total Seats Available: " . $totalAvailableSeats . "</p>";
    $actualAvailableSeats = serialize($totalSeats) - $totalUnavailableSeats;
    echo "<p>AVAILABLE SEATS: " . $actualAvailableSeats . "</p>";     // Calculate unavailable seats
     $totalUnavailableSeats =serialize($unavailableTickets);
    echo "<p>Unavailable Seats: " . $totalUnavailableSeats . "</p>";


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
            background-color: #342217;
            color: #192233;
        }
    </style>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] text-textLight">
    <?php include_once("src/view/components/Navbar.php"); ?>
    <main class="mt-[56px] p-4">
    </main>
    <?php include_once("src/view/components/Footer.php"); ?>
</body>
</html>
