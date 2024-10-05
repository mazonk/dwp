<?php
class Room {
  private int $roomId;
  private int $roomNumber;
  private Venue $venueId;

  public function __construct(int $roomId, int $roomNumber, Venue $venueId) {
    $this->roomId = $roomId;
    $this->roomNumber = $roomNumber;
    $this->venueId = $venueId;
  }

  public function getRoomId(): int {
    return $this->roomId;
  }

  public function getRoomNumber(): int {
    return $this->roomNumber;
  }

  public function getVenueId(): Venue {
    return $this->venueId;
  }

  public function setRoomId(int $roomId): void {
    $this->roomId = $roomId;
  }

  public function setRoomNumber(int $roomNumber): void {
    $this->roomNumber = $roomNumber;
  }
}
?>