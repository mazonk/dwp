<?php
require_once "session_config.php";
require_once 'third-party/stripe-php/init.php';
require_once 'loadEnv.php';
require_once 'src/controller/PaymentController.php';
require_once 'src/controller/UserController.php';
require_once 'src/controller/BookingController.php';
/* require_once 'src/controller/ShowingController.php'; */


/* Guest User Handling */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userController = new UserController();
  $bookingController = new BookingController();
  
  // Check if user is logged in
  if (!isset($_SESSION['loggedInUser']['userId'])) {
    $formData = [];
    $formData['email'] = htmlspecialchars(trim($_POST['email']));
    $formData['firstName'] = htmlspecialchars(trim($_POST['firstName']));
    $formData['lastName'] = htmlspecialchars(trim($_POST['lastName']));
    $formData['dob'] = htmlspecialchars(trim($_POST['dob']));
    $currentRoute = filter_var(trim($_POST['route']), FILTER_SANITIZE_URL); // route where the form was submitted

    $doesUserExists = $userController->doesUserExistByEmail($formData['email']);
    $userId = null;

    // If user with this email already exists
    if ($doesUserExists) {
      $user = $userController->getUserByEmail($formData['email']);
      $userId = $user->getId();
    }
    // If user with this email does not exist yet
    else if (!$doesUserExists) {
      $result = $userController->createGuestUser($formData);

      if (isset($result['errorMessage']) && $result['errorMessage'] || isset($result['validationError']) && $result['validationError']) {
        header("Location: " . $currentRoute);
        exit;
      }
      $userId = $result;
    }
    else if (is_array($doesUserExists) && isset($doesUserExists['errorMessage'])) {
      $_SESSION['guestErrors'] = ['general' => 'An error occurred. ' . $result['errorMessage']];
      $_SESSION['guestFormData'] = $formData;
      header("Location: " . $currentRoute);
      exit;
    }

    // Update booking with user ID
    $bookingId = $_SESSION['activeBooking']['id'];
    $updatedBooking = $bookingController->updateBookingUser($bookingId, $userId);
    if (isset($updatedBooking['errorMessage']) && $updatedBooking['errorMessage']) {
      $_SESSION['guestErrors'] = ['general' => 'An error occurred. ' . $updatedBooking['errorMessage']];
      $_SESSION['guestFormData'] = $formData;
      header("Location: " . $currentRoute);
      exit;
    }
    echo 'Booking: ' . $bookingId . '<br>';
    echo 'User: ' . $userId;

  } else {
    echo 'Payment processing...';
  }
}

/* Stripe Handling */
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

/* try {
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
} */
