<?php
require_once "src/model/services/InvoiceService.php";

class InvoiceController {
  private InvoiceService $invoiceService;

  public function __construct() {
    $this->invoiceService = new InvoiceService();
  }

  public function sendInvoice(int $paymentId): void {
    $result = $this->invoiceService->sendInvoice($paymentId);

    if ($result['error']) {
      echo $result['message'];
    } else {
      echo "Invoice sent successfully.";
    }
  }
}