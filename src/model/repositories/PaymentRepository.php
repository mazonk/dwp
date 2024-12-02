<?php
class PaymentRepository {
  
  private function getdb(): PDO {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance();
  }

  public function getIdsByCheckoutSessionId(string $checkoutSessionId): array {
    $db = $this->getdb();
    $query = $db->prepare('SELECT paymentId, venueId, bookingId FROM payment WHERE checkoutSessionId = :checkoutSessionId');

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
    $db = $this->getdb();
    $query = $db->prepare('INSERT INTO payment (paymentDate, paymentTime, totalPrice, currency, paymentMethod, checkoutSessionId, paymentStatus, venueId, bookingId) VALUES (:paymentDate, :paymentTime, :totalPrice, :currency, :paymentMethod, :checkoutSessionId, :paymentStatus, :venueId, :bookingId)');

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
    $db = $this->getdb();
    $query = $db->prepare("UPDATE Payment SET paymentStatus = :paymentStatus WHERE paymentId = :paymentId");

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