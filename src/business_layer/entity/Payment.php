<?php
class Payment {
  private int $paymentId;
  private float $totalPrice;
  private DateTime $paymentDate;
  private DateTime $paymentTime;

  public function __construct(int $paymentId, float $totalPrice, DateTime $paymentDate, DateTime $paymentTime) {
    $this->paymentId = $paymentId;
    $this->totalPrice = $totalPrice;
    $this->paymentDate = $paymentDate;
    $this->paymentTime = $paymentTime;
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
}
?>