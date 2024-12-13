<?php
include_once "src/controller/BookingController.php";

if(isset($_GET['selectedShowing']) && is_numeric($_GET['selectedShowing'])) {
    $showingId = intval($_GET['selectedShowing']);
    $bookingController = new BookingController();
    $bookings = $bookingController->getBookingsByShowingId($showingId);

    if (isset($bookings['errorMessage']) && $bookings['errorMessage']) {
        echo $bookings['errorMessage'];
    } else {
            echo "<div class='overflow-x-auto'>";
                echo "<table class='table-auto w-full border-collapse border border-borderLight shadow-md rounded-lg bg-bgSemiDark'>";
                echo "<thead class='bg-bgDark'>
                        <tr>
                            <th class='border border-gray-300 px-4 py-2'>Booking ID</th>
                            <th class='border border-gray-300 px-4 py-2'>User Name</th>
                            <th class='border border-gray-300 px-4 py-2'>Booking Status</th>
                            <th class='border border-gray-300 px-4 py-2'>Ticket ID</th>
                            <th class='border border-gray-300 px-4 py-2'>Seat row</th>
                            <th class='border border-gray-300 px-4 py-2'>Seat number</th>
                            <th class='border border-gray-300 px-4 py-2'>Ticket Type</th>
                            <th class='border border-gray-300 px-4 py-2'>Actions</th>
                        </tr>
                      </thead>";
                echo "<tbody>";

                foreach ($bookings as $booking) {
                    $bookingId = htmlspecialchars($booking->getBookingId());
                    $user = $booking->getUser();
                    $userName = $user ? htmlspecialchars($user->getFirstName() . " " . $user->getLastName()) : "Guest"; // Assume getFullName() exists in User class
                    $status = htmlspecialchars($booking->getStatus()->value);

                    // Check if the booking has tickets
                    $tickets = $booking->getTickets();
                    if (!empty($tickets)) {
                        foreach ($tickets as $ticket) {
                            $ticketId = htmlspecialchars($ticket->getTicketId());
                            $seat = htmlspecialchars($ticket->getSeat()->getSeatNr()); // Assume getSeatNumber() exists in Seat class
                            $ticketType = htmlspecialchars($ticket->getTicketType()->getName()); // Assume getName() exists in TicketType class

                            echo "<tr class='hover:bg-gray-800'>
                                    <td class='border border-gray-300 px-4 py-2 text-center'>{$bookingId}</td>
                                    <td class='border border-gray-300 px-4 py-2 text-center'>{$userName}</td>
                                    <td class='border border-gray-300 px-4 py-2 text-center'>{$status}</td>
                                    <td class='border border-gray-300 px-4 py-2 text-center'>{$ticketId}</td>
                                    <td class='border border-gray-300 px-4 py-2 text-center'>{$ticket->getSeat()->getRow()}</td>
                                    <td class='border border-gray-300 px-4 py-2 text-center'>{$seat}</td>
                                    <td class='border border-gray-300 px-4 py-2 text-center'>{$ticketType}</td>
                                    <td class='border border-gray-300 px-4 py-2 text-center'>
                                        <button class='bg-primary text-black py-2 px-4 border border-borderDark rounded hover:bg-bgSemiDark hover:text-white duration-[.2s] ease-in-out'>Create invoice</button>
                                  </tr>";
                        }
                    } else {
                        // If no tickets, display a single row with "No Tickets"
                        echo "<tr class='hover:bg-gray-100'>
                                <td class='border border-gray-300 px-4 py-2 text-center'>{$bookingId}</td>
                                <td class='border border-gray-300 px-4 py-2 text-center'>{$userName}</td>
                                <td class='border border-gray-300 px-4 py-2 text-center'>{$status}</td>
                                <td colspan='3' class='border border-gray-300 px-4 py-2 text-center text-gray-500'>No Tickets</td>
                              </tr>";
                    }
                }

                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center text-red-500'>Please select a valid showing.</p>";
        }
    
        ?>
    </div>