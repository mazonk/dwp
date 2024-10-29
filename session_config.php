<?php
require_once "src/controller/VenueController.php";

session_start();

$venueController = new VenueController();
$_SESSION['baseRoute'] = $_SERVER['HTTP_HOST'] == 'localhost' ? '/dwp' : '/';
$initialVenue = $venueController->getVenueById(1);
$_SESSION['selectedVenueId'] ? '' : $venueController->selectVenue($initialVenue);

// Time interval for id regeneration
$interval = 30 * 60; 

// Check if the user is logged in
if (isset($_SESSION['userId'])) { 
    // If session regeneration timestamp doesn't exist or the interval has passed
    if (!isset($_SESSION['lastRegeneration']) || time() - $_SESSION['lastRegeneration'] >= $interval) {
        regenerate_session_id_loggedin(); // Regenerate for logged-in users
    }
} else {
    // If user is not logged in, handle session regeneration similarly
    if (!isset($_SESSION['lastRegeneration']) || time() - $_SESSION['lastRegeneration'] >= $interval) {
        regenerate_session_id(); // Regenerate for guests
    }
}

// Functions
function isLoggedIn() {
    return isset($_SESSION['userId']);
}

function confirm_logged_in() {
    if (!isLoggedIn()) {
        header("Location: " . $_SESSION['baseRoute'] . "/login");
        exit;
    }
}

function regenerate_session_id() {
    // Regenerate the session ID
    session_regenerate_id(true);
    $_SESSION['lastRegeneration'] = time();
}

function regenerate_session_id_loggedin() {
    // Regenerate the session ID
    session_regenerate_id(true);
    
    // Append the user ID to a custom session key
    $_SESSION['session_userId'] = session_id() . "_" . $_SESSION['userId'];
    $_SESSION['lastRegeneration'] = time();
}
