<?php
  /* Get the venues */
  include_once "src/controller/VenueController.php";

  // Ensure session variables are set for dropdowns
  if (!isset($_SESSION['isVenueDropdownOpen'])) {
    $_SESSION['isVenueDropdownOpen'] = false;
  }

  if (!isset($_SESSION['isProfileDropdownOpen'])) {
      $_SESSION['isProfileDropdownOpen'] = false;
  }

  // Retrieve the dropdown states
  $isVenueDropdownOpen = $_SESSION['isVenueDropdownOpen'];
  $isProfileDropdownOpen = $_SESSION['isProfileDropdownOpen'];

  // Check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['venueDropdownToggler'])) {
          $_SESSION['isProfileDropdownOpen'] = false; // Close the profile dropdown if it is open
          $_SESSION['isVenueDropdownOpen'] = !$_SESSION['isVenueDropdownOpen'];
          // Redirect to avoid form resubmission
          header("Location: " . $_SERVER['REQUEST_URI']);
          exit();
      }

      if (isset($_POST['profileDropdownToggler'])) {
          $_SESSION['isVenueDropdownOpen'] = false; // Close the venue dropdown if it is open
          $_SESSION['isProfileDropdownOpen'] = !$_SESSION['isProfileDropdownOpen'];
          // Redirect to avoid form resubmission
          header("Location: " . $_SERVER['REQUEST_URI']);
          exit();
      }
  }

  /* Select venue */
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selectVenue'])) {
    $venueController = new VenueController();
    $selectedVenue = $venueController->selectVenue($venueController->getVenue($_POST['venueId'])); // Setting the selected venue in the session
  }
?>

<header class="w-[100%] fixed top-0 left-0 right-0 bg-bgDark z-[10]">
  <nav class="max-w-[1440px] w-[100%] flex justify-between items-center gap-[4rem] mx-auto py-[1rem] px-[100px] z-[10]">
    <!-- Logo -->
    <div>logo</div>

    <!-- Menu  -->
    <!-- (the ml-[] is for balancing the different width of the elements on either siede of the navbar thus it is in the center of the page) -->
    <div class="flex justify-center items-center gap-[2.5rem] ml-[195px]">
      <div>
        <a href="<?php echo $_SESSION['baseRoute']?>home" class="font-medium">Home</a>
      </div>
      <div>
        <a href="<?php echo $_SESSION['baseRoute']?>movies" class="font-medium">All Movies</a>
      </div>
      <div>
        <a href="<?php echo $_SESSION['baseRoute']?>upcoming" class="font-medium">Upcoming Movies</a>
      </div>
      <!-- TODO: Scroll down to ticket section -->
      <div>
        <a href="" class="font-medium">Tickets</a>
      </div>
      <!-- TODO: Scroll down to contact section it is in the footer -->
      <div>
        <a href="" class="font-medium">Contact</a>
      </div>
    </div>

    <div class="flex items-center gap-[2rem]">
      <!-- Venue -->
      <div class="relative">
        <form action="" method="post">
          <input type="hidden" name="isVenueDropdownOpen" value="<?php echo $isVenueDropdownOpen ? 'true' : 'false'; ?>">
          <button type="submit" name="venueDropdownToggler" class="flex gap-[.375rem]">
            <i class="ri-map-pin-2-fill h-[18px] text-[18px]"></i>
            <span class="translate-y-[.5px]"><?= $_SESSION['selectedVenueName'] ?></span>
          </button>
        </form>
        <!-- Dropdown -->
        <?php if ($isVenueDropdownOpen): ?>
        <div class="absolute min-w-[150px] top-[40px] right-[0] py-[.75rem] bg-bgDark border-[1px] border-bgLight rounded-[10px]">
          <?php
          // Create a new instance of VenueController and fetch all venues
          $venueController = new VenueController();
          $allVenues = $venueController->getAllVenues();

          // Loop through each venue and render its name (when clicked, the venue is selected and stored in the session)
          foreach ($allVenues as $venue) {
            echo '<form action="" method="post">';
            echo '<input type="hidden" name="venueId" value="' . htmlspecialchars($venue->getVenueId()) . '">';
            echo '<button type="submit" name="selectVenue" class="w-full py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">';
            echo htmlspecialchars($venue->getName());
            echo '</button>';
            echo '</form>';
          }
          ?>
        </div>
        <?php endif; ?>
      </div>
      <!-- Login -->
      <?php if (!isLoggedIn()): ?>
      <a href="<?php echo $_SESSION['baseRoute']?>login" class="py-[.625rem] px-[1.25rem] bg-primary text-textDark font-medium leading-tight rounded-[8px] ease-in-out duration-[.15s] hover:bg-primaryHover ">
        Login
      </a>
      <?php else: ?>
      <div class="relative">
        <form action="" method="post">
          <input type="hidden" name="isProfileDropdownOpen" value="<?php echo $isProfileDropdownOpen ? 'true' : 'false'; ?>">
          <button type="submit" name="profileDropdownToggler" class="h-[40px] w-[40px] bg-primary text-textDark font-medium leading-tight rounded-full ease-in-out duration-[.15s] hover:bg-primaryHover ">
            P
          </button>
        </form>
        <!-- Dropdown -->
        <?php if ($isProfileDropdownOpen): ?>
        <div class="absolute min-w-[150px] top-[48px] right-[0] py-[.75rem] bg-bgDark border-[1px] border-bgLight rounded-[10px]">
          <button class="w-full flex gap-[.375rem] py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
            <i class="ri-user-line h-[18px] text-[18px]"></i>
            <span class="translate-y-[1px]">Edit profile</span>
          </button>
          <button class="w-full flex gap-[.375rem] py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
            <i class="ri-calendar-check-line h-[18px] text-[18px]"></i>
            <span class="translate-y-[1px]">Reservations</span>
          </button>
          <form action="<?php echo $_SESSION['baseRoute']?>logout" method="post">
            <button type="submit" class="w-full flex gap-[.375rem] py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
              <i class="ri-logout-box-line h-[18px] text-[18px]"></i>
              <span class="translate-y-[1px]">Logout</span>
            </button>
          </form>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </nav>
</header>