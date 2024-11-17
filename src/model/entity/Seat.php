<?php
<<<<<<< HEAD
include_once "src/model/entity/Room.php";
=======
>>>>>>> main
class Seat {
  private int $seatId;
  private int $row;
  private int $seatNr;
  private Room $room;

<<<<<<< HEAD
  public function __construct(int $seatId, int $row, int $seatNr, Room $room) {
=======
  public function __construct(int $seatIds, int $row, int $seatNr, Room $room) {
>>>>>>> main
    $this->seatId = $seatId;
    $this->row = $row;
    $this->seatNr = $seatNr;
    $this->room = $room;
  }

  public function getSeatId(): int {
    return $this->seatId;
  }

  public function getRow(): int {
    return $this->row;
  }

  public function getSeatNr(): int {
    return $this->seatNr;
  }

  public function getRoom(): Room {
    return $this->room;
  }

  public function setSeatId(int $seatId): void {
    $this->seatId = $seatId;
  }

  public function setRow(int $row): void {
    $this->row = $row;
  }

  public function setSeatNr(int $seatNr): void {
    $this->seatNr = $seatNr;
  }

  public function setRoom(Room $room): void {
    $this->room = $room;
  }
}
?>