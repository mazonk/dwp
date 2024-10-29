<?php
/* Get the venues */
include_once "src/controller/VenueController.php";
/* Get the opening hours */
include_once "src/controller/OpeningHourController.php";
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
        $openingHours = $openingHourController->getOpeningHoursById($_SESSION['selectedVenueId']);

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
      <?php
      // if "email" variable is filled out and submit has been clicked, send email
      if (isset($_POST['email']) && $_POST['submit']) {

      //Email information
      $to = "dwp@spicypisces.eu"; // Email of the recipient
      $subject = "Message from contact form";

      $message = "From: " . $_POST['name'] . "\r\n" .
      "Email: " . $_POST['email'] . "\r\n" .
      "Message:" . $_POST['message'];

      $headers = 'From: ' . $to . "\r\n" .
      'Reply-To: ' . $to . "\r\n" .
      'X-Mailer: PHP/' . phpversion();

      //Send email
      mail($to, $subject, $message, $headers);

      //Email response
      echo "Thank you for contacting us!"; }

      //if "email" variable is not filled out or the submit has not been clicked, display the form
      else { ?>
      <form method="post" class="flex flex-col gap-[.75rem] text-textDark">
      <input type="text" name="name" id="emailInput" placeholder="Your name" required="true" class="h-[36px] py-[.5rem] px-[.875rem] bg-bgSemiDark text-[.875rem] text-textNormal leading-snug border-[1px] border-borderDark rounded-[6px] outline-none ease-in-out duration-[.15s] focus:border-textNormal">
        <input type="text" name="email" id="emailInput" placeholder="Your email" required="true" class="h-[36px] py-[.5rem] px-[.875rem] bg-bgSemiDark text-[.875rem] text-textNormal leading-snug border-[1px] border-borderDark rounded-[6px] outline-none ease-in-out duration-[.15s] focus:border-textNormal">
        <textarea name="message" id="messageInput" placeholder="Message" required="true" class="min-h-[100px] py-[.5rem] px-[.875rem] bg-bgSemiDark text-[.875rem] text-textNormal leading-snug border-[1px] border-borderDark rounded-[6px] outline-none ease-in-out duration-[.15s] focus:border-textNormal"></textarea>
        <button type="submit" class="h-[36px] py-[.5rem] px-[1.25rem] bg-primary text-[.875rem] text-textDark font-medium leading-tight rounded-[6px] ease-in-out duration-[.15s] hover:bg-primaryHover">Send</button>
      </form>
      <?php } ?>
    </div>
  </div>
  <!-- TODO: Company name display -->
  <div class="text-textNormal text-[.875rem]">&copy; company_name all rights reserved</div>
</footer>