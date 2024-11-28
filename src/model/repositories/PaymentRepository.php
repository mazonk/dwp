<?php
class PaymentRepository {
  private function getdb(): PDO {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance();
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
}