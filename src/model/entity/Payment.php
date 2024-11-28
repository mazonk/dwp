<?php
include_once "src/model/entity/User.php";
include_once "src/model/entity/Address.php";
include_once "src/model/entity/Booking.php";
include_once "src/model/entity/PaymentMethod.php";

enum Status: string {
  case CONFIRMED = 'confirmed';
  case PENDING = 'pending';
  case CANCELLED = 'cancelled';
}

class Payment {
  private int $paymentId;
  private DateTime $paymentDate;
  private DateTime $paymentTime;
  private float $totalPrice;
  private string $currency;
  private string $checkoutSessionId;
  private Status $status;
  private Venue $venue;
  private Booking $booking;
  
  public function __construct(int $paymentId, DateTime $paymentDate, DateTime $paymentTime, float $totalPrice, string $currency, string $checkoutSessionId, Status $status, Venue $venue, Booking $booking) {
    $this->paymentId = $paymentId;
    $this->paymentDate = $paymentDate;
    $this->paymentTime = $paymentTime;
    $this->totalPrice = $totalPrice;
    $this->currency = $currency;
    $this->checkoutSessionId = $checkoutSessionId;
    $this->status = $status;
    $this->venue = $venue;
    $this->booking = $booking;
  }

  public function getPaymentId(): int {
    return $this->paymentId;
  }

  public function getPaymentDate(): DateTime {
    return $this->paymentDate;
  }

  public function getPaymentTime(): DateTime {
    return $this->paymentTime;
  }

  public function getTotalPrice(): float {
    return $this->totalPrice;
  }

  public function getCurrency(): string {
    return $this->currency;
  }

  public function getCheckoutSessionId(): string {
    return $this->checkoutSessionId;
  }

  public function getStatus(): Status {
    return $this->status;
  }

  public function getVenue(): Venue {
    return $this->venue;
  }

  public function getBooking(): Booking {
    return $this->booking;
  }

  public function setPaymentId(int $paymentId): void {
    $this->paymentId = $paymentId;
  }

  public function setPaymentDate(DateTime $paymentDate): void {
    $this->paymentDate = $paymentDate;
  }

  public function setPaymentTime(DateTime $paymentTime): void {
    $this->paymentTime = $paymentTime;
  }

  public function setTotalPrice(float $totalPrice): void {
    $this->totalPrice = $totalPrice;
  }

  public function setCurrency(string $currency): void {
    $this->currency = $currency;
  }

  public function setCheckoutSessionId(string $checkoutSessionId): void {
    $this->checkoutSessionId = $checkoutSessionId;
  }

  public function setStatus(Status $status): void {
    $this->status = $status;
  }

  public function setVenue(Venue $venue): void {
    $this->venue = $venue;
  }

  public function setBooking(Booking $booking): void {
    $this->booking = $booking;
  }
}
?>