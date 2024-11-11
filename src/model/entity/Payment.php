<?php
include_once "src/model/entity/User.php";
include_once "src/model/entity/Address.php";
include_once "src/model/entity/Booking.php";
include_once "src/model/entity/PaymentMethod.php";

class Payment {
  private int $paymentId;
  private float $totalPrice;
  private DateTime $paymentDate;
  private DateTime $paymentTime;
  private User $user;
  private Address $address;
  private Booking $booking;
  private PaymentMethod $paymentMethod;

  public function __construct(int $paymentId, float $totalPrice, DateTime $paymentDate, DateTime $paymentTime, User $user, Address $address, Booking $booking, PaymentMethod $paymentMethod) {
    $this->paymentId = $paymentId;
    $this->totalPrice = $totalPrice;
    $this->paymentDate = $paymentDate;
    $this->paymentTime = $paymentTime;
    $this->user = $user;
    $this->address = $address;
    $this->booking = $booking;
    $this->paymentMethod = $paymentMethod;
  }

  public function getPaymentId(): int {
    return $this->paymentId;
  }

  public function getTotalPrice(): float {
    return $this->totalPrice;
  }

  public function getPaymentDate(): DateTime {
    return $this->paymentDate;
  }

  public function getPaymentTime(): DateTime {
    return $this->paymentTime;
  }

  public function getUser(): User {
    return $this->user;
  }

  public function getAddress(): Address {
    return $this->address;
  }

  public function getBooking(): Booking {
    return $this->booking;
  }

  public function getPaymentMethod(): PaymentMethod {
    return $this->paymentMethod;
  }

  public function setPaymentId(int $paymentId): void {
    $this->paymentId = $paymentId;
  }

  public function setTotalPrice(float $totalPrice): void {
    $this->totalPrice = $totalPrice;
  }

  public function setPaymentDate(DateTime $paymentDate): void {
    $this->paymentDate = $paymentDate;
  }

  public function setPaymentTime(DateTime $paymentTime): void {
    $this->paymentTime = $paymentTime;
  }

  public function setUser(User $user): void {
    $this->user = $user;
  }

  public function setAddress(Address $address): void {
    $this->address = $address;
  }

  public function setBooking(Booking $booking): void {
    $this->booking = $booking;
  }

  public function setPaymentMethod(PaymentMethod $paymentMethod): void {
    $this->paymentMethod = $paymentMethod;
  }
}
?>