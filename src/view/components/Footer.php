<?php
/* Get the venues */
include_once "src/controller/VenueController.php";
?>

<footer class="flex flex-col gap-[4rem] mt-[8rem]">
  <?php
  // Create a new instance of VenueController and fetch all venues
  $venueController = new VenueController();
  $selectedVenue = $venueController->getVenue($_SESSION['selectedVenueId']);

  ?>
  <div class="flex justify-between gap-[2rem]">
    <!-- Site Links -->
    <div class="min-w-[250px] flex flex-col gap-[1.5rem]">
      <h4 class="text-[1.125rem] font-bold leading-tight">Useful Links</h4>
      <div class="flex flex-col gap-[.75rem]">
        <a href="/dwp" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">Home</a>
        <a href="/dwp/movies" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">All Movies</a>
        <a href="/dwp/upcoming" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">Upcoming Movies</a>
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
        <a href="mailto:<?= $selectedVenue->getContactEmail() ?>" class="w-fit text-[.875rem] text-textNormal leading-snug ease-in-out duration-[.15s] hover:text-textLight">
          <?= $selectedVenue->getContactEmail()?>
        </a>
        <div class="w-fit text-[.875rem] text-textNormal leading-snug">
          <?= $selectedVenue->getPhoneNr()?>
        </div>
        <div class="w-fit text-[.875rem] text-textNormal leading-snug">
          <?= $selectedVenue->getAddress()->getStreet() . " " . $selectedVenue->getAddress()->getStreetNr() . "<br/>" .
          $selectedVenue->getAddress()->getPostalCode()->getPostalCode() . " " . $selectedVenue->getAddress()->getPostalCode()->getCity()?>
        </div>
      </div>
    </div>
    <!-- Opening Hours -->
    <div class="min-w-[250px] flex flex-col gap-[1.5rem]">
      <h4 class="text-[1.125rem] font-bold leading-tight">Opening Hours</h4>
      <div class="flex flex-col gap-[.75rem]">
        <!-- TODO: Populate opening hours based on selected venue -->
        <div class="w-fit text-[.875rem] text-textNormal leading-snug">
          <span class="font-medium">Mon-Fri:</span>
          <span>10:00 - 22:00</span>
        </div>
        <div class="w-fit text-[.875rem] text-textNormal leading-snug">
          <span class="font-medium">Sat:</span>
          <span>11:00 - 23:00</span>
        </div>
        <div class="w-fit text-[.875rem] text-textNormal leading-snug">
          <span class="font-medium">Sun:</span>
          <span>12:00 - 20:00</span>
        </div>
      </div>
    </div>
    <!-- Contact Form -->
    <div class="min-w-[250px] flex flex-col gap-[1.5rem]">
      <h4 class="text-[1.125rem] font-bold leading-tight">Contact Us</h4>
      <form action="" method="post" class="flex flex-col gap-[.75rem] text-textDark">
        <input type="text" name="email" id="emailInput" placeholder="Email" class="h-[36px] py-[.5rem] px-[.875rem] bg-bgSemiDark text-[.875rem] text-textNormal leading-snug border-[1px] border-borderDark rounded-[6px] outline-none ease-in-out duration-[.15s] focus:border-textNormal">
        <textarea name="message" id="messageInput" placeholder="Message" class="min-h-[100px] py-[.5rem] px-[.875rem] bg-bgSemiDark text-[.875rem] text-textNormal leading-snug border-[1px] border-borderDark rounded-[6px] outline-none ease-in-out duration-[.15s] focus:border-textNormal"></textarea>
        <button type="submit" class="h-[36px] py-[.5rem] px-[1.25rem] bg-primary text-[.875rem] text-textDark font-medium leading-tight rounded-[6px] ease-in-out duration-[.15s] hover:bg-primaryHover">Send</button>
      </form>
    </div>
  </div>
  <!-- TODO: Company name display -->
  <div class="text-textNormal text-[.875rem]">&copy; <?= $_SESSION['selectedVenueName'] ?> all rights reserved</div>
</footer>