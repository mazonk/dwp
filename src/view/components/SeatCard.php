<?php
include_once "src/model/entity/Seat.php";
include_once "src/controller/SeatController.php"; // Include your SeatController

class SeatCard {
    public static function render(Seat $seat, $isAvailable, $showingId, $userId) {
        $seatId = $seat->getSeatId();
        $seatNr = $seat->getSeatNr();
        $row = $seat->getRow();
        $seatClass = $isAvailable ? 'seat available' : 'seat occupied'; // Class based on availability

        // Start the output with the seat div
        $output = "<div class='$seatClass' data-seat-id='$seatId' data-seat-nr='$seatNr' data-row='$row'></div>";

        // Add a form for booking the seat if it's available
        if ($isAvailable) {
            $output .= "
            <form action='your_booking_endpoint.php' method='POST' class='inline-block'>
                <input type='hidden' name='showingId' value='$showingId'>
                <input type='hidden' name='userId' value='$userId'> <!-- Get user ID as needed -->
                <input type='hidden' name='seatId' value='$seatId'> <!-- Pass the selected seat ID -->
                <button type='submit' class='book-seat-button bg-green-500 text-white p-2 rounded hover:bg-green-700'>Book Seat</button>
            </form>";
        }

        return $output;
    }
}
?>
