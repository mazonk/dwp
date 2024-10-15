<?php

require_once __DIR__.'/router.php';

// To be extended later with additional simple getter routes
// As well as post, put, and delete routes.
// TODO: Admin routes
// TODO: Development/production routes
// TODO: Add more routes

#############################################################################

// GET ROUTES

// In the URL -> http://localhost/dwp
// The output -> index.php (from pages folder)
get('/dwp', 'src/view/pages/LandingPage.php');
post('/dwp', 'src/view/pages/LandingPage.php'); // used at toggle dropdown

// In the URL -> http://localhost/dwp/about
// The output -> AboutPage.php (from pages folder)
get('/dwp/about', 'src/view/pages/AboutPage.php');

// In the URL -> http://localhost/dwp/admin
// The output -> AdminPage.php (from pages folder)
get('/dwp/admin', 'src/view/pages/AdminPage.php');

// In the URL -> http://localhost/dwp/movies
// The output -> AllMoviesPage.php (from pages folder)
get('/dwp/movies', 'src/view/pages/AllMoviesPage.php');
post('/dwp/movies', 'src/view/pages/AllMoviesPage.php'); // used at toggle dropdown

// In the URL -> http://localhost/dwp/movies/1
// The output -> MovieDetailsPage.php and its query string id = 1 for example (from pages folder)
get('/dwp/movies/$id', 'src/view/pages/MovieDetailsPage.php');

// In the URL -> http://localhost/dwp/booking
// The output -> BookingPage.php (from pages folder)
get('/dwp/booking', 'src/view/pages/BookingPage.php');

// In the URL -> http://localhost/dwp/booking/checkout
// The output -> CheckoutPage.php (from pages folder)
get('/dwp/booking/checkout', 'src/view/pages/CheckoutPage.php');

// In the URL -> http://localhost/dwp/login
// The output -> LoginPage.php (from pages folder)
get('/dwp/login', 'src/view/pages/LoginPage.php');

// In the URL -> http://localhost/dwp/register
// The output -> RegisterPage.php (from pages folder)
get('/dwp/register', 'src/view/pages/RegisterPage.php');

// In the URL -> http://localhost/dwp/profile
// The output -> ProfilePage.php (from pages folder)
get('/dwp/profile', 'src/view/pages/ProfilePage.php');

// In the URL -> http://localhost/dwp/schedule
// The output -> SchedulePage.php (from pages folder)
get('/dwp/schedule', 'src/view/pages/SchedulePage.php');

// In the URL -> http://localhost/dwp/upcoming
// The output -> UpcomingMoviesPage.php (from pages folder)
get('/dwp/upcoming', 'src/view/pages/UpcomingMoviesPage.php');

// This could be 404 not found page
// any('/404','views/404.php');

#############################################################################

// POST ROUTES

// Post route for register
post('/dwp/register', function() {
    require_once 'src/controller/AuthController.php';
    $authController = new AuthController();
    
    // Check the action parameter
    if (isset($_GET['action']) && $_GET['action'] === 'register') {
        $authController->register();
    }
});

// Post route for login
post('/dwp/login', function() {
    require_once 'src/controller/AuthController.php';
    $authController = new AuthController();
    
    // Check the action parameter
    if (isset($_GET['action']) && $_GET['action'] === 'login') {
        $authController->login();
    }
});

post('/dwp/logout', function() {
    require_once 'src/controller/AuthController.php';
    $authController = new AuthController();
    $authController->logout();
});