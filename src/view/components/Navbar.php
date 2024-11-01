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

  //retrive venues
  $venueController = new VenueController();

  // Handle AJAX request for toggleDropdowns
  if (isset($_POST['action'])) { //request by xhr
    if ($_POST['action'] === 'toggleVenueDropdown') {
        $_SESSION['isVenueDropdownOpen'] = !$_SESSION['isVenueDropdownOpen'];
    } elseif ($_POST['action'] === 'toggleProfileDropdown') {
        $_SESSION['isProfileDropdownOpen'] = !$_SESSION['isProfileDropdownOpen'];
    } elseif ($_POST['action'] === 'selectVenue') {
      $selectedVenue = $venueController->selectVenue($venueController->getVenueById($_POST['venueId'])); // Setting selected venue in session
    }
    exit();
  }
?>

<header class="w-[100%] fixed top-0 left-0 right-0 bg-bgDark z-[10]">
  <script>
    document.addEventListener('DOMContentLoaded', () => {
    const venueDropdownToggler = document.querySelector('#venueDropdownToggler');
    const profileDropdownToggler = document.querySelector('#profileDropdownToggler');

    //add event listeners
    venueDropdownToggler?.addEventListener('click', () => {
      toggleDropdown('toggleVenueDropdown', venueDropdownToggler, profileDropdownToggler);
    });

    profileDropdownToggler?.addEventListener('click', () => {
      toggleDropdown('toggleProfileDropdown', profileDropdownToggler, venueDropdownToggler);
    });

    document.addEventListener('click', (e) => {
      if (
        !venueDropdownToggler.contains(e.target) &&
        !profileDropdownToggler.contains(e.target) &&
        !e.target.closest('[data-close-on-click="false"]')
      ) {
        if (venueDropdownToggler.dataset.isOpen === '1') toggleDropdown('toggleVenueDropdown', venueDropdownToggler);
        if (profileDropdownToggler.dataset.isOpen === '1') toggleDropdown('toggleProfileDropdown', profileDropdownToggler);
      }
    });

    document.querySelectorAll('.venueSelectButton').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const venueId = button.dataset.venueId;
        sendToggleRequest(`selectVenue&venueId=${venueId}`);
      });
    });

    //funcs
    const toggleDropdown = (action, togglerToOpen, togglerToClose) => {
      // Close the other dropdown if it's open
      if (togglerToClose && togglerToClose.dataset.isOpen === '1') {
        togglerToClose.dataset.isOpen = '0';
        const closeAction = togglerToClose.id === 'venueDropdownToggler' ? 'toggleVenueDropdown' : 'toggleProfileDropdown';
        sendToggleRequest(closeAction);
      }

      // Toggle the requested dropdown
      togglerToOpen.dataset.isOpen = togglerToOpen.dataset.isOpen === '1' ? '0' : '1';
      sendToggleRequest(action);
    };

    const sendToggleRequest = (action) => {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', '', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
          window.location.reload();
        }
      };
      xhr.send(`action=${action}`);
    };
  });
  </script>
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
        <button data-is-open="<?php echo htmlspecialchars($isVenueDropdownOpen) ?>" id="venueDropdownToggler" type="button" class="flex gap-[.375rem]">
          <i class="ri-map-pin-2-fill h-[18px] text-[18px]"></i>
          <span class="translate-y-[.5px]"><?= $_SESSION['selectedVenueName'] ?></span>
        </button>
        <!-- Dropdown -->
        <?php if ($isVenueDropdownOpen): ?>
        <div class="absolute min-w-[150px] top-[40px] right-[0] py-[.75rem] bg-bgDark border-[1px] border-bgLight rounded-[10px]">
          <!-- Iterate through all venues and display them as buttons so user can select -->
          
          <?php 
            $allVenues = $venueController->getAllVenues();
            if (isset($allVenues['errorMessage'])) {
              echo "<div class='text-[.875rem] text-textNormal leading-snug'>" . htmlspecialchars($allVenues['errorMessage']) . "</div>";
            }
            
            foreach ($allVenues as $venue): ?>
            <button type="button" data-venue-id="<?php echo htmlspecialchars($venue->getVenueId()); ?>" 
            class="venueSelectButton w-full py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
              <?php echo htmlspecialchars($venue->getName()); ?>
            </button>
          <?php endforeach; ?>
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
      <button data-is-open="<?php echo htmlspecialchars($isProfileDropdownOpen) ?>" id="profileDropdownToggler" type="button" class="h-[40px] w-[40px] bg-primary text-textDark font-medium leading-tight rounded-full ease-in-out duration-[.15s] hover:bg-primaryHover">
        P
      </button>
        <!-- Dropdown -->
        <?php if ($isProfileDropdownOpen): ?>
        <div class="absolute min-w-[150px] top-[48px] right-[0] py-[.75rem] bg-bgDark border-[1px] border-bgLight rounded-[10px]">  
          <?php if ($_SESSION['loggedInUser']['roleType'] === "Admin"): ?>
            <a data-close-on-click="false" href="<?php echo $_SESSION['baseRoute']?>admin" class="w-full flex gap-[.375rem] py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
              <i class="ri-user-line h-[18px] text-[18px]"></i>
              <span class="translate-y-[1px]">Admin page</span>
            </a>
          <?php endif;?>
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