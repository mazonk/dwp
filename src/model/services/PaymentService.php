<?php
include_once "src/model/entity/Payment.php";
include_once "src/model/repositories/PaymentRepository.php";
include_once "src/model/services/BookingService.php";
include_once "src/model/services/VenueService.php";

class PaymentService {
  private PaymentRepository $paymentRepository;
  private BookingService $bookingService;
  private VenueService $venueService;

  public function __construct() {
    $this->paymentRepository = new PaymentRepository();
    $this->bookingService = new BookingService();
    $this->venueService = new VenueService();
  }

  public function addPayment(array $paymentData): array {
    try {
      $this->paymentRepository->addPayment($paymentData);
      
      return ['success' => true];
    } catch (Exception $e) {
      return ["error" => true, "message" => $e->getMessage()];
    }
  }
}