<?php
require_once 'session_config.php';
include_once "src/view/components/SeatCard.php";
require_once 'src/controller/SeatController.php';
require_once 'src/controller/ShowingController.php';
include_once "src/model/services/TicketService.php";
include_once "src/model/services/SeatService.php";
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

        $selectedShowingId = isset($_GET['showing']) ? $_GET['showing'] : null;
        $showingController = new ShowingController();
        $selectedShowing = $showingController->getShowingById($selectedShowingId, $selectedVenueId);

        if ($selectedShowing) {
            $seatController = new SeatController();
            $showingId = $selectedShowing->getShowingId();
            $userId = $_SESSION['userId'] ?? null;

            $totalSeats = $seatController->getAllSeatsForShowing($showingId, $selectedVenueId);
            $availableSeats = $seatController->getAvailableSeatsForShowing($showingId, $selectedVenueId);
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
                echo "<div class='row-number text-xl font-semibold'>{$row}</div>";
                foreach ($seats as $seat) {
                    $isAvailable = array_search($seat, $availableSeats);
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
            <span id="selected-seats-list" class="font-semibold"></span>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const seatButtons = document.querySelectorAll('.seat-card');
            const selectedSeatsList = document.getElementById('selected-seats-list');
            let selectedSeats = [];

            seatButtons.forEach(seat => {
                seat.addEventListener('click', function () {
                    const seatId = this.getAttribute('data-seat-id');
                    const isAvailable = this.getAttribute('data-is-available') === 'true';

                    if (isAvailable) {
                        if (selectedSeats.includes(seatId)) {
                            selectedSeats = selectedSeats.filter(id => id !== seatId);
                            this.classList.remove('bg-red-500');
                            this.classList.add('bg-lime-600');
                        } else {
                            // Temporarily add the seat to selectedSeats
                            const tempSeats = [...selectedSeats, seatId];
                            const errorMessage = validateSeats(tempSeats);
                            if (errorMessage === '') {
                                selectedSeats.push(seatId);
                                this.classList.remove('bg-lime-600');
                                this.classList.add('bg-red-500');
                            } else {
                                showError(errorMessage, this);
                                return;
                            }
                        }
                        selectedSeatsList.textContent = selectedSeats.join(', ');
                    } else {
                        showError('This seat is taken!', this);
                    }

                    function showError(errorMessage, _this) {
                        const popup = document.createElement('div');
                        popup.classList.add('absolute', 'px-2', 'py-1', 'bg-red-500', 'text-white', 'rounded', 'text-xs', 'z-10');
                        popup.textContent = errorMessage;
                        _this.appendChild(popup);
                        setTimeout(() => {
                            popup.remove();
                        }, 2000);
                    }
                });
            });

            function validateSeats(selectedSeats) {
                if (selectedSeats.length === 2) {
                    // Check if the two seats are adjacent
                    const [seat1, seat2] = selectedSeats.map(Number).sort((a, b) => a - b);
                    if (Math.abs(seat1 - seat2) !== 1) {
                        return "Selected seats must be next to each other.";
                    }
                } else if (selectedSeats.length > 2) {
                    // Check if gaps between seats are valid (at least 2 if there are gaps)
                    const sortedSeats = selectedSeats.map(Number).sort((a, b) => a - b);
                    for (let i = 0; i < sortedSeats.length - 1; i++) {
                        const gap = sortedSeats[i + 1] - sortedSeats[i];
                        if (gap > 1 && gap < 3) { // Allow adjacent seats but validate gaps
                            return "There must be a gap of at least 2 between the second and third seats.";
                        }
                    }
                }
                return '';
            }
        });
    </script>

    <?php include_once("src/view/components/Footer.php"); ?>
</body>

</html>