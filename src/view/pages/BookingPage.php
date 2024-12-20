<?php  require_once 'session_config.php';
include_once "src/view/components/SeatCard.php";
require_once 'src/controller/SeatController.php';
require_once 'src/controller/ShowingController.php';
require_once "src/model/services/TicketService.php";
require_once "src/model/services/SeatService.php";
require_once "src/controller/BookingController.php";

// If there is an active booking
if (isset($_SESSION['activeBooking']) && $_SESSION['activeBooking']['expiry'] > time()) {
    echo "
    <div class='fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-70 '>
        <div class='flex items-center justify-center min-h-screen'>
            <div class='bg-bgSemiDark w-[500px] rounded-lg p-6 border-[1px] border-borderDark'>
                <h2 class='text-[1.5rem] text-center font-semibold mb-4'>You have an active booking!</h2>
                <p class='text-textLight text-center'>Do you want to proceed with your current booking or cancel it?</p>
                <div class='flex justify-center mt-6'>
                    <button id='proceedCheckout' class='text-primary py-2 px-4 border-[1px] border-primary rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out'>Proceed</button>
                    <button id='cancelBooking' class='text-red-500 py-2 px-4 border-[1px] border-red-500 rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out'>Cancel Booking</button>
                </div>
            </div>
        </div>
    </div>
    ";
}
// If the active booking has expired
else if (isset($_SESSION['activeBooking']) && $_SESSION['activeBooking']['expiry'] <= time()) {
    // The proceed button is hidden by as it has to be included otherwise the close button will not work
    echo "
    <div class='fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-70 '>
        <div class='flex items-center justify-center min-h-screen'>
            <div class='bg-bgSemiDark w-[500px] rounded-lg p-6 border-[1px] border-borderDark'>
                <h2 class='text-[1.5rem] text-center font-semibold mb-4'>You have been expired!</h2>
                <div class='flex justify-center mt-6'>
                    <button id='proceedCheckout' class='text-primary py-2 px-4 border-[1px] border-primary rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out hidden'>Proceed</button>
                    <button id='cancelBooking' class='text-red-500 py-2 px-4 border-[1px] border-red-500 rounded hover:bg-borderDark ml-2 duration-[.2s] ease-in-out'>Cancel Booking</button>
                </div>
            </div>
        </div>
    </div>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            echo '<div id="seat-selection" class="flex flex-col items-center justify-center">';
            echo '<div class="screen bg-gray-700 text-white text-center py-2 w-full max-w-[70%] rounded mb-12">Screen</div>';
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

        <div class="flex flex-row items-center align-baseline justify-between">
            <!-- Color Explanation -->
            <div class="color-legend mt-6">
                <h3 class="text-lg font-semibold mb-2">Color Legend:</h3>
                <div class="flex space-x-4">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-600 mr-2 rounded"></div>
                        <span>Available</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-lime-600 mr-2 rounded"></div>
                        <span>Selected</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 mr-2 rounded"></div>
                        <span>Unavailable</span>
                    </div>
                </div>
            </div>
            <!-- Proceed Button -->
            <div class="mt-12">
                <button class="py-2.5 px-12 text-primary border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[.2s] ease-in-out cursor-pointer"
                onclick="proceedToOverview(
                    '<?= htmlspecialchars($_GET['showing'])?>'
                )">
                    Proceed to overview
                </button>
            </div>
        </div>

        <!-- Selected seats display -->
        <div id="booked-seats-display" class="mt-4 text-xl hidden">
            <span>Selected Seats: </span>
            <span id="selected-seats-list" class="font-semibold"></span>
        </div>
    </main>

    <script>
        function proceedToOverview(showingId) {
            const selectedSeatsList = document.getElementById('selected-seats-list');
            const selectedSeats = selectedSeatsList.dataset.selectedSeats;

            if (!selectedSeats) {
                alert('Please select at least one seat before proceeding to the overview.');
                return;
            }

            // Optionally send the selected seats to the server or store them for later use
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo $_SESSION['baseRoute']; ?>booking/overview', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Redirect to the overview page
                            window.location.href = '<?php echo $_SESSION['baseRoute']; ?>booking/checkout';
                        } else {
                            alert('Failed to proceed: ' + response.errorMessage);
                        }
                    } catch (error) {
                        alert('An error occurred: ' + error.message);
                    }
                }
            };

            xhr.send(`selectedSeats=${encodeURIComponent(selectedSeats)}&showingId=${showingId}`);
        }
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
                            // Temporarily remove the seat to check validation
                            const tempSeats = selectedSeats.filter(id => id !== seatId);
                            const errorMessage = validateDeselect(tempSeats);

                            if (errorMessage === '') {
                                // If validation passes, deselect the seat
                                selectedSeats = tempSeats;

                                this.classList.remove('bg-lime-600');
                                this.classList.add('bg-blue-600');

                            } else {
                                // Show error message if deselecting causes invalid gaps
                                showError(errorMessage, this);
                                return;
                            }
                        } else {
                            // Temporarily add the seat to validate selection
                            const tempSeats = [...selectedSeats, seatId];
                            if (tempSeats.length > 6) {
                                alert('You can only book up to 6 seats at a time. For booking more than 6 seats, please contact us!');
                                return;
                            }
                            const errorMessage = validateSelect(tempSeats);
                            
                            if (errorMessage === '') {
                                // If validation passes, select the seat
                                selectedSeats.push(seatId);

                                this.classList.remove('bg-blue-600');
                                this.classList.add('bg-lime-600');

                            } else {
                                // Show error message if adding the seat causes invalid gaps
                                showError(errorMessage, this);
                                return;
                            }
                        }

                        const seatsWithRowAndSeatNr = selectedSeats.map(seatId => {
                            const seat = document.querySelector(`[data-seat-id="${seatId}"]`);
                            const row = seat.getAttribute('data-row');
                            const seatNr = seat.getAttribute('data-seat-nr');
                            return `Row: ${row} | Seat: ${seatNr}`;
                        }).join(', ');
                        selectedSeatsList.textContent = seatsWithRowAndSeatNr;
                        selectedSeatsList.dataset.selectedSeats = selectedSeats;
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

            function validateSelect(selectedSeats) {
                const bookedSeats = [...document.querySelectorAll('[data-is-available="false"]')]
                    .map(seat => parseInt(seat.getAttribute('data-seat-id'), 10));

                if (selectedSeats.length === 2) {
                    // Check if the two selected seats are adjacent, ignoring booked seats
                    const [seat1, seat2] = selectedSeats.map(Number).sort((a, b) => a - b);
                    if (Math.abs(seat1 - seat2) !== 1) {
                        return "Selected seats must be next to each other.";
                    }
                } else if (selectedSeats.length > 2) {
                    // Validate for gaps between selected seats
                    const sortedSeats = selectedSeats.map(Number).sort((a, b) => a - b);

                    for (let i = 0; i < sortedSeats.length - 1; i++) {
                        const gap = sortedSeats[i + 1] - sortedSeats[i];

                        if (gap > 1) {
                            // Intermediate seats
                            const intermediateSeats = Array.from({ length: gap - 1 }, (_, index) => sortedSeats[i] + index + 1);

                            // Check for available seats in the gap
                            const availableGap = intermediateSeats.filter(
                                seat => !bookedSeats.includes(seat) && !selectedSeats.includes(seat)
                            );

                            // The gap of available seats is at least 2
                            if (availableGap.length < 2) {
                                return "Any gap of available seats must be at least 2 seats wide.";
                            }
                        }
                    }
                }

                // No single-seat gaps next to booked seats
                const allSeats = [...selectedSeats, ...bookedSeats].sort((a, b) => a - b);

                for (let i = 0; i < allSeats.length - 1; i++) {
                    const gap = allSeats[i + 1] - allSeats[i];

                    if (gap === 2 && selectedSeats.includes(allSeats[i + 1] - 1)) {
                        return "Single-seat gaps next to booked seats are not allowed.";
                    }
                }

                return ''; // No errors
            }

            function validateDeselect(selectedSeats) {
                if (selectedSeats.length > 1) {
                    const sortedSeats = selectedSeats.map(Number).sort((a, b) => a - b);
                    for (let i = 0; i < sortedSeats.length - 1; i++) {
                        const gap = (sortedSeats[i + 1] - sortedSeats[i]) -1;
                        if (gap === 1) {
                            return "Deselecting this seat will leave adjacent seats with a gap.";
                        }
                    }
                }
                return '';
            }
        });

        /* Active booking handling */
        const proceedCheckoutButton = document.getElementById('proceedCheckout');
        const cancelBookingButton = document.getElementById('cancelBooking');

        proceedCheckoutButton.addEventListener('click', function() {
            window.location.href = '<?php echo $_SESSION['baseRoute']; ?>booking/checkout';
        });

        cancelBookingButton.addEventListener('click', function() {
            rollbackBooking(false);
        });

        function rollbackBooking(redirectBack) {
            localStorage.removeItem('bookingExpiry');

            const xhr = new XMLHttpRequest();
            const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
            xhr.open('POST', `${baseRoute}booking/rollback`, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (redirectBack) {
                        history.back();
                    }
                    location.reload();
                }
            };
            xhr.send();
        }
    </script>
    <?php include_once("src/view/components/Footer.php"); ?>
</body>
</html>