<?php
include_once "src/view/components/admin-sections/openingHours/OpeningHoursCard.php";
?>

<div>
  <div class="flex justify-between my-[2rem]">
      <h3 class="text-[1.5rem] font-semibold">Opening Hours</h3>
      <button id="addNewsButton" class="bg-primary text-textDark py-2 px-4 rounded hover:bg-primaryHover">
          Add New
      </button>
  </div>
	<?php
	require_once "src/controller/VenueController.php";
	$venueController = new VenueController();
	$allVenues = $venueController->getAllVenues();
	?>
	<div class="grid grid-cols-<?php echo count($allVenues) > 5 ? '5' : count($allVenues) ?> gap-6 w-full">
		<?php
		if (isset($allVenues['errorMessage'])) {
				echo "<p class='text-red-500 text-center font-medium'>" . htmlspecialchars($allVenues['errorMessage']) . "</p>";
		} else {
				foreach ($allVenues as $venue) {
						$venueData = json_encode([
								'id' => $venue->getVenueId(),
								'name' => $venue->getName(),
						]);
						echo "
						<button class='venueCard bg-bgSemiDark p-6 border-[1px] border-borderDark rounded-lg cursor-pointer duration-[.2s] ease-in-out hover:scale-[1.025] hover:border-borderLight' data-venue='" . htmlspecialchars($venueData) . "'>
							<p class='text-center font-medium text-white'>" . htmlspecialchars($venue->getName()) . "</p>
						</button>
						";
				}
			}
			?>
	</div>

	<!-- Display opening hours for a selected venue in cards -->
	<?php
	require_once "src/controller/OpeningHourController.php";
	$openingHourController = new OpeningHourController();
	$openingHours = $openingHourController->getOpeningHoursById(1);
	?>
	<div class="grid grid-cols-5 gap-4">
		<?php
		if (isset($openingHours['errorMessage'])) {
			echo $openingHours['errorMessage'];
		} else {
			foreach ($openingHours as $openingHour) {
				OpeningHoursCard::render($openingHour);
			}
		}
		?>
	</div>
          
</div>