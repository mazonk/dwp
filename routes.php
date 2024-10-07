<?php

require_once __DIR__.'/router.php';

// To be extended later with additional simple getter routes
// As well as post, put, and delete routes.
// TODO: Add more routes

// Simple getters

// In the URL -> http://localhost/dwp
// The output -> index.php (from pages folder)
get('/dwp', 'src/presentation_layer/pages/LandingPage.php');

// In the URL -> http://localhost/dwp/about
// The output -> AboutPage.php (from pages folder)
get('/dwp/about', 'src/presentation_layer/pages/AboutPage.php');

// In the URL -> http://localhost/dwp/admin
// The output -> AdminPage.php (from pages folder)
get('/dwp/admin', 'src/presentation_layer/pages/AdminPage.php');

// In the URL -> http://localhost/dwp/movies
// The output -> AllMoviesPage.php (from pages folder)
get('/dwp/movies', 'src/presentation_layer/pages/AllMoviesPage.php');

// In the URL -> http://localhost/dwp/movies/1
// The output -> MovieDetailsPage.php and its query string id = 1 for example (from pages folder)
get('/dwp/movies/$id', 'src/presentation_layer/pages/MovieDetailsPage.php');

// In the URL -> http://localhost/dwp/booking
// The output -> BookingPage.php (from pages folder)
get('/dwp/booking', 'src/presentation_layer/pages/BookingPage.php');

// In the URL -> http://localhost/dwp/booking/checkout
// The output -> CheckoutPage.php (from pages folder)
get('/dwp/booking/checkout', 'src/presentation_layer/pages/CheckoutPage.php');

// In the URL -> http://localhost/dwp/login
// The output -> LoginPage.php (from pages folder)
get('/dwp/login', 'src/presentation_layer/pages/LoginPage.php');

// In the URL -> http://localhost/dwp/profile
// The output -> ProfilePage.php (from pages folder)
get('/dwp/profile', 'src/presentation_layer/pages/ProfilePage.php');

// In the URL -> http://localhost/dwp/schedule
// The output -> SchedulePage.php (from pages folder)
get('/dwp/schedule', 'src/presentation_layer/pages/SchedulePage.php');

// In the URL -> http://localhost/dwp/upcoming
// The output -> UpcomingMoviesPage.php (from pages folder)
get('/dwp/upcoming', 'src/presentation_layer/pages/UpcomingMoviesPage.php');

// This could be 404 not found page
// any('/404','views/404.php');
