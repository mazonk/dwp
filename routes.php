<?php

require_once __DIR__.'/router.php';

$baseRoute = $_SERVER['HTTP_HOST'] == 'localhost' ? '/dwp/' : '/';

// To be extended later with additional simple getter routes
// As well as post, put, and delete routes.
// TODO: Admin routes
// TODO: Development/production routes
// TODO: Add more routes

#############################################################################

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

post($baseRoute.'logout', function() {
    require_once 'src/controller/AuthController.php';
    $authController = new AuthController();
    $authController->logout();
});

// Query string routes

get($baseRoute.'movies/$id', 'src/view/pages/MovieDetailsPage.php');
get($baseRoute.'news/$id', 'src/view/pages/NewsPage.php');

//put routes
// Assuming you have a router function for PUT requests
put($baseRoute.'venue/edit', function() {
    require_once 'src/controller/VenueController.php';
    $venueController = new VenueController();
    parse_str(file_get_contents("php://input"), $_PUT);

    if (isset($_PUT['action']) && $_PUT['action'] === 'editVenue') {
        $venueId = htmlspecialchars($_PUT['venueId']);
        $venueData = [
            'name' => htmlspecialchars($_PUT['name']),
            'phoneNr' => htmlspecialchars($_PUT['phoneNr']),
            'email' => htmlspecialchars($_PUT['email']),
            'street' => htmlspecialchars($_PUT['street']),
            'streetNr' => htmlspecialchars($_PUT['streetNr']),
            'postalCode' => htmlspecialchars($_PUT['postalCode']),
            'city' => htmlspecialchars($_PUT['city']),
            'addressId' => htmlspecialchars($_PUT['addressId']),
            'postalCodeId' => htmlspecialchars($_PUT['postalCodeId']),
        ];

        $result = $venueController->editVenue($venueId, $venueData);

        echo serialize($result);

        if ($result) {
            // Return a success response (you might want to send a JSON response)
            echo json_encode(['success' => true]);
        } else {
            // Return an error response
            echo json_encode(['success' => false, 'message' => 'Error updating venue.']);
        }
    } else {
        // Invalid action response
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    }
});
