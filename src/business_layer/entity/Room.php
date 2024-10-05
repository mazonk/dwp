<?php
class Room {
  private int $roomId;
  private int $roomNumber;

  public function __construct(int $roomId, int $roomNumber) {
    $this->roomId = $roomId;
    $this->roomNumber = $roomNumber;
  }

  public function getRoomId(): int {
    return $this->roomId;
  }

  public function getRoomNumber(): int {
    return $this->roomNumber;
  }

  public function setRoomId(int $roomId): void {
    $this->roomId = $roomId;
  }

  public function setRoomNumber(int $roomNumber): void {
    $this->roomNumber = $roomNumber;
  }
}
?>