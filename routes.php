<?php
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/error.log'); // Log errors to 'error.log' in the current directory

require_once __DIR__.'/router.php';

$baseRoute = $_SERVER['HTTP_HOST'] == 'localhost' ? '/dwp/' : '/';

// To be extended later with additional simple getter routes
// As well as post, put, and delete routes.
// TODO: Admin routes
// TODO: Development/production routes
// TODO: Add more routes

#############################################################################

// Global middleware to check for 'contact' action

// GET ROUTES

// In the URL -> http://localhost/dwp
// The output -> index.php (from pages folder)
get($baseRoute.'home', 'src/view/pages/LandingPage.php');
get($baseRoute, 'src/view/pages/LandingPage.php');

// In the URL -> http://localhost/dwp/about
// The output -> AboutPage.php (from pages folder)
get($baseRoute.'about', 'src/view/pages/AboutPage.php');

// In the URL -> http://localhost/dwp/admin
// The output -> AdminPage.php (from pages folder)
get($baseRoute.'admin', 'src/view/pages/AdminPage.php');

// In the URL -> http://localhost/dwp/movies
// The output -> AllMoviesPage.php (from pages folder)
get($baseRoute.'movies', 'src/view/pages/AllMoviesPage.php');

// In the URL -> http://localhost/dwp/booking
// The output -> BookingPage.php (from pages folder)
get($baseRoute.'booking', 'src/view/pages/BookingPage.php');

// In the URL -> http://localhost/dwp/booking/checkout
// The output -> CheckoutPage.php (from pages folder)
get($baseRoute.'booking/checkout', 'src/view/pages/CheckoutPage.php');

// In the URL -> http://localhost/dwp/booking/checkout_success
// The output -> CheckoutSuccess.php (from third-party folder)
get($baseRoute.'booking/checkout_success', 'src/view/pages/CheckoutSuccess.php');

// In the URL -> http://localhost/dwp/login
// The output -> LoginPage.php (from pages folder)
get($baseRoute.'login', 'src/view/pages/LoginPage.php');

// In the URL -> http://localhost/dwp/register
// The output -> RegisterPage.php (from pages folder)
get($baseRoute.'register', 'src/view/pages/RegisterPage.php');

// In the URL -> http://localhost/dwp/profile
// The output -> ProfilePage.php (from pages folder)
get($baseRoute.'profile', 'src/view/pages/ProfilePage.php');

// In the URL -> http://localhost/dwp/schedule
// The output -> SchedulePage.php (from pages folder)
get($baseRoute.'schedule', 'src/view/pages/SchedulePage.php');

// In the URL -> http://localhost/dwp/upcoming
// The output -> UpcomingMoviesPage.php (from pages folder)
get($baseRoute.'upcoming', 'src/view/pages/UpcomingMoviesPage.php');

// This could be 404 not found page
// any('/404','views/404.php');

#############################################################################

// POST ROUTES

post($baseRoute.'movies', 'src/view/pages/AllMoviesPage.php'); // used at toggle dropdown
post($baseRoute.'upcoming', 'src/view/pages/AllMoviesPage.php'); // used at toggle dropdown
post($baseRoute.'home', 'src/view/pages/LandingPage.php'); // used at toggle dropdown
post($baseRoute.'booking', 'src/view/pages/BookingPage.php');
post($baseRoute.'about', 'src/view/pages/AboutPage.php'); // used at toggle dropdown
post($baseRoute.'profile', 'src/view/pages/ProfilePage.php'); // used at toggle dropdown
post($baseRoute.'booking/checkout', 'src/view/pages/CheckoutPage.php'); // used at toggle dropdown
post($baseRoute.'booking/charge', 'third-party/charge.php'); // used at stripe payment
post($baseRoute.'stripe-webhook', 'stripe_webhook.php'); // used at stripe webhook

// Post route for register
post($baseRoute.'register', function() {
    require_once 'src/controller/AuthController.php';
    $authController = new AuthController();
    
    // Check the action parameter
    if (isset($_GET['action']) && $_GET['action'] === 'register') {
        $authController->register();
    }
});

