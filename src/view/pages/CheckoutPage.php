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

// Get input values from the session if available
$guestFormData = isset($_SESSION['guestFormData']) ? $_SESSION['guestFormData'] : [
    'firstName' => '',
    'lastName' => '',
    'dob' => '',
    'email' => '',
];
$addressFormData = isset($_SESSION['addressFormData']) ? $_SESSION['addressFormData'] : [
    'street' => '',
    'streetNr' => '',
    'city' => '',
    'postalCode' => '',
];
$errors = isset($_SESSION['paymentErrors']) ? $_SESSION['paymentErrors'] : [];

unset($_SESSION['guestFormData']);
unset($_SESSION['paymentErrors']);
unset($_SESSION['addressFormData']);
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
                src="<?= htmlspecialchars($_SESSION['baseRoute']); ?>src/assets/<?= htmlspecialchars($movie->getPosterURL()); ?>" alt="Movie Poster">
                
                <div class="space-y-4 flex-1">
                    <h3 class="text-2xl font-bold"><?= htmlspecialchars($movie->getTitle()); ?></h3>
                    <p><strong>Cinema: </strong><?= htmlspecialchars($venue->getName()); ?></p>
                    <p><strong>Date: </strong><?= htmlspecialchars($showing->getShowingDate()->format('Y-m-d')); ?></p>
                    <p><strong>Time: </strong><?= htmlspecialchars($showing->getShowingTime()->format('H:i')); ?></p>
                    <p><strong>Room Number: </strong><?= htmlspecialchars($showing->getRoom()->getRoomNumber()); ?></p>
                    <p><strong>Selected Seats: </strong>
                        <?php foreach ($tickets as $ticket) {
                            $seat = $ticket->getSeat();
                            echo "<br>"."Row " . htmlspecialchars($seat->getRow() . " - Seat " . $seat->getSeatNr());
                        } ?>
                    </p>
                    <button onclick="cancelBooking()" class="mt-2 py-1 px-3 bg-bgDark border border-primary text-white rounded hover:bg-bgSemiDark transition duration-200">
                        I want different seats!
                    </button>
                </div>
                <div class="w-[400px] mb-6 bg-gray-700 p-4 rounded-lg shadow-md">
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
                            echo "<li>" . htmlspecialchars($ticketType['name'] . ": " . $ticketType['count'] . " x " . $ticketType['price'] . " $") . "</li>";
                        }
                        ?>
                    </ul>
                    <?php 
                    $totalPrice = 0;
                    foreach ($ticketTypes as $ticketType) {
                        $totalPrice += $ticketType['count'] * $ticketType['price'];
                    }
                    ?>
                    <p class="my-2"><strong>Total Price:</strong> $ <?= htmlspecialchars(number_format($totalPrice, 2)); ?></p>
                    <hr>
                    <form id="checkoutForm" action="charge" method="post">
                        <input type="hidden" name="route" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                        <div class="mb-6 bg-gray-700">
                            <h3 class="text-lg font-bold mt-2">User Details</h3>
                            <?php if (!isLoggedIn()): ?>
                            <p class="mt-2">You are not logged in.</p>
                            <a href="<?= htmlspecialchars($_SESSION['baseRoute']); ?>login?redirect=<?= htmlspecialchars(urlencode($_SERVER['REQUEST_URI'])); ?>" class="text-blue-400 underline">Log in</a> or
                            <button onclick="showGuestForm()" class="text-blue-400 underline">Continue as Guest</button>

                            <div id="guest-form" class="mt-4 <?= $guestFormData['email'] ? '' : 'hidden' ?>">
                                <input type="text" name="firstName" required placeholder="First name" value="<?= htmlspecialchars($guestFormData['firstName'] ?? '') ?>" class="block w-full p-2 mb-2 border rounded bg-gray-900 <?= isset($errors['firstName']) ? 'border-red-500' : '' ?>">
                                <?php if (isset($errors['firstName'])): ?>
                                    <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['firstName']); ?></p>
                                <?php endif; ?>
                                <input type="text" name="lastName" required placeholder="Last name" value="<?= htmlspecialchars($guestFormData['lastName'] ?? '') ?>" class="block w-full p-2 mb-2 border rounded bg-gray-900 <?= isset($errors['lastName']) ? 'border-red-500' : '' ?>">
                                <?php if (isset($errors['lastName'])): ?>
                                    <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['lastName']); ?></p>
                                <?php endif; ?>
                                <input type="email" name="email" required placeholder="Email" value="<?= htmlspecialchars($guestFormData['email'] ?? '') ?>" class="block w-full p-2 mb-2 border rounded bg-gray-900 <?= isset($errors['email']) ? 'border-red-500' : '' ?>">
                                <?php if (isset($errors['email'])): ?>
                                    <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['email']); ?></p>
                                <?php endif; ?>
                                <input type="date" name="dob" required placeholder="Date of Birth" value="<?= htmlspecialchars($guestFormData['dob'] ?? '') ?>" class="block w-full p-2 mb-2 border rounded bg-gray-900 <?= isset($errors['dob']) ? 'border-red-500' : '' ?>">
                                <?php if (isset($errors['dob'])): ?>
                                    <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['dob']); ?></p>
                                <?php endif; ?>
                                <?php if (isset($errors['general'])): ?>
                                    <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['general']); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php else: ?>
                            <p>Logged in as: <?= htmlspecialchars($_SESSION['loggedInUser']['firstName']. ' ' . htmlspecialchars($_SESSION['loggedInUser']['lastName'])); ?></p>
                            <p>Email: <?= htmlspecialchars($_SESSION['loggedInUser']['userEmail']); ?></p>
                            <?php endif; ?>
                        </div>
                        <!-- Billing Address -->
                        <div class="mb-6 bg-gray-700">
                            <h3 class="text-lg font-bold mt-2">Billing Address</h3>
                            <div id="address-form" class="mt-4">
                                <div class="flex gap-2">
                                    <div>
                                        <input type="text" name="street" required placeholder="Street" value="<?= htmlspecialchars($addressFormData['street'] ?? '') ?>" class="block w-full p-2 mb-2 border rounded bg-gray-900 <?= isset($errors['street']) ? 'border-red-500' : '' ?>">
                                        <?php if (isset($errors['street'])): ?>
                                            <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['street']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <input type="number" name="streetNr" required placeholder="Street Number" value="<?= htmlspecialchars($addressFormData['streetNr'] ?? '') ?>" class="block w-full p-2 mb-2 border rounded bg-gray-900 <?= isset($errors['streetNr']) ? 'border-red-500' : '' ?>">
                                        <?php if (isset($errors['streetNr'])): ?>
                                            <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['streetNr']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <div>
                                        <input type="text" name="city" required placeholder="City" value="<?= htmlspecialchars($addressFormData['city'] ?? '') ?>" class="block w-full p-2 mb-2 border rounded bg-gray-900 <?= isset($errors['city']) ? 'border-red-500' : '' ?>">
                                        <?php if (isset($errors['city'])): ?>
                                            <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['city']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <input type="number" name="postalCode" required placeholder="Postal code" value="<?= htmlspecialchars($addressFormData['postalCode'] ?? '') ?>" class="block w-full p-2 mb-2 border rounded bg-gray-900 <?= isset($errors['postalCode']) ? 'border-red-500' : '' ?>">
                                        <?php if (isset($errors['postalCode'])): ?>
                                            <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['postalCode']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if (isset($errors['addressGeneral'])): ?>
                                    <p class="mb-2 text-red-500 text-xs"><?= htmlspecialchars($errors['addressGeneral']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <div class="flex flex-col gap-4 mb-6">
                                <label class="flex items-center">
                                    <input type="checkbox" name="terms" required class="mr-2"> <a class="text-red-500">*</a>&nbsp;I agree with the terms and conditions
                                </label>
                            </div>

                            <button id="submitButton" type="submit" class="w-full py-1 border border-primary bg-bgDark hover:bg-bgSemiDark text-white rounded-lg transition duration-200 flex items-center justify-center">
                                Pay with
                                <img src="<?= htmlspecialchars($_SESSION['baseRoute']); ?>src/assets/stripe-logo.png" alt="Stripe" class="mx-2 mt-1 w-12">
                            </button>
                        </div>
                    </form>
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

        // Update booking expiry on checkout creation
        const checkoutForm = document.getElementById('checkoutForm');
        checkoutForm.addEventListener('submit', function (e) {
            bookingExpiry = Date.now() + 30 * 60 * 1000; // 30 minutes from now
            localStorage.setItem('bookingExpiry', bookingExpiry);
        });
    });
    function cancelBooking(redirectBack = true) {
        rollbackBooking(redirectBack);
    }

    function showGuestForm() {
        document.getElementById('guest-form').classList.remove('hidden');
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
