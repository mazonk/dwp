<?php
include_once "src/model/services/PaymentService.php";

class PaymentController {
  private PaymentService $paymentService;

  public function __construct() {
    $this->paymentService = new PaymentService();
  }

  public function getIdsByCheckoutSessionId(string $checkoutSessionId): array {
    $paymentIds = $this->paymentService->getIdsByCheckoutSessionId($checkoutSessionId);

    if (isset($paymentIds['error']) && $paymentIds['error']) {
      return ['errorMessage' => $paymentIds['message']];
    }
    return $paymentIds;
  }

  public function addPayment(array $paymentData): array {
    $payment = $this->paymentService->addPayment($paymentData);

    if (isset($payment['error']) && $payment['error']) {
      return ['errorMessage' => $payment['message']];
    }
    return ['success' => true];
  }

  public function updatePaymentStatus(int $paymentId, int $bookingId, string $paymentStatus): array {
    $payment = $this->paymentService->updatePaymentStatus($paymentId, $bookingId, $paymentStatus);

    if (isset($payment['error']) && $payment['error']) {
      return ['errorMessage' => $payment['message']];
    }
    return ['success' => true];
  }
}