// Post route for login
post($baseRoute.'login', function() {
    require_once 'src/controller/AuthController.php';
    $authController = new AuthController();
    
    // Check the action parameter
    if (isset($_GET['action']) && $_GET['action'] === 'login') {
        $authController->login();
    }
});

// Post route for logout
post($baseRoute.'logout', function() {
    require_once 'session_config.php';
    require_once 'src/controller/BookingController.php';
    require_once 'src/controller/PaymentController.php';
    require_once 'src/controller/AuthController.php';
    $authController = new AuthController();
    $bookingController = new BookingController();

    if (isset($_SESSION['checkoutSession']) && $_SESSION['checkoutSession'] && isset($_SESSION['activeBooking']) && $_SESSION['activeBooking']) {
        $paymentController = new PaymentController();
        $paymentIds = $paymentController->getIdsByCheckoutSessionId($_SESSION['checkoutSession']['id']);

        $paymentResult = $paymentController->rollbackPayment($paymentIds['paymentId'], $_SESSION['activeBooking']['id'], $_SESSION['activeBooking']['ticketIds']);

        if ($paymentResult['success']) {
            $authController->logout();
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => $paymentResult['errorMessage']]);
        }
    } else if (isset($_SESSION['activeBooking']) && $_SESSION['activeBooking']) {
        $bookingResult = $bookingController->rollBackBooking($_SESSION['activeBooking']['id'], $_SESSION['activeBooking']['ticketIds']);
    
        if ($bookingResult['success']) {
            $authController->logout();
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => $bookingResult['errorMessage']]);
        }
    } else {
        $authController->logout();
    }
});    

// Post route for mail contact
post($baseRoute.'mail', function() {
    // Checking for contact action in the URL
    if (isset($_GET['action']) && $_GET['action'] === 'contact') {
        require_once 'src/controller/ContactFormController.php';
        $contactFormController = new ContactFormController();

        $contactFormController->sendMail();
    }
});

// Query string routes
get($baseRoute.'movies/$id', 'src/view/pages/MovieDetailsPage.php');
get($baseRoute.'news/$id', 'src/view/pages/NewsPage.php');

