<?php
require_once 'third-party/stripe-php/init.php';
require_once 'loadEnv.php';

// Load environment variables for Stripe API keys
loadEnv();
$stripe_public_key = getenv('STRIPE_PK');
$stripe_secret_key = getenv('STRIPE_SK');

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
  "mode" => "payment",
  // TODO: dynamic success and cancel route
  "success_url" => "http://localhost/dwp?success=true",
  "cancel_url" => "http://localhost/dwp?success=false",
  // TODO: dynamic items, in this case tickets for the movie
  "line_items" => [
    [
      "quantity" => 1,
      "price_data" => [
        "currency" => "dkk",
        "unit_amount" => 6000, // set in cents (60 DKK)
        "product_data" => [
          "name" => "Movie ticket",
        ]
      ]
    ]
  ]
]);

// 303 See Other status code, so the form doesn't get resubmitted for example on refresh or when going back to the page
http_response_code(303); 
header("Location: " . $checkout_session->url);