<?php

require_once __DIR__.'/router.php';

// In the URL -> http://localhost/dwp
// The output -> index.php (from pages folder)
get('/dwp', 'src/presentation_layer/pages/LandingPage.php');
get('/dwp/about', 'src/presentation_layer/pages/AboutPage.php');
get('/dwp/admin', 'src/presentation_layer/pages/AdminPage.php');
get('/dwp/movies', 'src/presentation_layer/pages/AllMoviesPage.php');
get('/dwp/booking', 'src/presentation_layer/pages/BookingPage.php');
get('/dwp/booking/checkout', 'src/presentation_layer/pages/CheckoutPage.php');
get('/dwp/login', 'src/presentation_layer/pages/LoginPage.php');

get('/dwp/profile', 'src/presentation_layer/pages/ProfilePage.php');
get('/dwp/schedule', 'src/presentation_layer/pages/SchedulePage.php');
get('/dwp/upcoming', 'src/presentation_layer/pages/UpcomingMoviesPage.php');

// This could be 404 not found page
// any('/404','views/404.php');
