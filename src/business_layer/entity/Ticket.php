<?php
class Ticket {
  private int $ticketId;

  public function __construct(int $ticketId) {
    $this->ticketId = $ticketId;
  }

  public function getTicketId(): int {
    return $this->ticketId;
  }

  public function setTicketId(int $ticketId): void {
    $this->ticketId = $ticketId;
  }
}
?>