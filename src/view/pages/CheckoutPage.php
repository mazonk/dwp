<?php
require_once 'session_config.php';
include_once 'src/controller/ShowingController.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
</head>

<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] bg-bgDark text-textLight">
    <?php include_once("src/view/components/Navbar.php"); ?>
    <main class="mt-[56px] p-4">
        <div class="max-w-2xl p-6 shadow-lg rounded">
            <h2 class="text-3xl font-bold mb-4">Booking Overview</h2>

            <div class="mb-4">
                <button onclick="cancelBooking()" class="py-2 px-4 text-red-500 border border-red-500 rounded hover:bg-red-500 hover:text-white duration-200">Cancel Booking</button>
            </div>

            <div class="mb-4">
                <?php
                // Get booking details from session
                $booking = $_SESSION['activeBooking'];

                // Get showing details from the showing service
                $showingController = new ShowingController();
                $showing = $showingController->getShowingById($booking['showingId'], $_SESSION['selectedVenueId']);
                $movie = $showing->getMovie();
                ?>
                <p class="font-bold text-xl"><?php echo $movie->getTitle(); ?></p>
                <a>
                    <img class="w-full h-[18.75rem] rounded-[0.625rem] m-[0.625rem] bg-center bg-cover" 
                    src="src/assets/<?php echo $movie->getPosterURL(); ?>" alt="Movie Poster">
                </a>
                <p><strong>Venue:</strong> Venue Name</p>
                <p><strong>Showing Date:</strong> Showing Date</p>
                <p><strong>Showing Time:</strong> Showing Time</p>
                <p><strong>Room Number:</strong> Room Number</p>
                <p><strong>Selected Seats:</strong> Row 5, Seat 12; Row 5, Seat 13</p>
            </div>

            <div class="mb-4">
                <p><strong>Ticket Types and Total Price:</strong></p>
                <ul>
                    <li>Adult: 2 x $12</li>
                    <li>Child: 1 x $8</li>
                </ul>
                <p><strong>Total Price:</strong> $32</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-bold">User Details</h3>
                <?php if (!isset($_SESSION['loggedIn'])): ?>
                    <p>You are not logged in.</p>
                    <a href="login.php" class="text-blue-500 underline">Log in</a> or
                    <button onclick="showGuestForm()" class="text-blue-500 underline">Continue as Guest</button>

                    <div id="guest-form" class="hidden mt-4">
                        <input type="text" placeholder="Name" class="block w-full p-2 mb-2 border rounded">
                        <input type="email" placeholder="Email" class="block w-full p-2 mb-2 border rounded">
                        <input type="date" placeholder="Date of Birth" class="block w-full p-2 mb-2 border rounded">
                    </div>
                <?php else: ?>
                    <p>Logged in as: <?php echo $_SESSION['userName']; ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> I agree with the terms and conditions
                </label>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2"> Receive invoice by email (optional)
                </label>
            </div>

            <div>
                <button onclick="proceedToPayment()" class="w-full py-3 bg-blue-500 text-white rounded hover:bg-blue-600 duration-200">Go to Payment</button>
            </div>

            <div class="mt-4">
                <h3 class="text-lg font-bold">Payment Options</h3>
                <img src="../src/assets/stripe-logo.png" alt="Stripe" class="w-24">
            </div>
        </div>
    </main>
</body>

</html>

<script>
    function cancelBooking() {
        window.history.back();
    }

    function showGuestForm() {
        document.getElementById('guest-form').classList.remove('hidden');
    }

    function proceedToPayment() {
        // Validation logic here
        alert('Proceeding to payment...');
        // Redirect to payment gateway
    }
</script>