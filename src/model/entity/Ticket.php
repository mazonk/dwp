<?php
include_once "src/model/entity/Seat.php";
include_once "src/model/entity/TicketType.php";
include_once "src/model/entity/Showing.php";
include_once "src/model/entity/Booking.php";
class Ticket {
  private int $ticketId;
  private Seat $seat;
  private TicketType $ticketType;
  private Showing $showing;
  private Booking $booking;

  public function __construct(int $ticketId, Seat $seat, TicketType $ticketType, Showing $showing, Booking $booking) {
    $this->ticketId = $ticketId;
    $this->seat = $seat;
    $this->ticketType = $ticketType;
    $this->showing = $showing;
    $this->booking = $booking;

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

  public function getBooking(): Booking {
    return $this->booking;
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

  public function setBooking(Booking $booking): void {
    $this->booking = $booking;
  }

}
?>