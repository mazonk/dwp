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
require_once 'src/controller/AddressController.php';


// User handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Update the expiry time for the booking
  $_SESSION['activeBooking']['expiry'] = time() + 30 * 60; // 30 minutes from now;
  
  $userController = new UserController();
  $bookingController = new BookingController();
  $addressController = new AddressController();

  $formData = [];
  $addressFormData = [
    'street' => htmlspecialchars(trim($_POST['street'])),
    'streetNr' => htmlspecialchars(trim($_POST['streetNr'])),
    'city' => htmlspecialchars(trim($_POST['city'])),
    'postalCode' => htmlspecialchars(trim($_POST['postalCode']))
  ];
  $bookingId = filter_var($_SESSION['activeBooking']['id'], FILTER_VALIDATE_INT);
  $currentRoute = filter_var(trim($_POST['route']), FILTER_SANITIZE_URL);
  
  // Check if user is logged in
  if (!isset($_SESSION['loggedInUser']['userId'])) {
    $formData['email'] = htmlspecialchars(trim($_POST['email']));
    $formData['firstName'] = htmlspecialchars(trim($_POST['firstName']));
    $formData['lastName'] = htmlspecialchars(trim($_POST['lastName']));
    $formData['dob'] = htmlspecialchars(trim($_POST['dob']));

    $doesAccountExists = $userController->doesAccountExistByEmail($formData['email']);
    $userId = null;

    // If user with this email already exists
    if ($doesAccountExists === true) {
      handleErrorAndRedirect($currentRoute, ['general' => 'It seems there is already an account with this email. Please log in or try another email.'], $formData, $addressFormData);
    }
    // If user with this email does not exist yet
    else if ($doesAccountExists === false) {
      $guestId = $userController->doesGuestExistByEmail($formData['email'], 'Guest');

      // If guest with this email already exists
      if ($guestId > 0) {
        $updatedGuestId = $userController->updateGuestInfo($formData, $guestId);

        if (isset($updatedGuestId['errorMessage']) && $updatedGuestId['errorMessage'] || isset($updatedGuestId['validationError']) && $updatedGuestId['validationError']) {
          header("Location: " . $currentRoute);
          exit;
        }
        $userId = $updatedGuestId;
      }
      // If guest with this email does not exist yet
      else if ($guestId === 0) {
        $result = $userController->createGuestUser($formData);

        if (isset($result['errorMessage']) && $result['errorMessage'] || isset($result['validationError']) && $result['validationError']) {
          header("Location: " . $currentRoute);
          exit;
        }
        $userId = $result;
      }
      else if (is_array($guestId) && isset($guestId['errorMessage'])) {
        handleErrorAndRedirect($currentRoute, ['general' => 'An error occurred. ' . $guestId['errorMessage']], $formData, $addressFormData);
      }
    }
    else if (is_array($doesAccountExists) && isset($doesAccountExists['errorMessage'])) {
      handleErrorAndRedirect($currentRoute, ['general' => 'An error occurred. ' . $doesAccountExists['errorMessage']], $formData, $addressFormData);
    }

    // Update booking with user ID
    $updatedBooking = $bookingController->updateBookingUser($bookingId, $userId);
    if (isset($updatedBooking['errorMessage']) && $updatedBooking['errorMessage']) {
      handleErrorAndRedirect($currentRoute, ['general' => 'An error occurred. ' . $updatedBooking['errorMessage']], $formData, $addressFormData);
    }

  } else {
    // Update booking with logged in user ID
    $updatedBooking = $bookingController->updateBookingUser($bookingId, $_SESSION['loggedInUser']['userId']);
    if (isset($updatedBooking['errorMessage']) && $updatedBooking['errorMessage']) {
      handleErrorAndRedirect($currentRoute, ['general' => 'An error occurred. ' . $updatedBooking['errorMessage']], $formData, $addressFormData);
    }
  }

  // Address handling
  $doesAddressExists = $addressController->doesAddressExist($addressFormData);
  $addressId = null;
  // If address already exists
  if ($doesAddressExists > 0) {
    $addressId = $doesAddressExists;
  } 
  // If address does not exist yet
  else if ($doesAddressExists === 0) {
    $newAddressId = $addressController->createAddress($addressFormData);
    if (isset($newAddressId['errorMessage']) && $newAddressId['errorMessage'] || isset($newAddressId['validationError']) && $newAddressId['validationError']) {
      header("Location: " . $currentRoute);
      exit;
    }
    $addressId = $newAddressId;
  } 
  // If an error occurred
  else if (is_array($doesAddressExists) && isset($doesAddressExists['errorMessage'])) {
    handleErrorAndRedirect($currentRoute, ['addressGeneral' => 'An error occurred. ' . $doesAddressExists['errorMessage']], $formData, $addressFormData);
  }
  
  handlePayment($_SESSION['loggedInUser']['userEmail'] ?? $formData['email'] , $bookingId, $addressId, $formData, $addressFormData, $currentRoute); 
}

/* Stripe Handling */
function handlePayment(string $userEmail, int $bookingId, int $addressId, array $formData, array $addressFormData, string $currentRoute) {
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
    'addressId' => $addressId,
    'bookingId' => $bookingId,
  ];

  try {
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
              "description" => $showing->getShowingDate()->format('Y-m-d') . " | " . $showing->getShowingTime()->format('H:i') . " | " . $venue->getName()
          ]
        ]
      ];
    }

    $checkout_session = \Stripe\Checkout\Session::create([
      "mode" => "payment",
      // Localhost URLs for testing
      /* "success_url" => "http://localhost/dwp/booking/checkout_success",
      "cancel_url" => "http://localhost/dwp/home", */
      // Production URLs
      "success_url" => "https://spicypisces.eu/booking/checkout_success",
      "cancel_url" => "https://spicypisces.eu",
      "expires_at" => time() + 1800, // Custom expiration time 30 minutes (minimum)
      "customer_email" => $userEmail,
      "line_items" => $lineItems
  ]);

    $paymentData['checkoutSessionId'] = htmlspecialchars($checkout_session->id);
    $paymentData['currency'] = htmlspecialchars($checkout_session->currency);
    $paymentData['paymentMethod'] = htmlspecialchars($checkout_session->payment_method_types[0]);
    
    $payment = $paymentController->addPayment($paymentData);
    
    if(isset($payment['errorMessage']) && $payment['errorMessage']) {
      handleErrorAndRedirect($currentRoute, ['addressGeneral' => 'An error occurred. ' . $payment['errorMessage']], $formData, $addressFormData);
    } 
    else {
      $_SESSION['checkoutSession'] = [
        'id' => $checkout_session->id,
        'url' => $checkout_session->url
      ];
      // 303 See Other status code, so the form doesn't get resubmitted for example on refresh or when going back to the page
      http_response_code(303);
      header("Location: " . $checkout_session->url);
    }
  } catch (\Stripe\Exception\ApiErrorException $e) {
    // Handle Stripe API errors
    echo 'Stripe error: ' . $e->getMessage();
  }
}

// Redirect with errors and form data
function handleErrorAndRedirect(string $route, array $errors, array $formData = [], array $addressFormData): void {
  $_SESSION['paymentErrors'] = $errors;
  if (count($formData) > 0) {
    $_SESSION['guestFormData'] = $formData;
  }
  $_SESSION['addressFormData'] = $addressFormData;
  header("Location: " . $route);
  exit;
}
