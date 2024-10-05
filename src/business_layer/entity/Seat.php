<?php
class Seat {
  private int $seatId;
  private int $row;
  private int $seatNr;

  public function __construct(int $seatIds, int $row, int $seatNr) {
    $this->seatId = $seatId;
    $this->row = $row;
    $this->seatNr = $seatNr;
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

  public function setSeatId(int $seatId): void {
    $this->seatId = $seatId;
  }

  public function setRow(int $row): void {
    $this->row = $row;
  }

  public function setSeatNr(int $seatNr): void {
    $this->seatNr = $seatNr;
  }
}
?>