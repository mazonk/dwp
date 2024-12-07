<?php
require_once "session_config.php";
require_once 'third-party/stripe-php/init.php';
require_once 'loadEnv.php';
require_once 'src/controller/PaymentController.php';
require_once 'src/controller/UserController.php';
require_once 'src/controller/BookingController.php';
require_once 'src/controller/ShowingController.php';
require_once 'src/controller/VenueController.php';
require_once 'src/controller/TicketController.php';


/* Guest User Handling */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userController = new UserController();
  $bookingController = new BookingController();

  $formData = [];
  $bookingId = filter_var($_SESSION['activeBooking']['id'], FILTER_VALIDATE_INT);
  $currentRoute = filter_var(trim($_POST['route']), FILTER_SANITIZE_URL);
  
  // Check if user is logged in
  if (!isset($_SESSION['loggedInUser']['userId'])) {
    $formData['email'] = htmlspecialchars(trim($_POST['email']));
    $formData['firstName'] = htmlspecialchars(trim($_POST['firstName']));
    $formData['lastName'] = htmlspecialchars(trim($_POST['lastName']));
    $formData['dob'] = htmlspecialchars(trim($_POST['dob']));

    $doesUserExists = $userController->doesUserExistByEmail($formData['email']);
    $userId = null;

    // If user with this email already exists
    if ($doesUserExists) {
      $_SESSION['guestErrors'] = ['general' => 'It seems there is already an account with this email. Please log in to proceed with your payment.'];
      $_SESSION['guestFormData'] = $formData;
      header("Location: " . $currentRoute);
      exit;
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
    $updatedBooking = $bookingController->updateBookingUser($bookingId, $userId);
    if (isset($updatedBooking['errorMessage']) && $updatedBooking['errorMessage']) {
      $_SESSION['guestErrors'] = ['general' => 'An error occurred. ' . $updatedBooking['errorMessage']];
      $_SESSION['guestFormData'] = $formData;
      header("Location: " . $currentRoute);
      exit;
    }
    handlePayment($formData['email'], $bookingId, $formData, $currentRoute);

  } else {
    handlePayment($_SESSION['loggedInUser']['userEmail'], $bookingId, $formData, $currentRoute);
  }
}

/* Stripe Handling */
function handlePayment(string $userEmail, int $bookingId, array $formData, string $currentRoute) {
  $showingController = new ShowingController();
  $venueController = new VenueController();
  $ticketController = new TicketController();
  $paymentController = new PaymentController();

  $booking = $_SESSION['activeBooking'];
  // Validate and sanitize input
  $showingId = filter_var($booking['showingId'], FILTER_VALIDATE_INT);
  $venueId = filter_var($_SESSION['selectedVenueId'], FILTER_VALIDATE_INT);

  $showing = $showingController->getShowingById($showingId, $venueId);
  $movie = $showing->getMovie();
  $venue = $venueController->getVenueById($venueId);

  // Load environment variables for Stripe API keys
  loadEnv();
  $stripe_secret_key = getenv('STRIPE_SK');

  \Stripe\Stripe::setApiKey($stripe_secret_key);

  // Get tickets for the booking
  $tickets = [];
  foreach ($booking['ticketIds'] as $ticketId) {
    $ticket = $ticketController->getTicketById($ticketId);
    $tickets[] = $ticket;
  }

  // Get ticket types and count them
  $ticketTypes = [];
  foreach ($tickets as $ticket) {
    $ticketType = $ticket->getTicketType();
    if (isset($ticketTypes[$ticketType->getTicketTypeId()])) {
      $ticketTypes[$ticketType->getTicketTypeId()]['count']++;
    } else {
      $ticketTypes[$ticketType->getTicketTypeId()] = [
          'name' => $ticketType->getName(),
          'price' => $ticketType->getPrice(),
          'count' => 1
      ];
    }
  }
  
  // Calculate total price
  $totalPrice = 0;
  foreach ($ticketTypes as $ticketType) {
    $totalPrice += $ticketType['count'] * $ticketType['price'];
  }

  // Payment Data
  $paymentData = [
    'paymentDate' => date('Y-m-d'),
    'paymentTime' => date('H:i:s'),
    'totalPrice' => $totalPrice,
    'currency' => null,
    'paymentMethod' => null,
    'checkoutSessionId' => null,
    'paymentStatus' => 'pending',
    'addressId' => 1,
    'bookingId' => $bookingId,
  ];

  try {
    // Create a string with seat descriptions
    /* $seatDescriptions = [];
    foreach ($tickets as $ticket) {
      $seat = $ticket->getSeat();
      $seatDescriptions[] = "Row " . htmlspecialchars($seat->getRow()) . " - Seat " . htmlspecialchars($seat->getSeatNr());
    }
    $seatsString = implode(", ", $seatDescriptions); */

    // Create line items for the checkout session
    $lineItems = [];
    foreach ($ticketTypes as $ticketType) {
      $lineItems[] = [
        "quantity" => $ticketType['count'],
        "price_data" => [
          "currency" => 'dkk',
          "unit_amount" => $ticketType['price'] * 100, // Price in cents
          "product_data" => [
              "name" => $movie->getTitle() . " " . $ticketType['name'] . ($ticketType['count'] > 1 ? ' tickets' : ' ticket'),
              "description" => $showing->getShowingDate()->format('Y-m-d') . " " . $showing->getShowingTime()->format('H:i') . " " . $venue->getName()
          ]
        ]
      ];
    }

    $checkout_session = \Stripe\Checkout\Session::create([
      "mode" => "payment",
      // Localhost URLs for testing
      "success_url" => "http://localhost/dwp/booking/checkout_success",
      "cancel_url" => "http://localhost/dwp/home",
      "customer_email" => $userEmail,
      // Production URLs
      /* "success_url" => "https://spicypisces.eu/booking/checkout_success",
      "cancel_url" => "https://spicypisces.eu", */
      "expires_at" => time() + 1800, // Custom expiration time 30 minutes (minimum)
      "line_items" => $lineItems
  ]);

    $paymentData['checkoutSessionId'] = htmlspecialchars($checkout_session->id);
    $paymentData['currency'] = htmlspecialchars($checkout_session->currency);
    $paymentData['paymentMethod'] = htmlspecialchars($checkout_session->payment_method_types[0]);
    
    $payment = $paymentController->addPayment($paymentData);
    
    if(isset($payment['errorMessage']) && $payment['errorMessage']) {
      $_SESSION['guestErrors'] = ['general' => 'An error occurred. ' . $payment['errorMessage']];
      if (count($formData) > 0) {
        $_SESSION['guestFormData'] = $formData;
      }
      header("Location: " . $currentRoute);
      exit;
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
}


