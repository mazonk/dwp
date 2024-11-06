<?php
require_once 'session_config.php';
include_once "src/view/components/SeatCard.php";
require_once 'src/controller/SeatController.php';
include_once "src/controller/TicketController.php";
include_once "src/model/repositories/TicketRepository.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
</head>
<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] bg-bgDark text-textLight">
    <?php include_once("src/view/components/Navbar.php"); ?>
    <main class="mt-[56px] p-4"></main>
    <?php

$selectedVenueId = $_SESSION['selectedVenueId']; // Get the selected venue name and ID

// Unserialize the selected showing
$selectedShowing = isset($_SESSION['selectedShowing']) ? unserialize($_SESSION['selectedShowing']) : null;

if ($selectedShowing) {
    $seatController = new SeatController();
    $ticketController = new TicketController(); 
    $showingId = $selectedShowing->getShowingId();
    $unavailableTickets = $ticketController->getAllTicketsForShowing($selectedShowing->getShowingId(), $selectedVenueId);
    $userId = $_SESSION['userId'] ?? null;

    // Fetch all seats
    $totalSeats = $seatController->getAllSeatsForShowing($showingId, $selectedVenueId); 
    $unavailableSeatIds = array_column($unavailableTickets, 'seatId');

    // Group seats by row
    $seatsByRow = [];
    foreach ($totalSeats as $seat) {
        $row = $seat->getRow();
        if (!isset($seatsByRow[$row])) {
            $seatsByRow[$row] = [];
        }
        $seatsByRow[$row][] = $seat;
    }

    // Start the seats layout
    foreach ($seatsByRow as $row => $seats) {
        echo "<div class='seat-row flex justify-center space-x-4 mb-4'>";
        
        foreach ($seats as $seat) {
            $isAvailable = !in_array($seat->getSeatId(), $unavailableSeatIds);
            echo SeatCard::render($seat, $isAvailable, $showingId, $userId);
        }

        echo "</div>"; // End the row
    }

    if (empty($seatsByRow)) {
        echo "<p class='text-red-500'>No seats are available for this showing. Please check back later or select a different showing time.</p>";
    }
} else {
    echo "<p class='text-red-500'>No showing selected. Please go back and select a showing.</p>";
}
?>
    </main>
    <?php include_once("src/view/components/Footer.php"); ?>
</body>
</html>
