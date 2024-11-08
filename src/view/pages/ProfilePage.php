<?php
require_once 'session_config.php';
include_once 'src/controller/UserController.php';
include_once 'src/controller/VenueController.php';
include_once 'src/model/entity/Booking.php';
include_once 'src/model/entity/Ticket.php';
include_once 'src/model/entity/Room.php';
include_once 'src/model/entity/Seat.php';
include_once 'src/model/entity/Movie.php';
include_once 'src/model/entity/TicketType.php';
include_once 'src/model/entity/Showing.php';
include_once 'src/view/components/BookingCard.php';

if (!isLoggedIn()) {
    header("Location: " . $_SESSION['baseRoute'] . "login");
    exit;
}

$userController = new UserController();
$user = $userController->getUserById($_SESSION['loggedInUser']['userId']);
if (is_array($user) && isset($user['errorMessage']) && $user['errorMessage']) {
    echo $user['errorMessage'] . ' ' . '<a class="underline text-blue-300" href="javascript:window.history.back()"><-Go back!</a>';
    exit;
} else {

    //TEST DATA 
    // ################################
    // Sample Venue
    $venueController = new VenueController();
$venue1 = $venueController->getVenueById(3); //how do we get the venue?

// Sample Rooms
$room1 = new Room(1, 1, $venue1);
$room2 = new Room(2, 2, $venue1);

// Sample Movies
$movie1 = new Movie(1, "Ironman", "Description for Movie 1", 120, "English", "2024-10-01", "poster1.jpg", "promo1.jpg", 7.5, "trailer1.mp4", [], []);
$movie2 = new Movie(2, "Interstellar", "Description for Movie 2", 90, "English", "2024-11-01", "poster2.jpg", "promo2.jpg", 8.0, "trailer2.mp4", [], []);

// Sample Ticket Types
$ticketType1 = new TicketType(1, "Regular", 12.99);
$ticketType2 = new TicketType(2, "VIP", 25.99);
$ticketType3 = new TicketType(3, "Student", 9.99);

// Sample Showings
$showing1 = new Showing(1, $movie1, $room1, new DateTime("2024-10-01 18:00"), new DateTime("2024-10-01 18:00"));
$showing2 = new Showing(2, $movie2, $room2, new DateTime("2024-10-01 20:00"), new DateTime("2024-10-01 20:00"));

// Sample Seats
$seat1 = new Seat(1, 1, 1, $room1);
$seat2 = new Seat(2, 1, 2, $room1);
$seat3 = new Seat(3, 1, 3, $room2);
$seat4 = new Seat(4, 2, 1, $room2);
$seat5 = new Seat(5, 2, 2, $room2);
$seat6 = new Seat(6, 2, 3, $room1);

// Sample Bookings (Tickets)
$ticket1 = new Ticket(1, $seat1, $ticketType1, $showing1);
$ticket2 = new Ticket(2, $seat2, $ticketType2, $showing1);
$ticket3 = new Ticket(3, $seat3, $ticketType3, $showing2);
$ticket4 = new Ticket(4, $seat4, $ticketType1, $showing2);
$ticket5 = new Ticket(5, $seat5, $ticketType2, $showing1);
$ticket6 = new Ticket(6, $seat6, $ticketType3, $showing2);

// Display Booking Information

// Sample Bookings (assuming ticket objects are created as previously)
$booking1 = new Booking(1, $user, Status::confirmed, [$ticket1, $ticket2]);
$booking2 = new Booking(2, $user, Status::pending, [$ticket3, $ticket4]);
$booking3 = new Booking(3, $user, Status::cancelled, [$ticket5]);
$booking4 = new Booking(4, $user, Status::confirmed, [$ticket6, $ticket1]);
$booking5 = new Booking(5, $user, Status::pending, [$ticket2, $ticket4]);
$booking6 = new Booking(6, $user, Status::cancelled, [$ticket3]);
$booking7 = new Booking(5, $user, Status::pending, [$ticket2, $ticket4]);
$booking8 = new Booking(6, $user, Status::cancelled, [$ticket3]);
$booking9 = new Booking(5, $user, Status::pending, [$ticket2, $ticket4]);
$booking10 = new Booking(6, $user, Status::cancelled, [$ticket3]);

$bookings = [$booking1, $booking2, $booking3, $booking4, $booking5, $booking6, $booking7, $booking8, $booking9, $booking10];

// ################################

$initialBookings = count($bookings) > 8 ? array_slice($bookings, 0, 8) : $bookings;

$editMode = isset($_GET['edit']) && $_GET['edit'] == "true";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include_once("src/assets/tailwindConfig.php"); ?>
    <title>Your profile</title>
</head>
<body class="max-w-[90rem] w-[100%] mx-auto mt-[4.5rem] px-[6.25rem] font-sans bg-bgDark text-white m-0 p-[2vw]">
  <?php include_once("src/view/components/Navbar.php"); ?>
    <main> 
        <div class="flex flex-row">
            <div class="pr-8">
                <div class="flex flex-col items-center mb-4 space-y-[2rem]">
                    <img src="src/assets/default-profile-picture.png" alt="Profile Picture" class="w-[250px] h-[250px] object-cover rounded-full">
                    <div class="break-words w-[250px] space-y-4">
                        <?php if ($editMode): ?>
                            <form method="POST" action="update-profile.php" class="flex flex-col space-y-6">
                                <input type="text" required name="firstName" value="<?php echo htmlspecialchars($user->getFirstName()) ?>" 
                                    class="text-[1rem] bg-bgSemiDark border-[1px] border-borderDark text-textNormal focus:border-textNormal w-full rounded-md outline-none leading-snug py-[.5rem] px-[.875rem]" />
                                <input type="text" required name="lastName" value="<?php echo htmlspecialchars($user->getLastName()) ?>"
                                    class="text-[1rem] bg-bgSemiDark border-[1px] border-borderDark text-textNormal focus:border-textNormal w-full rounded-md outline-none leading-snug py-[.5rem] px-[.875rem]" />
                                <input type="email" required name="email" value="<?php echo htmlspecialchars($user->getEmail()) ?>" 
                                    class="text-[1rem] bg-bgSemiDark border-[1px] border-borderDark text-textNormal focus:border-textNormal w-full rounded-md outline-none leading-snug py-[.5rem] px-[.875rem]" />
                                <input type="date" required name="dob" value="<?php echo htmlspecialchars($user->getDob()->format('Y-m-d')) ?>" 
                                    class="text-[1rem] bg-bgSemiDark border-[1px] border-borderDark text-textNormal focus:border-textNormal w-full rounded-md outline-none leading-snug py-[.5rem] px-[.875rem]" />
                                <button type="submit" 
                                    class="mt-4 text-[1rem] font-semibold bg-primary py-2 w-full text-center border border-borderDark text-textDark hover:bg-primaryHover rounded-[6px]">
                                    Save Changes
                                </button>
                            </form>
                        <?php else: ?>
                            <p class="text-[2rem] text-textLight mb-4">
                                <?php echo htmlspecialchars($user->getFirstName()) . ' ' . htmlspecialchars($user->getLastName()) ?>
                            </p>
                            <p class="text-[1rem] text-textNormal">
                                <?php echo htmlspecialchars($user->getEmail()) ?>
                            </p>
                            <p class="text-[1rem] text-textNormal">
                                <?php echo htmlspecialchars($user->getDob()->format('Y-m-d')) ?>
                            </p>
                            <div class="w-full flex">
                                <a href="?edit=true" class="mt-4 text-[1rem] font-semibold bg-primary py-2 w-full text-center border border-borderDark text-textDark hover:bg-primaryHover rounded-[6px]">
                                    Edit profile
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="border-l border-borderLight"></div>
            <div class="pl-8 w-full">
                <h2 class="text-[2rem] leading-snug mb-7 mt-11">Purchase History</h2>
                <div class="flex flex-wrap">
                    <?php
                        foreach ($initialBookings as $booking) {
                            BookingCard::render($booking->getTickets(), $venue1);
                        }
                    ?>
                </div>
                <?php if (count($bookings) > 8): ?>
                    <div id="show-more-btn" class="text-center mt-4 cursor-pointer text-primary">
                        <span>Show more...</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main> 
    <?php include_once("src/view/components/Footer.php"); ?>
</body>
</html>
<?php } ?>
<script>
    
</script>