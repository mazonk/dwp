<?php
require_once 'session_config.php';
include_once "src/view/components/SeatCard.php";
require_once 'src/controller/SeatController.php';
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
    <main class="mt-[56px] p-4">
        <?php
        $selectedVenueId = $_SESSION['selectedVenueId']; // Get the selected venue ID

        $selectedShowing = isset($_SESSION['selectedShowing']) ? unserialize($_SESSION['selectedShowing']) : null;

        if ($selectedShowing) {
            echo 'salalalaal';
            $seatController = new SeatController();
            $showingId = $selectedShowing->getShowingId();
            $userId = $_SESSION['userId'] ?? null;

            $totalSeats = $seatController->getAllSeatsForShowing($showingId, $selectedVenueId);
            echo serialize($totalSeats);

            $availableSeats = $seatController->getAvailableSeatsForShowing($showingId, $selectedVenueId);
            echo serialize($availableSeats);
            $seatsByRow = [];
            foreach ($totalSeats as $seat) {
                $row = $seat->getRow();
                if (!isset($seatsByRow[$row])) {
                    $seatsByRow[$row] = [];
                }
                $seatsByRow[$row][] = $seat;
            }
            echo '<div id="seat-selection">';
            foreach ($seatsByRow as $row => $seats) {
                echo "<div class='seat-row flex justify-center space-x-4 mb-4'>";
                foreach ($seats as $seat) {
                    $isAvailable = $seatController->getAvailableSeatsForShowing($seat->getSeatId(), $showingId);
                    echo SeatCard::render($seat, $isAvailable, $showingId, $userId);
                }
                echo "</div>";
            }
            echo '</div>';

            if (empty($seatsByRow)) {
                echo "<p class='text-red-500'>No seats are available for this showing. Please check back later or select a different showing time.</p>";
            }
        } else {
            echo "<p class='text-red-500'>No showing selected. Please go back and select a showing.</p>";
        }
        ?>

        <!-- Booked seats display -->
        <div id="booked-seats-display" class="mt-4 text-xl">
            <span>Booked Seats: </span>
            <span id="booked-seats-list" class="font-semibold"></span>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const seatButtons = document.querySelectorAll('.seat-card');
            const bookedSeatsList = document.getElementById('booked-seats-list');
            let bookedSeats = [];

            seatButtons.forEach(seat => {
                seat.addEventListener('click', function () {
                    const seatId = this.getAttribute('data-seat-id');
                    const isAvailable = this.getAttribute('data-is-available') === 'true';

                    if (isAvailable) {
                        if (bookedSeats.includes(seatId)) {
                            bookedSeats = bookedSeats.filter(id => id !== seatId);
                            this.classList.remove('bg-red-500');
                            this.classList.add('bg-lime-600');
                        } else {
                            bookedSeats.push(seatId);
                            this.classList.remove('bg-lime-600');
                            this.classList.add('bg-red-500');
                        }

                        bookedSeatsList.textContent = bookedSeats.join(', ');
                    }
                });
            });
        });
    </script>

    <?php include_once("src/view/components/Footer.php"); ?>
</body>
</html>
