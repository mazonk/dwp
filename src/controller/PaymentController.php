<?php
include_once "src/model/services/PaymentService.php";

class PaymentController {
  private PaymentService $paymentService;

  public function __construct() {
    $this->paymentService = new PaymentService();
  }

  public function addPayment(array $paymentData): array {
    $payment = $this->paymentService->addPayment($paymentData);

    if (isset($payment['error']) && $payment['error']) {
      return ['errorMessage' => $payment['message']];
    }
    return ['success' => true];
  }
}