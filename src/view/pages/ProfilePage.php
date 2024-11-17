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

$bookings = [];

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
                            <form id="editProfileInfoForm" class="flex flex-col space-y-6">
                                <input type="hidden" name="userId" id="userId" value="<?php echo htmlspecialchars($user->getId()) ?>" />
                                <input type="text" required name="firstName" id="firstName" value="<?php echo htmlspecialchars($user->getFirstName()) ?>" 
                                    class="text-[1rem] bg-bgSemiDark border-[1px] border-borderDark text-textNormal focus:border-textNormal w-full rounded-md outline-none leading-snug py-[.5rem] px-[.875rem]" />
                                <input type="text" required name="lastName" id="lastName" value="<?php echo htmlspecialchars($user->getLastName()) ?>"
                                    class="text-[1rem] bg-bgSemiDark border-[1px] border-borderDark text-textNormal focus:border-textNormal w-full rounded-md outline-none leading-snug py-[.5rem] px-[.875rem]" />
                                <input type="email" required name="email" id="email" value="<?php echo htmlspecialchars($user->getEmail()) ?>" 
                                    class="text-[1rem] bg-bgSemiDark border-[1px] border-borderDark text-textNormal focus:border-textNormal w-full rounded-md outline-none leading-snug py-[.5rem] px-[.875rem]" />
                                <input type="date" required name="dob" id="dob" value="<?php echo htmlspecialchars($user->getDob()->format('Y-m-d')) ?>" 
                                    class="text-[1rem] bg-bgSemiDark border-[1px] border-borderDark text-textNormal focus:border-textNormal w-full rounded-md outline-none leading-snug py-[.5rem] px-[.875rem]" />
                                <div class="flex space-x-0 mt-4 justify-between">
                                    <button type="submit" 
                                        class="text-[1rem] font-semibold bg-primary py-2 w-1/2 text-center border border-borderDark text-textDark hover:bg-primaryHover rounded-[6px]">
                                        Save Changes
                                    </button>
                                    <button type="button" id="cancelButton" class="bg-gray-300 text-gray-700 py-2 w-1/3 text-center rounded hover:bg-gray-400">
                                        Cancel
                                    </button>
                                </div>
                                
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
                                <a href="?edit=true" id="editButton" class="mt-4 text-[1rem] font-semibold bg-primary py-2 w-full text-center border border-borderDark text-textDark hover:bg-primaryHover rounded-[6px]">
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
    document.addEventListener('DOMContentLoaded', () => {
        const editProfileInfoForm = document.getElementById('editProfileInfoForm');
        const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';

        if (editProfileInfoForm) {
            const errorMessageElement = document.createElement('p');
            errorMessageElement.classList.add('text-red-500', 'text-center', 'font-medium');
            editProfileInfoForm.append(errorMessageElement);

            editProfileInfoForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                const xhr = new XMLHttpRequest();
                xhr.open('PUT', `${baseRoute}profile/edit`, true);
                const updatedUserInfo = {
                    action: 'updateProfileInfo',
                    userId: document.getElementById('userId').value,
                    firstName: document.getElementById('firstName').value,
                    lastName: document.getElementById('lastName').value,
                    dob: document.getElementById('dob').value,
                    email: document.getElementById('email').value,
                };

                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = () => {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            let response;
                            console.log(xhr.response);
                            try {
                                response = JSON.parse(xhr.response); // Parse the JSON response
                            } catch (e) {
                                console.error('Could not parse response as JSON:', e);
                                errorMessageElement.textContent = 'An unexpected error occurred. Please try again.';
                                errorMessageElement.style.display = 'block';
                                return;
                            }

                            if (response.success) {
                                window.location.href = `${baseRoute}profile`; //route back to profile (edit false)
                                errorMessageElement.style.display = 'none'; // Hide the error message if there's success
                            } else {
                                // Extract all error messages from the response
                                // The flat() method of Array instances creates a new array with all sub-array elements 
                                // concatenated into it recursively up to the specified depth.
                                // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/flat
                                const errorMessages = Object.values(response.errorMessage).flat();
                                
                                if (errorMessages.length > 0) {
                                    // Display the first error message to the user
                                    errorMessageElement.textContent = errorMessages[0];
                                    errorMessageElement.style.display = 'block'; // Make the error message visible
                                    console.error('Error:', errorMessages);
                                }
                            }
                        }
                    };

                // Send data as URL-encoded string
                const params = Object.keys(updatedUserInfo)
                    .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(updatedUserInfo[key])}`)
                    .join('&');
                    console.log(params);
                xhr.send(params);
            });
        }
        // Cancel button hides the form without submitting
        document.getElementById('cancelButton').addEventListener('click', () => {
            editProfileInfoForm.classList.add('hidden');
            window.location.href = `${baseRoute}profile`; //route back to profile (edit false)
        });
    });
    
</script>
