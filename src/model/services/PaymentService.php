<?php
include_once "src/model/entity/Payment.php";
include_once "src/model/repositories/PaymentRepository.php";
include_once "src/model/services/BookingService.php";

class PaymentService {
  private PDO $db;
  private PaymentRepository $paymentRepository;
  private BookingService $bookingService;

  public function __construct() {
    $this->db = $this->getdb();
    $this->paymentRepository = new PaymentRepository($this->db);
    $this->bookingService = new BookingService();
  }

  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  public function getIdsByCheckoutSessionId(string $checkoutSessionId): array {
    try {
      return $this->paymentRepository->getIdsByCheckoutSessionId($checkoutSessionId);
    } catch (Exception $e) {
      return ["error" => true, "message" => $e->getMessage()];
    }
  }

  public function addPayment(array $paymentData): array {
    try {
      $this->paymentRepository->addPayment($paymentData);
      
      return ['success' => true];
    } catch (Exception $e) {
      return ["error" => true, "message" => $e->getMessage()];
    }
  }

  public function updatePaymentStatus(int $paymentId, int $bookingId, string $paymentStatus): array {
    try {
      // Start the transaction
      if (!$this->db->inTransaction()) {
        $this->db->beginTransaction();
      }

      $this->paymentRepository->updatePaymentStatus($paymentId, $paymentStatus);
      $this->bookingService->updateBookingStatus($bookingId, $paymentStatus);
      $this->db->commit();

      return ['success' => true];
    } catch (Exception $e) {
      // If there's any error, roll back the transaction
      if ($this->db->inTransaction()) {
        $this->db->rollBack();
      }

      return ["error" => true, "message" => $e->getMessage()];
    }
  }

  public function rollbackPayment(int $paymentId, int $bookingId, array $ticketIds): array {
    try {
      $this->db->beginTransaction();

      // Update payment status to failed
      $this->paymentRepository->updatePaymentStatus($paymentId, 'failed');

      // Roll back booking (and tickets)
      $bookingResult = $this->bookingService->rollBackBooking($bookingId, $ticketIds);
      if ($bookingResult['error']) {
          throw new Exception("Failed to roll back booking: " . $bookingResult['message']);
      }
      $this->db->commit();

      return ['success' => true];
    } catch (Exception $e) {
      $this->db->rollBack();
      return ["error" => true, "message" => $e->getMessage()];
    }
  }
}