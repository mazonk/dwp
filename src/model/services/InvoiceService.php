<?php
class InvoiceService {
  public function sendInvoice(): array {
    $subject = "Invoice for your purchase";
    $mailTo = "dwp@spicypisces.eu"; // Customer's email
    $headers = "From: email_here"; // Venue/Companys's email
    $txt = "Thank you for your purchase"; // Invoice details

    // Send email and handle success/failure
    if (mail($mailTo, $subject, $txt, $headers)) {
      return ["success" => true];
    } else {
      return ["error" => true, "message" => "Failed to send invoice."];
    } 
  }
}