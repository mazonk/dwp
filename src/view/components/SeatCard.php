<?php
include_once "src/model/entity/Seat.php";

class SeatCard {
    public static function render(Seat $seat, $isAvailable) {
        $seatId = $seat->getSeatId();
        $seatNr = $seat->getSeatNr();
        $row = $seat->getRow();
        $seatClass = $isAvailable ? 'seat available' : 'seat occupied'; // Class based on availability

        return "<div class='$seatClass' data-seat-id='$seatId' data-seat-nr='$seatNr' data-row='$row'></div>";
    }
}
