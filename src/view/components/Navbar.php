<?php
  /* Get the venues */
  include_once "src/controller/VenueController.php";

  /* Venue dropdown */
  $isVenueDropdownOpen = isset($_POST['isVenueDropdownOpen']) ? filter_var($_POST['isVenueDropdownOpen'], FILTER_VALIDATE_BOOLEAN) : false;

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['venueDropdownToggler'])) {
    $isVenueDropdownOpen = !$isVenueDropdownOpen;
  }

  /* Profile dropdown */
  $isProfileDropdownOpen = isset($_POST['isProfileDropdownOpen']) ? filter_var($_POST['isProfileDropdownOpen'], FILTER_VALIDATE_BOOLEAN) : false;

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['profileDropdownToggler'])) {
    $isProfileDropdownOpen = !$isProfileDropdownOpen;
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
        <a href="/dwp/home" class="font-medium">Home</a>
      </div>
      <div>
        <a href="/dwp/movies" class="font-medium">All Movies</a>
      </div>
      <div>
        <a href="/dwp/upcoming" class="font-medium">Upcoming Movies</a>
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
            <span class="translate-y-[.5px]">Venue Name</span>
          </button>
        </form>
        <!-- Dropdown -->
        <?php if ($isVenueDropdownOpen): ?>
        <div class="absolute min-w-[150px] top-[40px] right-[0] py-[.75rem] bg-bgDark border-[1px] border-bgLight rounded-[10px]">
          <?php
          // Create a new instance of VenueController and fetch all venues
          $venueController = new VenueController();
          $allVenues = $venueController->getAllVenues();

          foreach ($allVenues as $venue) {
            echo '<button class="w-full py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">';
            echo $venue->getName();
            echo '</button>';
          }
          ?>
        </div>
        <?php endif; ?>
      </div>
      <!-- Login -->
      <a href="" class="py-[.625rem] px-[1.25rem] bg-primary text-textDark font-medium leading-tight rounded-[8px] ease-in-out duration-[.15s] hover:bg-primaryHover ">
        Login
      </a>
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
          <button class="w-full flex gap-[.375rem] py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
            <i class="ri-logout-box-line h-[18px] text-[18px]"></i>
            <span class="translate-y-[1px]">Logout</span>
          </button>
        </div>
        <?php endif; ?>
      </div>
      
    </div>
  </nav>
</header>