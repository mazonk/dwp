<?php
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
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  exit();
}

// Handle the event
switch ($event->type) {
  $paymentController = new PaymentController();
  
  case: 'checkout.session.completed':
    $eventData = $event->data->object;
    // Update payment status to confirmed, and send invoice
    $paymentIds = $paymentController->getIdsByCheckoutSessionId($eventData->id);
    $paymentController->updatePaymentStatus($paymentIds['paymentId'], $paymentIds['bookingId'], 'confirmed'); 

    $invoiceController = new InvoiceController();
    $invoiceController->sendInvoice($eventData); // TODO: Sanitizing, validation, and error handling, and also the actual invoice data
    break;

  case: 'payment_intent.payment_failed':
    $eventData = $event->data->object;
    // Update payment status to failed
    $paymentIds = $paymentController->getIdsByCheckoutSessionId($eventData->id);
    $paymentController->updatePaymentStatus($paymentIds['paymentId'], $paymentIds['bookingId'], 'failed');
    break;

  default:
    // Unexpected event type
    http_response_code(400);
    exit();
}

http_response_code(200);
