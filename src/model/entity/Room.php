<?php
class Room {
  private int $roomId;
  private int $roomNumber;
  private Venue $venue;

  public function __construct(int $roomId, int $roomNumber, Venue $venue) {
    $this->roomId = $roomId;
    $this->roomNumber = $roomNumber;
    $this->venue = $venue;
  }

  public function getRoomId(): int {
    return $this->roomId;
  }

  public function getRoomNumber(): int {
    return $this->roomNumber;
  }

  public function getVenue(): Venue {
    return $this->venue;
  }

  public function setRoomId(int $roomId): void {
    $this->roomId = $roomId;
  }

  public function setRoomNumber(int $roomNumber): void {
    $this->roomNumber = $roomNumber;
  }

  public function setVenue(Venue $venue): void {
    $this->venue = $venue;
  }
}