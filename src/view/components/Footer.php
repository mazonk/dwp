<?php
require_once "src/controller/VenueController.php";
require_once "src/controller/OpeningHourController.php";

$errors = isset($_SESSION['contactErrors']) ? $_SESSION['contactErrors'] : [];
$contactSuccess = isset($_SESSION['contactSuccess']) ? $_SESSION['contactSuccess'] : null;
unset($_SESSION['contactErrors']);
unset($_SESSION['contactSuccess']);
?>

<footer class="flex flex-col gap-[4rem] mt-[8rem]">
  <div class="flex justify-between gap-[2rem]">
    <!-- Site Links -->
    <div class="min-w-[250px] flex flex-col gap-[1.5rem]">
      <h4 class="text-[1.125rem] font-bold leading-tight">Useful Links</h4>
      <div class="flex flex-col gap-[.75rem]">
        <a href="<?php echo $_SESSION['baseRoute'] ?>home" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">Home</a>
        <a href="<?php echo $_SESSION['baseRoute'] ?>movies" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">All Movies</a>
        <a href="<?php echo $_SESSION['baseRoute'] ?>upcoming" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">Upcoming Movies</a>
        <!-- TODO: Scroll down to ticket section -->
        <a href="" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">Tickets</a>
        <!-- TODO: Scroll down to contact section it is in the footer -->
        <a href="" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">Contact</a>
      </div>
    </div>
    <!-- Contact Info -->
    <div class="min-w-[250px] flex flex-col gap-[1.5rem]">
      <h4 class="text-[1.125rem] font-bold leading-tight">Contact Information</h4>
      <div class="flex flex-col gap-[.75rem]">
        <?php
        // Create a new instance of VenueController and fetch all venues
        $venueController = new VenueController();
        $selectedVenue = $venueController->getVenueById($_SESSION['selectedVenueId']);

        if(is_array($selectedVenue) && isset($selectedVenue['errorMessage'])) {
          echo "<div class='text-[.875rem] text-textNormal leading-snug'>" . htmlspecialchars($selectedVenue['errorMessage']) . "</div>";
        }
        ?>
        <a href="mailto:<?= htmlspecialchars($selectedVenue->getContactEmail()) ?>" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">
          <?= htmlspecialchars($selectedVenue->getContactEmail())?>
        </a>
        <div class="w-fit text-[.875rem] text-textNormal leading-snug">
          <?= htmlspecialchars($selectedVenue->getPhoneNr()) ?>
        </div>
        <div class="w-fit text-[.875rem] text-textNormal leading-snug">
          <?= htmlspecialchars($selectedVenue->getAddress()->getStreet()) . " " . htmlspecialchars($selectedVenue->getAddress()->getStreetNr()) . "<br/>" . htmlspecialchars($selectedVenue->getAddress()->getPostalCode()->getPostalCode()) . " " . htmlspecialchars($selectedVenue->getAddress()->getPostalCode()->getCity()) ?>
        </div>
      </div>
    </div>
    <!-- Opening Hours -->
    <div class="min-w-[250px] flex flex-col gap-[1.5rem]">
      <h4 class="text-[1.125rem] font-bold leading-tight">Opening Hours</h4>
      <div class="flex flex-col gap-[.75rem]">
        <!-- TODO: Populate opening hours based on selected venue -->
        <?php
        $openingHourController = new OpeningHourController();
        $openingHours = $openingHourController->getCurrentOpeningHours();

        if(isset($openingHours['errorMessage'])) {
          echo "<div class='text-[.875rem] text-textNormal leading-snug'>" . htmlspecialchars($openingHours['errorMessage']) . "</div>";
        }

        foreach ($openingHours as $openingHour) {
          echo 
            "<div class='w-fit text-[.875rem] text-textNormal leading-snug'>" .
            "<span class='font-medium'>" . htmlspecialchars($openingHour->getDay()) . ": </span>" .
            "<span>" . htmlspecialchars($openingHour->getOpeningTime()->format('H:i')) . " - " . htmlspecialchars($openingHour->getClosingTime()->format('H:i')) . "</span>" .
            "</div>";
        }
        ?>
      </div>
    </div>
    <!-- Contact Form -->
    <div class="min-w-[250px] flex flex-col gap-[1.5rem]">
      <h4 class="text-[1.125rem] font-bold leading-tight">Contact Us</h4>
      <form action="<?php echo $_SESSION['baseRoute'] ?>mail?action=contact" method="post" class="flex flex-col gap-[.75rem] text-textDark">
          <input type="hidden" name="route" value="<?php echo $_SERVER['REQUEST_URI']; ?>">

          <input type="text" name="name" id="nameInput" placeholder="Your name" required="true" class="h-[36px] py-[.5rem] px-[.875rem] bg-bgSemiDark text-[.875rem] text-textNormal leading-snug border-[1px] border-borderDark rounded-[6px] outline-none ease-in-out duration-[.15s] focus:border-textNormal">
          <?php if (isset($errors['name'])): ?>
              <p class="text-red-500 text-xs mt-[-.25rem] mb-[.25rem]"><?= htmlspecialchars($errors['name']) ?></p>
          <?php endif; ?>

          <input type="text" name="email" id="emailInput" placeholder="Your email" required="true" class="h-[36px] py-[.5rem] px-[.875rem] bg-bgSemiDark text-[.875rem] text-textNormal leading-snug border-[1px] border-borderDark rounded-[6px] outline-none ease-in-out duration-[.15s] focus:border-textNormal">
          <?php if (isset($errors['email'])): ?>
              <p class="text-red-500 text-xs mb-[.5rem]"><?= htmlspecialchars($errors['email']) ?></p>
          <?php endif; ?>

          <textarea name="message" id="messageInput" placeholder="Message" required="true" class="min-h-[100px] py-[.5rem] px-[.875rem] bg-bgSemiDark text-[.875rem] text-textNormal leading-snug border-[1px] border-borderDark rounded-[6px] outline-none ease-in-out duration-[.15s] focus:border-textNormal"></textarea>
          <?php if (isset($errors['message'])): ?>
              <p class="text-red-500 text-xs mb-[.5rem]"><?= htmlspecialchars($errors['message']) ?></p>
          <?php endif; ?>

          <div><?php include "captcha.php"; ?></div>
          <input type="text" name="captcha" id="captcha" placeholder="Enter CAPTCHA" required="true" class="h-[36px] py-[.5rem] px-[.875rem] bg-bgSemiDark text-[.875rem] text-textNormal leading-snug border-[1px] border-borderDark rounded-[6px] outline-none ease-in-out duration-[.15s] focus:border-textNormal">
          <?php if (isset($errors['captcha'])): ?>
              <p class="text-red-500 text-xs mb-[.5rem]"><?= htmlspecialchars($errors['captcha']) ?></p>
          <?php endif; ?>

          <button type="submit" name="submit" class="h-[36px] py-[.5rem] px-[1.25rem] bg-primary text-[.875rem] text-textDark font-medium leading-tight rounded-[6px] ease-in-out duration-[.15s] hover:bg-primaryHover">Send</button>
        </form>
    </div>
  </div>
  <!-- TODO: Company name display -->
  <div class="text-textNormal text-[.875rem]">&copy; Spicy pisces all rights reserved</div>
</footer>