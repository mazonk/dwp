<?php
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
						echo "<button class='venueCard bg-bgSemiDark p-6 border-[1px] border-borderDark rounded-lg cursor-pointer duration-[.2s] ease-in-out hover:scale-[1.025] hover:border-borderLight' 
										data-venue='" . htmlspecialchars($venueData) . "'>";
						echo "<p class='text-center font-medium text-white'>" . htmlspecialchars($venue->getName()) . "</p>";
						echo "</button>";
				}
			}
			?>
	</div>

	<?php
	require_once "src/controller/OpeningHourController.php";
	$openingHourController = new OpeningHourController();
	$openingHours = $openingHourController->getOpeningHoursById(1);
	?>
	<!-- Display all opening hours as cards -->
	<div class="grid grid-cols-5 gap-4">
		<?php
		foreach ($openingHours as $openingHour) {
			echo "
			<div class='bg-bgSemiDark border-[1px] border-borderDark rounded p-4'>
				<div class='flex justify-between items-center'>
					<h4 class='text-[1.25rem] font-semibold'>" . htmlspecialchars($openingHour->getDay()) . "</h4>
					<div>";
					if ($openingHour->getIsCurrent()) {
						echo "<p class='py-[.125rem] px-2 text-[.75rem] font-medium text-primary border-[1px] border-primary rounded-full'>Current</p>";
					}
					echo "</div>
				</div>
				<p>" . htmlspecialchars($openingHour->getOpeningTime()->format('H:i')) . " - " . htmlspecialchars($openingHour->getClosingTime()->format('H:i')) . "</p>
				<div class='flex justify-start mt-4 gap-[.5rem]'>
					<button class='py-1 px-2 text-primary border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[.2s] ease-in-out'>
							Edit
					</button>
					<button class='bg-red-500 text-textDark py-1 px-2 border-[1px] border-red-500 rounded hover:bg-red-600 hover:border-red-600'>
							Delete
					</button>
				</div>
			</div>
			";
		}
		?>
	</div>
          
</div>