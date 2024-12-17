<?php
include_once "src/model/entity/Seat.php";

class SeatCard {
    public static function render(Seat $seat, $isAvailable, $showingId, $userId) {
        $seatId = $seat->getSeatId();
        $seatNr = $seat->getSeatNr();
        $row = $seat->getRow();

        $seatClass = $isAvailable ? 'bg-lime-600' : 'bg-purple-500';
        $availabilityAttribute = $isAvailable ? 'true' : 'false';

        $output = "<div class='seat-card $seatClass p-1 w-15 h-auto rounded text-center cursor-pointer' data-seat-id='$seatId' data-seat-nr='$seatNr' data-row='$row' data-is-available='$availabilityAttribute' data-showing-id='$showingId' data-user-id='$userId'>";
        $output .= "<img src='src/assets/armchair.svg' alt='Seat Icon' class='w-8 h-8 mx-auto rotate-180 '>";
        $output .= "</div>";

        return $output;
    }
}