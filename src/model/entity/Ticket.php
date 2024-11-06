<?php
class Ticket {
  private int $ticketId;
  private Seat $seat;
  private TicketType $ticketType;
  private Showing $showing;

  public function __construct(int $ticketId, Seat $seat, TicketType $ticketType, Showing $showing) {
    $this->ticketId = $ticketId;
    $this->seat = $seat;
    $this->ticketType = $ticketType;
    $this->showing = $showing;
  }

  public function getTicketId(): int {
    return $this->ticketId;
  }

  public function getSeat(): Seat {
    return $this->seat;
  }

  public function getTicketType(): TicketType {
    return $this->ticketType;
  }

  public function getShowing(): Showing {
    return $this->showing;
  }

  public function setTicketId(int $ticketId): void {
    $this->ticketId = $ticketId;
  }

  public function setSeat(Seat $seat): void {
    $this->seat = $seat;
  }

  public function setTicketType(TicketType $ticketType): void {
    $this->ticketType = $ticketType;
  }

  public function setShowing(Showing $showing): void {
    $this->showing = $showing;
  }
}
?>