<?php
class PaymentRepository {
  private PDO $db;

  public function __construct($dbCon) {
    $this->db = $dbCon;
  }

  public function addPayment(array $paymentData): void {
    $query = $this->db->prepare('INSERT INTO payment (paymentDate, paymentTime, totalPrice, currency, paymentMethod, checkoutSessionId, paymentStatus, venueId, bookingId) VALUES (:paymentDate, :paymentTime, :totalPrice, :currency, :paymentMethod, :checkoutSessionId, :paymentStatus, :venueId, :bookingId)');

    try {
      $query->execute(array(
        'paymentDate' => $paymentData['paymentDate'],
        'paymentTime' => $paymentData['paymentTime'],
        'totalPrice' => $paymentData['totalPrice'],
        'currency' => $paymentData['currency'],
        'paymentMethod' => $paymentData['paymentMethod'],
        'checkoutSessionId' => $paymentData['checkoutSessionId'],
        'paymentStatus' => $paymentData['paymentStatus'],
        'venueId' => $paymentData['venueId'],
        'bookingId' => $paymentData['bookingId']
      ));
    } catch (PDOException $e) {
      throw new PDOException('Failed to add payment.');
    }
  }

  public function updatePaymentStatus(int $paymentId, string $paymentStatus): void {
    $query = $this->db->prepare("UPDATE Payment SET paymentStatus = :paymentStatus WHERE paymentId = :paymentId");

    try {
      $query->execute(array(
        'paymentId' => $paymentId,
        'paymentStatus' => $paymentStatus
      ));
    } catch (PDOException $e) {
      throw new PDOException('Failed to update payment status.');
    }
  }
}