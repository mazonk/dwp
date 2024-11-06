<?php
include_once "src/model/entity/Seat.php";

class SeatCard {
    public static function render(Seat $seat, $isAvailable, $showingId, $userId) {
        $seatId = $seat->getSeatId();
        $seatNr = $seat->getSeatNr();
        $row = $seat->getRow();
        $seatClass = $isAvailable ? 'bg-green-500' : 'bg-gray-500';
        
        // Start the output with the seat div
        $output = "<div class='seat-card $seatClass p-1 w-15 h-auto rounded text-center cursor-pointer'>";
        
        // Display seat number
        $output .= "<p class='font-bold text-white'>Seat $seatNr</p>";
        
        // Add a form for booking the seat if it's available
        if ($isAvailable) {
            $output .= "
            <form action='your_booking_endpoint.php' method='POST' class='inline-block'>
                <input type='hidden' name='showingId' value='$showingId'>
                <input type='hidden' name='userId' value='$userId'> <!-- Get user ID as needed -->
                <input type='hidden' name='seatId' value='$seatId'> <!-- Pass the selected seat ID -->
                <button type='submit' class='book-seat-button bg-green-500 text-white p-2 rounded hover:bg-green-700'>
                    Book Seat
                </button>
            </form>";
        } else {
            // Display a message or style if the seat is unavailable
            $output .= "<p class='text-sm text-white'>Unavailable</p>";
        }

        $output .= "</div>"; // End the seat div
        return $output;
    }
}
?>
