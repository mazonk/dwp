<?php
include_once "src/controller/BookingController.php";

if (isset($_GET['selectedShowing']) && is_numeric($_GET['selectedShowing'])) {
    $showingId = intval($_GET['selectedShowing']);
    $bookingController = new BookingController();
    $bookings = $bookingController->getBookingsByShowingId($showingId);

    if (isset($bookings['errorMessage']) && $bookings['errorMessage']) {
        echo $bookings['errorMessage'];
    } else {
        echo "<a href='javascript:window.history.back()' class='text-blue-500 underline mb-4 block'><-Back to Showings</a>";
        
        echo "<div class='overflow-x-auto'>";
        echo "<table class='table-auto w-full border-collapse border border-borderLight shadow-md rounded-lg bg-bgSemiDark'>";
        echo "<thead class='bg-bgDark'>
                <tr>
                    <th class='border border-gray-300 px-4 py-2'>Booking ID</th>
                    <th class='border border-gray-300 px-4 py-2'>User Name</th>
                    <th class='border border-gray-300 px-4 py-2'>Booking Status</th>
                    <th class='border border-gray-300 px-4 py-2'>Ticket Details</th>
                    <th class='border border-gray-300 px-4 py-2'>Actions</th>
                </tr>
              </thead>";
        echo "<tbody>";

        foreach ($bookings as $booking) {
            $bookingId = htmlspecialchars($booking->getBookingId());
            $user = $booking->getUser();
            $userName = $user ? htmlspecialchars($user->getFirstName() . " " . $user->getLastName()) : "Guest";
            $status = htmlspecialchars($booking->getStatus()->value);

            // Combine ticket details for the booking
            $tickets = $booking->getTickets();
            $ticketDetails = "No Tickets";
            if (!empty($tickets)) {
                $ticketDetails = "";
                foreach ($tickets as $ticket) {
                    $ticketDetails.= "<div class='flex flex-col border border-borderLight bg-primary rounded-md items-center justify-center mb-2'>";
                    $ticketDetails .= "<div class='text-xl text-textDark font-semibold mb-2 text-center'>";
                    $ticketDetails .= htmlspecialchars($ticket->getTicketType()->getName());
                    $ticketDetails .= "</div>";
                    $ticketDetails .= "<div class='text-gray-700'>";
                    $ticketDetails .= "<p>Row: " . htmlspecialchars($ticket->getSeat()->getRow()) . "</p>";
                    $ticketDetails .= "<p>Seat: " . htmlspecialchars($ticket->getSeat()->getSeatNr()) . "</p>";
                    $ticketDetails .= "</div>";
                    $ticketDetails.= "</div>";
                }
            }

            echo "<tr class='hover:bg-gray-800'>
                    <td class='border border-gray-300 px-4 py-2 text-center'>{$bookingId}</td>
                    <td class='border border-gray-300 px-4 py-2 text-center'>{$userName}</td>
                    <td class='border border-gray-300 px-4 py-2 text-center'>{$status}</td>
                    <td class='border border-gray-300 px-4 py-2 text-justify grid grid-cols-3 gap-x-4'>{$ticketDetails}</td>
                    <td class='border border-gray-300 px-4 py-2 text-center'>
                        <button class='bg-primary text-black py-2 px-4 border border-borderDark rounded hover:bg-bgSemiDark hover:text-white duration-[.2s] ease-in-out'>
                            Create Invoice
                        </button>
                    </td>
                  </tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
} else {
    echo "<p class='text-center text-red-500'>Please select a valid showing.</p>";
}
?>
