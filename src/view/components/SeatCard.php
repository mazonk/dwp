<?php
include_once "src/model/entity/Seat.php";

class SeatCard {
    public static function render(Seat $seat, $isAvailable, $showingId, $userId) {
        $seatId = $seat->getSeatId();
        $seatNr = $seat->getSeatNr();
        $row = $seat->getRow();

        // Set the background color for the icon based on availability
        $seatClass = $isAvailable ? 'bg-lime-600' : 'bg-purple-500'; // Background color based on availability

        // Start the output with the seat div, keeping it clickable
        $output = "<div class='seat-card $seatClass p-1 w-15 h-auto rounded text-center cursor-pointer' data-seat-id='$seatId' data-seat-nr='$seatNr' data-row='$row'>";
        
        // Make the seat clickable: wrap the icon in a form or link
        $output .= "
        <form action='your_booking_endpoint.php' method='POST' class='inline-block'>
            <input type='hidden' name='showingId' value='$showingId'>
            <input type='hidden' name='userId' value='$userId'> <!-- Get user ID as needed -->
            <input type='hidden' name='seatId' value='$seatId'> <!-- Pass the selected seat ID -->
            <button type='submit' class='w-full h-full p-0'>
                <img src='src/assets/armchair.svg' alt='Seat Icon' class='w-8 h-8 mx-auto rotate-180' >
            </button>
        </form>";

        $output .= "</div>"; // End the seat div
        return $output;
    }
}
?>
