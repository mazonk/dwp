<?php
include_once "src/model/entity/Payment.php";
include_once "src/model/repositories/PaymentRepository.php";
include_once "src/model/services/BookingService.php";

class PaymentService {
  private PaymentRepository $paymentRepository;
  private BookingService $bookingService;

  public function __construct() {
    $this->paymentRepository = new PaymentRepository();
    $this->bookingService = new BookingService();
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
      $this->paymentRepository->updatePaymentStatus($paymentId, $paymentStatus);
      $this->bookingService->updateBookingStatus($bookingId, $paymentStatus);

      return ['success' => true];
    } catch (Exception $e) {
      return ["error" => true, "message" => $e->getMessage()];
    }
  }

  
}