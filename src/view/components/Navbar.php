<?php
  require_once "src/controller/CompanyInfoController.php";

  if (isset($_POST['action'])) { //request by xhr
    if ($_POST['action'] === 'selectVenue') {
      $selectedVenue = $venueController->selectVenue($venueController->getVenueById($_POST['venueId']));
    }
    exit();
  }

  $companyInfoController = new CompanyInfoController();
  $companyInfo = $companyInfoController->getCompanyInfo();
  ?>
<header class="w-[100%] fixed top-0 left-0 right-0 bg-bgDark z-[10]">
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const venueDropdownToggler = document.querySelector('#venueDropdownToggler');
      const venueDropdown = document.querySelector('#venueDropdown');
      const profileDropdownToggler = document.querySelector('#profileDropdownToggler');
      const profileDropdown = document.querySelector('#profileDropdown');

      // Add event listeners for toggling dropdowns
      venueDropdownToggler?.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown(venueDropdown);
        closeDropdown(profileDropdown);
      });

      profileDropdownToggler?.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown(profileDropdown);
        closeDropdown(venueDropdown);
      });

      // Close dropdowns when clicking outside
      document.addEventListener('click', () => {
        closeDropdown(venueDropdown);
        closeDropdown(profileDropdown);
      });

      const toggleDropdown = (dropdown) => {
        if (!dropdown) return;
        dropdown.classList.toggle('hidden');
      };

      const closeDropdown = (dropdown) => {
        if (!dropdown || dropdown.classList.contains('hidden')) return;
        dropdown.classList.add('hidden');
      };

      // Handle venue selection
      document.querySelectorAll('.venueSelectButton').forEach(button => {
        button.addEventListener('click', (e) => {
          e.preventDefault();
          const venueId = button.dataset.venueId;
          // Make an XHR request to select the venue
          const xhr = new XMLHttpRequest();
          xhr.open('POST', '', true);
          xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
              window.location.reload();
            }
          };
          xhr.send(`action=selectVenue&venueId=${venueId}`);
        });
      });
    });
  </script>
  <nav class="max-w-[1440px] w-[100%] flex justify-between items-center gap-[4rem] mx-auto py-[1rem] px-[100px] z-[10]">
    <!-- Logo -->
    <a href="<?php echo $_SESSION['baseRoute']?>home">
      <img src="src/assets/<?php echo htmlspecialchars($companyInfo->getLogoUrl()) ?>" alt="Company Logo" class="w-12 h-12 object-cover rounded-full mr-4">
    </a>
    <!-- Menu -->
    <div class="flex justify-center items-center gap-[2.5rem] ml-[195px]">
      <a href="<?php echo $_SESSION['baseRoute']?>home" class="font-medium hover:text-yellow-400 transition duration-300">Home</a>
      <a href="<?php echo $_SESSION['baseRoute']?>movies" class="font-medium hover:text-yellow-400 transition duration-300">All Movies</a>
      <a href="<?php echo $_SESSION['baseRoute']?>upcoming" class="font-medium hover:text-yellow-400 transition duration-300">Upcoming Movies</a>
      <a href="<?php echo $_SESSION['baseRoute']?>about" class="font-medium hover:text-yellow-400 transition duration-300">About us</a>
      <a href="#contact" class="font-medium hover:text-yellow-400 transition duration-300">Contact</a>
    </div>

    <div class="flex items-center gap-[2rem]">
      <!-- Venue Dropdown -->
      <div class="relative">
        <button id="venueDropdownToggler" type="button" class="flex gap-[.375rem] hover:text-yellow-400">
          <i class="ri-map-pin-2-fill h-[18px] text-[18px]"></i>
          <span class="translate-y-[.5px]"><?= $_SESSION['selectedVenueName'] ?></span>
        </button>
        <div id="venueDropdown" class="absolute hidden min-w-[150px] top-[40px] right-[0] py-[.75rem] bg-bgDark border-[1px] border-bgLight rounded-[10px]">
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
      </div>

      <!-- Profile Dropdown -->
      <?php if (!isLoggedIn()): ?>
        <a href="<?php echo $_SESSION['baseRoute']?>login?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="py-[.625rem] px-[1.25rem] bg-primary text-textDark font-medium leading-tight rounded-[8px] ease-in-out duration-[.15s] hover:bg-primaryHover">
          Login
        </a>
      <?php else: ?>
        <div class="relative">
          <button id="profileDropdownToggler" type="button" class="h-[40px] w-[40px] bg-primary text-textDark font-medium leading-tight rounded-full ease-in-out duration-[.15s] hover:bg-primaryHover">
            P
          </button>
          <div id="profileDropdown" class="absolute hidden min-w-[150px] top-[48px] right-[0] py-[.75rem] bg-bgDark border-[1px] border-bgLight rounded-[10px]">
            <?php if ($_SESSION['loggedInUser']['roleType'] === "Admin"): ?>
              <a href="<?php echo $_SESSION['baseRoute']?>admin" class="w-full flex gap-[.375rem] py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
                <i class="ri-user-line h-[18px] text-[18px]"></i>
                <span class="translate-y-[1px]">Admin page</span>
              </a>
            <?php endif; ?>
            <a href="<?php echo $_SESSION['baseRoute']?>profile" class="w-full flex gap-[.375rem] py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
              <i class="ri-user-line h-[18px] text-[18px]"></i>
              <span class="translate-y-[1px]">Edit profile</span>
            </a>
            <a href="<?php echo $_SESSION['baseRoute']?>profile" class="w-full flex gap-[.375rem] py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
              <i class="ri-calendar-check-line h-[18px] text-[18px]"></i>
              <span class="translate-y-[1px]">Reservations</span>
            </a>
            <form action="<?php echo $_SESSION['baseRoute']?>logout" method="post">
              <button type="submit" class="w-full flex gap-[.375rem] py-[.5rem] px-[.625rem] text-[.875rem] text-left leading-tight bg-bgDark ease-in-out duration-[.15s] hover:bg-bgSemiDark">
                <i class="ri-logout-box-line h-[18px] text-[18px]"></i>
                <span class="translate-y-[1px]">Logout</span>
              </button>
            </form>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </nav>
</header>
