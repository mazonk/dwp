<?php
require_once 'session_config.php';
include_once 'src/controller/ShowingController.php';
include_once 'src/controller/VenueController.php';
include_once 'src/controller/TicketController.php';

// Get booking details from session
if (!isset($_SESSION['activeBooking'])) {
    echo  'Start a booking to access this page!' . ' ' . '<a class="underline text-blue-300" href="javascript:window.history.back()"><-Go back!</a>';
    exit();
}
$booking = $_SESSION['activeBooking'];

// Get showing details from the showing service
$showingController = new ShowingController();
$venueController = new VenueController();
$ticketController = new TicketController();

$showing = $showingController->getShowingById($booking['showingId'], $_SESSION['selectedVenueId']);
$movie = $showing->getMovie();
$venue = $venueController->getVenueById($_SESSION['selectedVenueId']);
$tickets = [];

// Get selected seats from the booking
foreach ($booking['ticketIds'] as $ticketId) {
    $ticket = $ticketController->getTicketById($ticketId);
    $tickets[] = $ticket;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
    <title>Checkout</title>
</head>

<body class="max-w-[1440px] w-[100%] mx-auto mt-[72px] mb-[2rem] px-[100px] bg-bgDark text-textLight">
    <?php include_once("src/view/components/Navbar.php"); ?>
    <main class="mt-[56px] p-4">
    <div class="p-6 shadow-lg rounded-xl min-h-[60vh] bg-gray-800 text-white">

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-4xl font-bold  text-center">Booking Overview</h2>
        <div class="flex flex-row items-center space-x-4">
            <div id="timer" class="text-red-500 text-lg font-bold"></div>
            <button onclick="cancelBooking()" class="py-2 px-4 text-red-500 border border-red-500 rounded hover:bg-red-500 hover:text-white transition duration-200">
                Cancel Booking
            </button>
        </div>
    </div>

    <div class="flex gap-6 mb-6 justify-between">
        <img class="w-1/3 rounded-lg shadow-md" 
        src="<?php echo $_SESSION['baseRoute'] ?>src/assets/<?php echo $movie->getPosterURL(); ?>" alt="Movie Poster">
        
        <div class="space-y-4 flex-1">
            <h3 class="text-2xl font-bold"><?php echo $movie->getTitle(); ?></h3>
            <p><strong>Cinema: </strong><?php echo $venue->getName(); ?></p>
            <p><strong>Date: </strong><?php echo $showing->getShowingDate()->format('Y-m-d'); ?></p>
            <p><strong>Time: </strong><?php echo $showing->getShowingTime()->format('H:i'); ?></p>
            <p><strong>Room Number: </strong><?php echo $showing->getRoom()->getRoomNumber(); ?></p>
            <p><strong>Selected Seats: </strong>
                <?php foreach ($tickets as $ticket) {
                    $seat = $ticket->getSeat();
                    echo "<br>"."Row " . $seat->getRow() . " - Seat " . $seat->getSeatNr();
                } ?>
            </p>
            <button onclick="cancelBooking()" class="mt-2 py-1 px-3 bg-bgDark border border-primary text-white rounded hover:bg-bgSemiDark transition duration-200">
                I want different seats!
            </button>
        </div>
        <div class="mb-6 bg-gray-700 p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-2">Ticket Types and Total Price:</h3>
            <ul class="list-disc list-inside">
                <?php
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
                foreach ($ticketTypes as $ticketType) {
                    echo "<li>" . $ticketType['name'] . ": " . $ticketType['count'] . " x " . $ticketType['price'] . " $" . "</li>";
                }
                ?>
            </ul>
            <?php 
            $totalPrice = 0;
            foreach ($ticketTypes as $ticketType) {
                $totalPrice += $ticketType['count'] * $ticketType['price'];
            }
            ?>
            <p class="my-2"><strong>Total Price:</strong> $ <?php echo number_format($totalPrice, 2); ?></p>
            <hr>
            <div class="mb-6 bg-gray-700">
                <h3 class="text-lg font-bold mt-2">User Details</h3>
                <?php if (!isLoggedIn()): ?>
                    <p class="mt-2">You are not logged in.</p>
                    <a href="<?php echo $_SESSION['baseRoute'] ?>login?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="text-blue-400 underline">Log in</a> or
                    <button onclick="showGuestForm()" class="text-blue-400 underline">Continue as Guest</button>

                    <div id="guest-form" class="hidden mt-4">
                        <input type="text" placeholder="First name" class="block w-full p-2 mb-2 border rounded bg-gray-900">
                        <input type="text" placeholder="Last name" class="block w-full p-2 mb-2 border rounded bg-gray-900">
                        <input type="email" placeholder="Email" class="block w-full p-2 mb-2 border rounded bg-gray-900">
                        <input type="date" placeholder="Date of Birth" class="block w-full p-2 mb-2 border rounded bg-gray-900">
                    </div>
                <?php else: ?>
                    <p>Logged in as: <?php echo $_SESSION['loggedInUser']['firstName']. ' ' . $_SESSION['loggedInUser']['lastName']; ?></p>
                <?php endif; ?>
            </div>
            <div class="flex flex-col gap-4 mb-6">
        <label class="flex items-center">
            <input type="checkbox" class="mr-2"> <a class="text-red-500">*</a>&nbsp;I agree with the terms and conditions
        </label>
        <label class="flex items-center">
            <input type="checkbox" class="mr-2"> Receive invoice by email (optional)
        </label>
    </div>

    <div>
        <button onclick="proceedToPayment()" class="w-full py-1 border border-primary bg-bgDark hover:bg-bgSemiDark text-white rounded-lg transition duration-200 flex items-center justify-center">
            Pay with
            <img src="<?php echo $_SESSION['baseRoute'] ?>src/assets/stripe-logo.png" alt="Stripe" class="mx-2 mt-1 w-12">
        </button>
    </div>
        </div>
    </div>

    
</div>

    </main>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timerDisplay = document.getElementById('timer');
        let bookingExpiry = localStorage.getItem('bookingExpiry');

        if (!bookingExpiry) {
            bookingExpiry = Date.now() + 15 * 60 * 1000; // 15 minutes from now
            localStorage.setItem('bookingExpiry', bookingExpiry);
        }

        const interval = setInterval(() => {
            const timeLeft = Math.max(0, bookingExpiry - Date.now());
            const minutes = Math.floor(timeLeft / 60000);
            const seconds = Math.floor((timeLeft % 60000) / 1000);
            timerDisplay.textContent = `Time left: ${minutes}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                clearInterval(interval);
                alert('Your booking has expired!');

                rollbackBooking(true);
            }
        }, 1000);

        const allowedPaths = ['/login', '/booking/checkout'];

        // Intercept internal navigation (via clicks, history push)
        document.body.addEventListener('click', function (e) {
            if (e.target.tagName === 'A' && e.target.href) {
                const destination = new URL(e.target.href).pathname;
                handleNavigation(destination);
            }
        });

        window.addEventListener('popstate', function () {
            handleNavigation(window.location.pathname);
        });

        // Handle all other navigation attempts (address bar, refresh, tab close)
        window.addEventListener('beforeunload', function (e) {
            const destination = e.target.activeElement.href || ''; // Extract link, if present
            const isAllowed = allowedPaths.some(path => destination.includes(path));

            if (!isAllowed) {
                rollbackBooking(false);
            }
        });

        function handleNavigation(destination) {
            if (!allowedPaths.some(path => destination.includes(path))) {
                if (confirm('Leaving this page will cancel your booking. Are you sure you want to proceed?')) {
                    rollbackBooking(false);
                } else {
                    history.pushState(null, '', window.location.pathname);
                    e.preventDefault();
                }
            }
        }
    });
    function cancelBooking(redirectBack = true) {
        rollbackBooking(redirectBack);
    }

    function showGuestForm() {
        document.getElementById('guest-form').classList.remove('hidden');
    }

    function proceedToPayment() {
        // Validation logic here
        alert('Proceeding to payment...');
        // Redirect to payment gateway
    }

    function rollbackBooking(redirectBack) {
        localStorage.removeItem('bookingExpiry');

        const xhr = new XMLHttpRequest();
        const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';
        xhr.open('POST', `${baseRoute}booking/rollback`, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (redirectBack) {
                    history.back();
                }
            }
        };
        xhr.send();
    }
</script>
