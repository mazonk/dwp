<?php
class PaymentRepository {
  private PDO $db;

  public function __construct($dbCon) {
    $this->db = $dbCon;
  }

  public function getIdsByCheckoutSessionId(string $checkoutSessionId): array {
    $query = $this->db->prepare('SELECT paymentId, addressId, bookingId FROM Payment WHERE checkoutSessionId = :checkoutSessionId');

    try {
      $query->execute(array('checkoutSessionId' => $checkoutSessionId));
      $result = $query->fetch(PDO::FETCH_ASSOC);

      if (empty($result)) {
        throw new Exception('No payment found by checkout session ID.');
      }
      return $result;
    } catch (PDOException $e) {
      throw new PDOException('Failed to get payment by checkout session ID.');
    }
  }

  public function addPayment(array $paymentData): void {
    $query = $this->db->prepare('INSERT INTO Payment (paymentDate, paymentTime, totalPrice, currency, paymentMethod, checkoutSessionId, paymentStatus, addressId, bookingId) VALUES (:paymentDate, :paymentTime, :totalPrice, :currency, :paymentMethod, :checkoutSessionId, :paymentStatus, :addressId, :bookingId)');

    try {
      $query->execute(array(
        'paymentDate' => $paymentData['paymentDate'],
        'paymentTime' => $paymentData['paymentTime'],
        'totalPrice' => $paymentData['totalPrice'],
        'currency' => $paymentData['currency'],
        'paymentMethod' => $paymentData['paymentMethod'],
        'checkoutSessionId' => $paymentData['checkoutSessionId'],
        'paymentStatus' => $paymentData['paymentStatus'],
        'addressId' => $paymentData['addressId'],
        'bookingId' => $paymentData['bookingId']
      ));
    } catch (PDOException $e) {
      throw new PDOException('Failed to add payment.');
    }
  }

  public function updatePaymentStatus(int $paymentId, string $paymentStatus): void {
    $query = $this->db->prepare("UPDATE Payment SET paymentStatus = :paymentStatus WHERE paymentId = :paymentId AND paymentStatus = 'pending'");

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