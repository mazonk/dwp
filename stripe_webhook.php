<?php
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/error.log'); // Log errors to 'error.log' in the current directory

require_once 'third-party/stripe-php/init.php';
require_once 'src/controller/PaymentController.php';
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
$invoiceController = new InvoiceController();

// Handle the event
switch ($event->type) {
  case 'checkout.session.completed':
    //Log
    error_log("Handling 'checkout.session.completed' event.");
    $eventData = $event->data->object;

    //Log
    error_log("Updating payment for session ID: " . $eventData->id);
    // Update payment status to confirmed, and send invoice
    $paymentIds = $paymentController->getIdsByCheckoutSessionId($eventData->id);
    //Log
    error_log("Retrieved payment IDs: " . json_encode($paymentIds));
    $paymentController->updatePaymentStatus($paymentIds['paymentId'], $paymentIds['bookingId'], 'confirmed'); 
    //Log
    error_log("Payment status updated to 'confirmed'");

    $invoiceController->sendInvoice(); // TODO: Sanitizing, validation, and error handling, and also the actual invoice data
    //Log
    error_log("Invoice sent successfully.");
    break;

  case 'payment_intent.payment_failed':
    //Log
    error_log("Handling 'payment_intent.payment_failed' event.");
    $eventData = $event->data->object;
    // Update payment status to failed
    $paymentIds = $paymentController->getIdsByCheckoutSessionId($eventData->id);
    //Log
    error_log("Retrieved payment IDs for failed intent: " . json_encode($paymentIds));
    $paymentController->updatePaymentStatus($paymentIds['paymentId'], $paymentIds['bookingId'], 'failed');
    //Log
    error_log("Payment status updated to 'failed'");
    break;

  default:
    // Unexpected event type
    http_response_code(400);
    exit();
}

http_response_code(200);
