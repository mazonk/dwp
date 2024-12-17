<?php
require_once "src/model/services/InvoiceService.php";

class InvoiceController {
  private InvoiceService $invoiceService;

  public function __construct() {
    $this->invoiceService = new InvoiceService();
  }

  public function sendInvoice(int $paymentId): array {
    $result = $this->invoiceService->sendInvoice($paymentId);

    if (isset($result['error']) && $result['error']) {
      return ["errorMessage" => $result['message']];
    } else {
      return ["successMessage" => "Invoice sent successfully."];
    }
  }
}