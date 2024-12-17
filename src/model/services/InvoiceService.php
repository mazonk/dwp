<?php
require_once 'src/model/services/SeatService.php'; 
require_once 'src/model/services/TicketService.php';
require_once 'src/model/services/PaymentService.php';
require_once 'src/model/services/CompanyInfoService.php';

class InvoiceService {
  private $ticketService;
  private $paymentService;
  private $companyInfoService;

  public function __construct() {
    $seatService = new SeatService();
    $this->ticketService = new TicketService();
    $this->ticketService->setSeatService($seatService);
    $this->paymentService = new PaymentService();
    $this->companyInfoService = new CompanyInfoService();
  }

  public function sendInvoice(int $paymentId): array {
    // Get payment details
    $payment = $this->paymentService->getPaymentById($paymentId);
    if (is_array($payment) && isset($payment['error']) && $payment['error']) {
      return $payment;
    }

    // Get tickets details
    $tickets = [];
    foreach ($payment->getBooking()->getTickets() as $ticket) {
      $ticket = $this->ticketService->getTicketById($ticket->getTicketId());
      if (is_array($ticket) && isset($ticket['error']) && $ticket['error']) {
        return $ticket;
      }
      $tickets[] = $ticket;
    }

    // Get compamy info details
    $companyInfo = $this->companyInfoService->getCompanyInfo();
    if (is_array($companyInfo) && isset($companyInfo['error']) && $companyInfo['error']) {
      return $companyInfo;
    }

    $subject = "Invoice for your purchase";
    $mailTo = $payment->getBooking()->getUser()->getEmail(); // Customer's email
    $headers = "From: dwp@spicypisces.eu"; // Venue/Companys's email
    $txt = "Thank you for your purchase.\n\n" .

    "**Invoice Number:**\n" .
    "INV-" . $payment->getPaymentId() . "\n\n" . // Invoice number

    "**Booking Details:**\n" .
    "Movie: " . $tickets[0]->getShowing()->getMovie()->getTitle() . "\n" . // Movie name
    "Date: " . $tickets[0]->getShowing()->getShowingDate()->format('Y-m-d') . "\n" . // Movie date
    "Time: " . $tickets[0]->getShowing()->getShowingTime()->format('H:i') . "\n" . // Movie time
    "Venue: " . $tickets[0]->getShowing()->getRoom()->getVenue()->getName() . "\n" . // Venue name
    "Room: " . $tickets[0]->getShowing()->getRoom()->getRoomNumber() . "\n\n" . // Room name

    "Tickets:\n" .
    "----------------------------------------------\n" .
    "| Type       | Row  | Seat(s) | Price       |\n" .
    "|------------|------|---------|-------------|\n";

    foreach ($tickets as $ticket) {
      $txt .= "| " . $ticket->getTicketType()->getName() . "   | " . $ticket->getSeat()->getRow() . "    | " . $ticket->getSeat()->getSeatNr() . "       | " . $ticket->getTicketType()->getPrice() . " " . $payment->getCurrency() . "      |\n";
    }

    $txt .= "----------------------------------------------\n" .
    "Total: " . $payment->getTotalPrice() . " " . $payment->getCurrency() . "\n\n" . // Total price

    "**Customer Information:**\n" .
    "Name: " . $payment->getBooking()->getUser()->getFirstName() . " " . $payment->getBooking()->getUser()->getLastName() . "\n" . // Customer name
    "Address: " . $payment->getAddress()->getStreet() . " " . $payment->getAddress()->getStreetNr() . "\n" . $payment->getAddress()->getPostalCode()->getPostalCode() . " " . $payment->getAddress()->getPostalCode()->getCity() . "\n\n" . // Customer address

    "**Company Information:**\n" .
    $companyInfo->getCompanyName() . "\n" . // Company name
    $companyInfo->getAddress()->getStreet() . " " . $companyInfo->getAddress()->getStreetNr() . "\n" . $companyInfo->getAddress()->getPostalCode()->getPostalCode() . " " . $companyInfo->getAddress()->getPostalCode()->getCity() . "\n\n" . // Company address

    "----------------------------------------------\n" .
    "If you have any questions or require assistance, please contact us at dwp@spicypisces.eu.\n\n" .

    "Thank you for choosing us! Enjoy your movie!";

    // Send email and handle success/failure
    if (mail($mailTo, $subject, $txt, $headers)) {
      return ["success" => true];
    } else {
      return ["error" => true, "message" => "Failed to send invoice."];
    } 
  }
}