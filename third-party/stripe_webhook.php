<?php
require_once 'third-party/stripe-php/init.php';
require_once 'loadEnv.php';

// Load environment variables for Stripe API keys
loadEnv();
$stripe_secret_key = getenv('STRIPE_SK');

\Stripe\Stripe::setApiKey($stripe_secret_key);


