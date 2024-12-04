<?php
require_once 'third-party/stripe-php/init.php';
require_once 'loadEnv.php';
require_once 'src/controller/PaymentController.php';

// Load environment variables for Stripe API keys
loadEnv();
$stripe_secret_key = getenv('STRIPE_SK');

\Stripe\Stripe::setApiKey($stripe_secret_key);

// Payment Data
$paymentData = [
  'paymentDate' => date('Y-m-d'),
  'paymentTime' => date('H:i:s'),
  'totalPrice' => 60,
  'currency' => null,
  'paymentMethod' => null,
  'checkoutSessionId' => null,
  'paymentStatus' => 'pending',
  'addressId' => 1,
  'bookingId' => 2
];

try {
  $checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    // TODO: dynamic success and cancel route
    "success_url" => "https://spicypisces.eu/booking/checkout_success",
    "cancel_url" => "https://spicypisces.eu",
    'expires_at' => time() + 1800, // Custom expiration time 30 minutes (minimum)
    // TODO: dynamic items, in this case tickets for the movie
    "line_items" => [
      [
        "quantity" => 1,
        "price_data" => [
          "currency" => 'dkk',
          "unit_amount" => $paymentData['totalPrice'] * 100, // set in cents (60 DKK)
          "product_data" => [
            "name" => "Movie ticket",
          ]
        ]
      ]
    ]
  ]);
  
  $paymentData['checkoutSessionId'] = $checkout_session->id;
  $paymentData['currency'] = $checkout_session->currency;
  $paymentData['paymentMethod'] = $checkout_session->payment_method_types[0];
  
  $paymentController = new PaymentController();
  $payment = $paymentController->addPayment($paymentData);
  
  if(isset($payment['errorMessage'])) {
    /* foreach ($paymentData as $key => $value) {
      echo $key . ': ' . $value . '<br>';
    } */
    echo $payment['errorMessage'];
  } 
  else {
    // 303 See Other status code, so the form doesn't get resubmitted for example on refresh or when going back to the page
    http_response_code(303); 
    header("Location: " . $checkout_session->url);
  }
} catch (\Stripe\Exception\ApiErrorException $e) {
  // Handle Stripe API errors
  echo 'Stripe error: ' . $e->getMessage();
}