//put routes
put($baseRoute.'venue/edit', function() {
    require_once 'src/controller/VenueController.php';
    $venueController = new VenueController();
    parse_str(file_get_contents("php://input"), $_PUT);

    if (isset($_PUT['action']) && $_PUT['action'] === 'editVenue') {
        $venueId = htmlspecialchars($_PUT['venueId']);
        $venueData = [
            'name' => htmlspecialchars(trim($_PUT['name'])),
            'phoneNr' => htmlspecialchars(trim($_PUT['phoneNr'])),
            'email' => htmlspecialchars(trim($_PUT['email'])),
            'street' => htmlspecialchars(trim($_PUT['street'])),
            'streetNr' => htmlspecialchars(trim($_PUT['streetNr'])),
            'postalCode' => htmlspecialchars(trim($_PUT['postalCode'])),
            'city' => htmlspecialchars(trim($_PUT['city'])),
            'addressId' => htmlspecialchars(trim($_PUT['addressId'])),
            'postalCodeId' => htmlspecialchars(trim($_PUT['postalCodeId'])),
        ];

        $result = $venueController->editVenue($venueId, $venueData);

        if ($result && !is_array($result)) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => $result['errorMessage']]);
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

put($baseRoute.'companyInfo/edit', function() {
    require_once 'src/controller/CompanyInfoController.php';
    $companyController = new CompanyInfoController();
    parse_str(file_get_contents("php://input"), $_PUT);

    if (isset($_PUT['action']) && $_PUT['action'] === 'editCompanyInfo') {
        $companyId = htmlspecialchars($_PUT['companyId']);
        $companyData = [
            'companyName' => htmlspecialchars(trim($_PUT['companyName'])),
            'companyDescription' => htmlspecialchars(trim($_PUT['companyDescription'])),
            'streetNr' => htmlspecialchars(trim($_PUT['streetNr'])),
            'street' => htmlspecialchars(trim($_PUT['street'])),
            'postalCode' => htmlspecialchars(trim($_PUT['postalCode'])),
            'city' => htmlspecialchars(trim($_PUT['city'])),
            'addressId' => htmlspecialchars(trim($_PUT['addressId'])),
            'postalCodeId' => htmlspecialchars(trim($_PUT['postalCodeId'])),
            'logoUrl' => htmlspecialchars($_PUT['logoUrl']),
        ];        

        $result = $companyController->editCompanyInfo($companyId, $companyData);

        if ($result && !is_array($result)) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => $result['errorMessage']]);
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

put($baseRoute.'profile/edit', function() {
    require_once 'src/controller/UserController.php';
    $userController = new UserController();
    parse_str(file_get_contents("php://input"), $_PUT);

    if (isset($_PUT['action']) && $_PUT['action'] === 'updateProfileInfo') {
        $userId = htmlspecialchars($_PUT['userId']);
        $newProfileInfo = [
            'firstName' => htmlspecialchars(trim($_PUT['firstName'])),
            'lastName' => htmlspecialchars(trim($_PUT['lastName'])),
            'dob' => htmlspecialchars(trim($_PUT['dob'])),
            'email' => htmlspecialchars(trim($_PUT['email'])),
        ];

        $result = $userController->updateProfileInfo($userId, $newProfileInfo);

        if ($result && !is_array($result)) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => $result['errorMessage']]);
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

require_once 'src/controller/NewsController.php';
// Add news post route
post($baseRoute.'news/add', function() {
    $newsController = new NewsController();

    if (isset($_POST['action']) && $_POST['action'] === 'addNews') {
        $newsData = [
            'header' => htmlspecialchars(trim($_POST['header'])),
            'imageURL' => htmlspecialchars(trim($_POST['imageURL'])),
            'content' => htmlspecialchars(trim($_POST['content'])),
        ];

        $result = $newsController->addNews($newsData);

        if (isset($result['success']) && $result['success'] === true) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else if (isset($result['errorMessage'])) {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        } else {
            if (is_array($result)) {
                // Sanitize the array of errors
                $sanitizedErrors = array_map(function($error) {
                    return htmlspecialchars($error);
                }, $result);

                echo json_encode(['success' => false, 'errors' => $sanitizedErrors]);
            } else {
                // Return a single error response
                echo json_encode(['success' => false, 'errors' => htmlspecialchars($result)]);
            }
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

// Post route for booking
post($baseRoute.'booking/overview', function() {
    require_once 'src/controller/BookingController.php';
    require_once 'src/controller/TicketController.php';
    require_once 'session_config.php';
    $bookingController = new BookingController();
    $ticketController = new TicketController();
    
    if (isset($_SESSION['activeBooking'])) {
        unset($_SESSION['activeBooking']);
    }
    if (isset($_SESSION['checkoutSession'])) {
        unset($_SESSION['checkoutSession']);
    }

    $createBookingResult = $bookingController->createEmptyBooking(isset($_SESSION['loggedInUser']) ? $_SESSION['loggedInUser']['userId'] : null, 'pending');
    $selectedSeatsArray = explode(',', htmlspecialchars($_POST['selectedSeats']));
    $ticketController->createTickets($selectedSeatsArray, 1, intval($_POST['showingId']), $createBookingResult);

    if ($createBookingResult && !is_array($createBookingResult)) {
        // Return a success response
        echo json_encode(['success' => $createBookingResult]);
    } else {
        // Return an error response
        echo json_encode(['success' => false, 'errorMessage' => $createBookingResult['errorMessage']]);
    }
});

post($baseRoute.'booking/rollback', function() {
    require_once 'session_config.php';
    require_once 'src/controller/BookingController.php';
    require_once 'src/controller/PaymentController.php';
    $bookingController = new BookingController();

    if (isset($_SESSION['checkoutSession']) && $_SESSION['checkoutSession']) {
        $paymentController = new PaymentController();
        $paymentIds = $paymentController->getIdsByCheckoutSessionId($_SESSION['checkoutSession']['id']);

        $paymentResult = $paymentController->rollbackPayment($paymentIds['paymentId'], $_SESSION['activeBooking']['id'], $_SESSION['activeBooking']['ticketIds']);

        if ($paymentResult['success']) {
            // Return a success response
            echo json_encode(['success' => true]);
            error_log('Payment rolled back successfully.');
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => $paymentResult['errorMessage']]);
            error_log('Payment rollback failed: ' . $paymentResult['errorMessage']);
        }
    } else {
        $bookingResult = $bookingController->rollBackBooking($_SESSION['activeBooking']['id'], $_SESSION['activeBooking']['ticketIds']);
    
        if ($bookingResult['success']) {
            // Return a success response
            echo json_encode(['success' => true]);
            error_log('Booking rolled back successfully.');
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => $bookingResult['errorMessage']]);
            error_log('Booking rollback failed: ' . $bookingResult['errorMessage']);
        }
    }
});

// Edit news put route
put($baseRoute.'news/edit', function() {
    $newsController = new NewsController();
    parse_str(file_get_contents("php://input"), $_PUT); // Parse the PUT request

    if (isset($_PUT['action']) && $_PUT['action'] === 'editNews') {
        $newsData = [
            'newsId' => htmlspecialchars(trim($_PUT['newsId'])),
            'header' => htmlspecialchars(trim($_PUT['header'])),
            'imageURL' => htmlspecialchars(trim($_PUT['imageURL'])),
            'content' => htmlspecialchars(trim($_PUT['content'])),
        ];

        $result = $newsController->editNews($newsData);

        if (isset($result['success']) && $result['success'] === true) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else if (isset($result['errorMessage'])) {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        } else {
            if (is_array($result)) {
                // Sanitize the array of errors
                $sanitizedErrors = array_map(function($error) {
                    return htmlspecialchars($error);
                }, $result);

                echo json_encode(['success' => false, 'errors' => $sanitizedErrors]);
            } else {
                // Return a single error response
                echo json_encode(['success' => false, 'errors' => htmlspecialchars($result)]);
            }
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

// Delete news delete route
delete($baseRoute.'news/delete', function() {
    $newsController = new NewsController();

    if (isset($_GET['action']) && $_GET['action'] === 'deleteNews') {
        $newsId = htmlspecialchars(trim($_GET['newsId']));

        $result = $newsController->deleteNews($newsId);

        if (isset($result['success']) && $result['success'] === true) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

require_once 'src/controller/OpeningHourController.php';
// Add opening hour post route
post($baseRoute.'openingHours/add', function() {
    $openingHourController = new OpeningHourController();

    if (isset($_POST['action']) && $_POST['action'] === 'addOpeningHour') {
        $openingHourData = [
            'day' => htmlspecialchars(trim($_POST['day'])),
            'openingTime' => htmlspecialchars(trim($_POST['openingTime'])),
            'closingTime' => htmlspecialchars(trim($_POST['closingTime'])),
            'isCurrent' => htmlspecialchars(trim($_POST['isCurrent']))
        ];

        $result = $openingHourController->addOpeningHour($openingHourData);

        if (isset($result['success']) && $result['success'] === true) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else if (isset($result['errorMessage'])) {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        } else {
            if (is_array($result)) {
                // Sanitize the array of errors
                $sanitizedErrors = array_map(function($error) {
                    return htmlspecialchars($error);
                }, $result);

                echo json_encode(['success' => false, 'errors' => $sanitizedErrors]);
            } else {
                // Return a single error response
                echo json_encode(['success' => false, 'errors' => htmlspecialchars($result)]);
            }
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

put($baseRoute.'openingHours/edit', function() {
    $openingHourController = new OpeningHourController();
    parse_str(file_get_contents("php://input"), $_PUT); // Parse the PUT request

    if (isset($_PUT['action']) && $_PUT['action'] === 'editOpeningHour') {
        $openingHourData = [
            'openingHourId' => htmlspecialchars(trim($_PUT['openingHourId'])),
            'day' => htmlspecialchars(trim($_PUT['day'])),
            'openingTime' => htmlspecialchars(trim($_PUT['openingTime'])),
            'closingTime' => htmlspecialchars(trim($_PUT['closingTime'])),
            'isCurrent' => htmlspecialchars(trim($_PUT['isCurrent']))
        ];

        $result = $openingHourController->editOpeningHour($openingHourData);

        if (isset($result['success']) && $result['success'] === true) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else if (isset($result['errorMessage'])) {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        } else {
            if (is_array($result)) {
                // Sanitize the array of errors
                $sanitizedErrors = array_map(function($error) {
                    return htmlspecialchars($error);
                }, $result);

                echo json_encode(['success' => false, 'errors' => $sanitizedErrors]);
            } else {
                // Return a single error response
                echo json_encode(['success' => false, 'errors' => htmlspecialchars($result)]);
            }
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

// Delete opening hour delete route
delete($baseRoute.'openingHours/delete', function() {
    $openingHourController = new OpeningHourController();

    if (isset($_GET['action']) && $_GET['action'] === 'deleteOpeningHour') {
       $openingHourId = htmlspecialchars(trim($_GET['openingHourId']));
       
       $result = $openingHourController->deleteOpeningHour($openingHourId);

       if (isset($result['success']) && $result['success'] === true) {
           // Return a success response
           echo json_encode(['success' => true]);
       } else {
           // Return an error response
           echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
       }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

// Add movie post route
post($baseRoute . 'movies/add', function() {
    require_once 'src/controller/MovieController.php';
    $movieController = new MovieController();

    if (isset($_POST['action']) && $_POST['action'] === 'addMovie') {
        // Sanitize and collect the movie data
        $movieData = [
            'title' => htmlspecialchars(trim($_POST['title'])),
            'releaseDate' => htmlspecialchars(trim($_POST['releaseDate'])),
            'duration' => htmlspecialchars(trim($_POST['duration'])),
            'language' => htmlspecialchars(trim($_POST['language'])),
            'description' => htmlspecialchars(trim($_POST['description'])),
            'posterURL' => htmlspecialchars(trim($_POST['posterUrl'])),
            'promoURL' => htmlspecialchars(trim($_POST['promoUrl'])),
            'trailerURL' => htmlspecialchars(trim($_POST['trailerUrl'])),
            'rating' => htmlspecialchars(trim($_POST['rating']))
        ];

        // Add selected genres
        $selectedGenres = isset($_POST['selectedGenres']) ? array_map('intval', $_POST['selectedGenres']) : [];

        // Add the movie
        $result = $movieController->addMovie($movieData);

        // If the movie was added successfully
        if (isset($result['success']) && $result['success'] === true) {
            // Assuming the movieController should return a movieId if successful
            $movieId = isset($result['movieId']) ? $result['movieId'] : null;

            // If a movie ID was returned, proceed to add genres
            if ($movieId && !empty($selectedGenres)) {
                // Call addGenresToMovie with the movieId and selected genres
                $genreResult = $movieController->addGenresToMovie($movieId, $selectedGenres);

                if (isset($genreResult['error'])) {
                    // Handle any error in adding genres
                    echo json_encode(['success' => true, 'warning' => $genreResult['message']]);
                    return;
                }
            }
            // Return a success response if movie and genres were added
            echo json_encode(['success' => true]);
        } else if (isset($result['errorMessage'])) {
            // Return an error response if movie adding failed
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        } else {
            // Handle any errors from the `addMovie` method
            if (is_array($result)) {
                // Sanitize the array of errors
                $sanitizedErrors = array_map(function($error) {
                    return htmlspecialchars($error);
                }, $result);

                echo json_encode(['success' => false, 'errors' => $sanitizedErrors]);
            } else {
                // Return a single error response
                echo json_encode(['success' => false, 'errors' => htmlspecialchars($result)]);
            }
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

// Edit movie route
put($baseRoute . 'movies/edit', function() {
    require_once 'src/controller/MovieController.php';
    $movieController = new MovieController();
    parse_str(file_get_contents("php://input"), $_PUT); // Parse the PUT request

    if (isset($_PUT['action']) && $_PUT['action'] === 'editMovie') {
        $movieData = [
            'title' => htmlspecialchars(trim($_PUT['title'])),
            'releaseDate' => htmlspecialchars(trim($_PUT['releaseDate'])),
            'duration' => htmlspecialchars($_PUT['duration']),
            'language' => htmlspecialchars(trim($_PUT['language'])),
            'description' => htmlspecialchars(trim($_PUT['description'])),
            'posterURL' => htmlspecialchars(trim($_PUT['posterURL'])),
            'promoURL' => htmlspecialchars(trim($_PUT['promoURL'])),
            'trailerURL' => htmlspecialchars(trim($_PUT['trailerURL'])),
            'rating' => htmlspecialchars($_PUT['rating']),
            'movieId' => htmlspecialchars($_PUT['movieId'])
        ];

        $result = $movieController->editMovie($movieData);

        if (isset($result['success']) && $result['success'] === true) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else if (isset($result['errorMessage'])) {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        } else {
            if (is_array($result)) {
                // Sanitize the array of errors
                $sanitizedErrors = array_map(function($error) {
                    return htmlspecialchars($error);
                }, $result);

                echo json_encode(['success' => false, 'errors' => $sanitizedErrors]);
            } else {
                // Return a single error response
                echo json_encode(['success' => false, 'errors' => htmlspecialchars($result)]);
            }
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

// Delete movie route
delete($baseRoute . 'movies/delete', function() {
    require_once 'src/controller/MovieController.php';
    $movieController = new MovieController();

    if (isset($_GET['action']) && $_GET['action'] === 'deleteMovie') {
        $movieId = htmlspecialchars(trim($_GET['movieId']));

        $result = $movieController->deleteMovie($movieId);

        if (isset($result['success']) && $result['success'] === true) {
            // Return a success response
            echo json_encode(['success' => "true"]);
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid action.']);
    }
});

// Archive movie route
put($baseRoute . 'movies/archive', function() {
    require_once 'src/controller/MovieController.php';
    $movieController = new MovieController();
    parse_str(file_get_contents("php://input"), $_PUT); // Parse the PUT request


    if (isset($_PUT['movieId'])) {
        $movieId = htmlspecialchars(trim($_PUT['movieId']));

        $result = $movieController->archiveMovie($movieId);

        if (isset($result['success']) && $result['success'] === true) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        }
    } else {
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid movie ID.' . $_PUT['movieId']]);
    }
});

// Post route for image upload
post($baseRoute.'upload-image', function() {
    require_once 'src/controller/ImageUploadController.php';
    $imageUploadController = new ImageUploadController();
    $file = $_FILES['file'];
    $result = $imageUploadController->uploadImage($file);

    if (isset($result['successMessage'])) {
        echo json_encode(['success' => $result['successMessage']]);
    } else {
        echo json_encode(['failure' => $result['errorMessage']]);
    }
});

// Archive movie route
put($baseRoute . 'movies/restore', function() {
    require_once 'src/controller/MovieController.php';
    $movieController = new MovieController();
    parse_str(file_get_contents("php://input"), $_PUT); // Parse the PUT request


    if (isset($_PUT['movieId'])) {
        $movieId = htmlspecialchars(trim($_PUT['movieId']));

        $result = $movieController->restoreMovie($movieId);

        if (isset($result['success']) && $result['success'] === true) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'errorMessage' => htmlspecialchars($result['errorMessage'])]);
        }
    } else {
        echo json_encode(['success' => false, 'errorMessage' => 'Invalid movie ID.' . $_PUT['movieId']]);
    }
});


