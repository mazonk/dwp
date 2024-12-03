<?php
require_once 'session_config.php';
include_once "src/view/components/SeatCard.php";
require_once 'src/controller/SeatController.php';
require_once 'src/controller/ShowingController.php';
require_once "src/model/services/TicketService.php";
require_once "src/model/services/SeatService.php";
require_once "src/controller/BookingController.php";
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
        <div id="timer" class="text-red-500 text-lg font-bold"></div>
        <?php
        // //remove booking if the timer expired
        // if (isset($_SESSION['activeBooking']) && ($_SESSION['activeBooking']['expiry'] / 1000 - 1) < time()) {
        //     $bookingController = new BookingController();
        //     $wasRolledBack = $bookingController->rollBackBooking($_SESSION['activeBooking']['id']);
        //     if (!$wasRolledBack) {
        //         die();
        //     }
        // }

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

        <!-- Selected seats display -->
        <div id="booked-seats-display" class="mt-4 text-xl">
            <span>Selected Seats: </span>
            <span id="selected-seats-list" class="font-semibold"></span>
        </div>
        <div class="mt-12">
            <button class="py-2.5 px-2 text-primary border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[.2s] ease-in-out cursor-pointer"
            onclick="proceedToOverview(
                '<?= htmlspecialchars($_GET['showing'])?>'
            )">
                Proceed to overview
            </button>
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
                        console.log(xhr.responseText);
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

            xhr.send(`selectedSeats=${encodeURIComponent(selectedSeats)}`);
        }
        document.addEventListener('DOMContentLoaded', () => {
            // const timerDisplay = document.getElementById('timer');
            // let bookingExpiry = localStorage.getItem('bookingExpiry');

            // if (!bookingExpiry) {
            //     bookingExpiry = Date.now() + 15 * 60 * 1000; // 15 minutes from now
            //     localStorage.setItem('bookingExpiry', bookingExpiry);
            // }

            // const interval = setInterval(() => {
            //     const timeLeft = Math.max(0, bookingExpiry - Date.now());
            //     const minutes = Math.floor(timeLeft / 60000);
            //     const seconds = Math.floor((timeLeft % 60000) / 1000);
            //     timerDisplay.textContent = `Time left: ${minutes}:${seconds.toString().padStart(2, '0')}`;

            //     if (timeLeft <= 0) {
            //         clearInterval(interval);
            //         alert('Your booking has expired!');
            //         localStorage.removeItem('bookingExpiry');
            //         window.location.reload(true); // Or redirect to a different page
            //     }
            // }, 1000);

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
                                this.classList.remove('bg-red-500');
                                this.classList.add('bg-lime-600');
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

                            // if (tempSeats.length === 1) {
                            //     const xhr = new XMLHttpRequest();
                            //     const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
                            //     xhr.open('POST', `${baseRoute}booking/create`, true);
                            //     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            //     xhr.onreadystatechange = function() {
                            //         if (xhr.readyState === 4 && xhr.status === 200) {
                            //             try {
                            //                 const response = JSON.parse(xhr.responseText);
                            //                 console.log(response);
                            //                 if (response.success) {
                            //                     xhr.open('POST', `${baseRoute}ticket/create`, true);
                            //                     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            //                     xhr.onreadystatechange = function() {
                            //                         if (xhr.readyState === 4 && xhr.status === 200) {
                            //                             try {
                            //                                 console.log(xhr.responseText);
                            //                                 const response = JSON.parse(xhr.responseText);
                            //                                 if (response.success) {
                            //                                     alert('Success! Ticket created successfully.');
                            //                                 } else {
                            //                                     alert('Failed to create ticket: ' + response.errorMessage);
                            //                                 }
                            //                             } catch (error) {
                            //                                 alert('ticket An error occurred: ' + error.message);
                            //                             }
                            //                         }
                            //                     };
                            //                     xhr.send(`action=createTicket&bookingId=${response.bookingId}&seatId=${seatId}&ticketTypeId=1&showingId=<?php echo $_GET['showing'] ?>`);
                            //                 } else {
                            //                     alert('Failed to create booking: ' + response.errorMessage);
                            //                 }
                            //             } catch (error) {
                            //                 alert('An error occurred: ' + error.message);
                            //             }
                            //         }
                            //     };
                            //     xhr.send(`action=createEmptyBooking&status=pending&expiry=${localStorage.getItem('bookingExpiry')}`);
                            // }
                            if (errorMessage === '') {
                                // If validation passes, select the seat
                                selectedSeats.push(seatId);
                                this.classList.remove('bg-lime-600');
                                this.classList.add('bg-red-500');
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
    </script>

    <?php include_once("src/view/components/Footer.php"); ?>
</body>

</html>