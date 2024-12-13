<?php
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/error.log'); // Log errors to 'error.log' in the current directory
require_once 'session_config.php';
require_once 'third-party/stripe-php/init.php';
require_once 'src/controller/PaymentController.php';
require_once 'src/controller/TicketController.php';
require_once 'src/controller/InvoiceController.php';
require_once 'loadEnv.php';

// Load environment variables for Stripe API keys
loadEnv();
$stripe_secret_key = getenv('STRIPE_SK');
$endpoint_secret = getenv('STRIPE_WH_SECRET');

\Stripe\Stripe::setApiKey($stripe_secret_key);

$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE']; // Retrieve the Stripe-Signature header
$payload = @file_get_contents("php://input");
$event = null;

try {
  // This is the signature verification step
  $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
  //Log
  error_log("Received event: " . $event->type);
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  exit();
}

// Controllers
$paymentController = new PaymentController();
$ticketController = new TicketController();
$invoiceController = new InvoiceController();

try {
  // Handle the event
  switch ($event->type) {
    case 'checkout.session.completed':
      $eventData = $event->data->object;

      // Get payment IDs by checkout session ID
      $paymentIds = $paymentController->getIdsByCheckoutSessionId($eventData->id);
      if (isset($paymentIds['errorMessage']) && $paymentIds['errorMessage']) {
        throw new Exception("Payment IDs not found for checkout session ID: {$eventData->id}");
      }

      // Update payment and booking status to confirmed
      $result = $paymentController->updatePaymentStatus($paymentIds['paymentId'], $paymentIds['bookingId'], 'confirmed');
      if (isset($result['errorMessage']) && $result['errorMessage']) {
        throw new Exception("Failed to update payment status to 'confirmed' for payment ID: {$paymentIds['paymentId']}");
      }
      //Log
      error_log("Payment status updated to 'confirmed' for paymentId: {$paymentIds['paymentId']}");

      // Send invoice
      // $invoiceController->sendInvoice(); // TODO: Sanitizing, validation, and error handling, and also the actual invoice data

      break;

    case 'checkout.session.expired':
      //Log
      error_log("Handling 'checkout.session.expired' event.");
      error_log("Processing event: " . $event->id . " at " . date('Y-m-d H:i:s'));

      $eventData = $event->data->object;

      // Get payment IDs by checkout session ID
      $paymentIds = $paymentController->getIdsByCheckoutSessionId($eventData->id);
      if (isset($paymentIds['errorMessage']) && $paymentIds['errorMessage']) {
        throw new Exception("Payment IDs not found for checkout session ID: {$eventData->id}");
      }
      //Log
      error_log("Retrieved payment IDs for expired event: " . json_encode($paymentIds));

      // Get tickets by booking ID
      $tickets = $ticketController->getTicketsByBookingId($paymentIds['bookingId']);
      if (isset($tickets['errorMessage']) && $tickets['errorMessage']) {
        throw new Exception("Tickets not found for booking ID: {$paymentIds['bookingId']}");
      }
      $ticketIds = $ticketIds = array_map(fn($ticket) => $ticket->getTicketId(), $tickets);
      //Log
      error_log("Retrieved ticket IDs for expired event: " . json_encode($ticketIds));

      // Rollback payment, booking, and tickets 
      $paymentResult = $paymentController->rollbackPayment($paymentIds['paymentId'], $paymentIds['bookingId'], $ticketIds);
      if (isset($paymentResult['errorMessage']) && $paymentResult['errorMessage']) {
        throw new Exception("Failed to rollback payment, booking, and tickets for payment ID: {$paymentIds['paymentId']}");
      }
      //Log
      error_log("Payment rollback result: " . json_encode($paymentResult));

      break;

    default:
      // Unexpected event type
      http_response_code(400);
      exit();
  }
} catch (Exception $e) {
  //Log
  error_log("Error: " . $e->getMessage());
  http_response_code(500);
  exit();
}

http_response_code(200);