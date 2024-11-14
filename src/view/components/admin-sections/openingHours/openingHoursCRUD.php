<?php
include_once "src/view/components/admin-sections/openingHours/OpeningHoursCard.php";
?>

<div>
  <div class="flex justify-between my-[2rem]">
      <h3 class="text-[1.5rem] font-semibold">
				Opening Hours
				<span id="selectedVenue" class="ml-[1rem] text-lg text-primary italic font-medium px-4 py-1 rounded-full bg-primary/15 hidden"></span>
			</h3>
      <div class="flex gap-[.5rem]">
				<button id="addOpeningHourButton" class="bg-primary text-textDark py-2 px-4 rounded hover:bg-primaryHover hidden">
						Add New
				</button>
				<button id="closeOpeningHourCardsButton" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 hidden">
					Close
				</button>
			</div>
  </div>
	<?php
	require_once "src/controller/VenueController.php";
	require_once "src/controller/OpeningHourController.php";

	$openingHourController = new OpeningHourController();
	$venueController = new VenueController();
	$allVenues = $venueController->getAllVenues();
	?>
	<div id="venueCardsContainer" class="grid grid-cols-<?php echo count($allVenues) > 5 ? '5' : count($allVenues) ?> gap-6 w-full">
		<?php
		if (isset($allVenues['errorMessage'])) {
				echo "<p class='text-red-500 text-center font-medium'>" . htmlspecialchars($allVenues['errorMessage']) . "</p>";
		} else {
				foreach ($allVenues as $venue) {
						$openingHours = $openingHourController->getOpeningHoursById($venue->getVenueId());
						$openingHoursArray = [];
						foreach ($openingHours as $openingHour) {
							$openingHoursArray[] = [
								'id' => $openingHour->getOpeningHourId(),
								'day' => $openingHour->getDay(),
								'openingTime' => $openingHour->getOpeningTime()->format('H:i'),
								'closingTime' => $openingHour->getClosingTime()->format('H:i'),
								'isCurrent' => $openingHour->getIsCurrent()
							];
						}

						$venueData = json_encode([
								'id' => $venue->getVenueId(),
								'name' => $venue->getName(),
								'openingHours' => $openingHoursArray,
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
	$openingHours = $openingHourController->getOpeningHoursById(3);
	?>
	<div id="openingHourCardsContainer" class="grid grid-cols-5 gap-4 hidden">
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

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const openingHourCardsContainer = document.getElementById('openingHourCardsContainer');
		const venueCardsContainer = document.getElementById('venueCardsContainer');
		const selectedVenue = document.getElementById('selectedVenue');
		const addOpeningHourButton = document.getElementById('addOpeningHourButton');
		const closeOpeningHourCardsButton = document.getElementById('closeOpeningHourCardsButton');

		// Add click event listener to each venue card
		document.querySelectorAll('.venueCard').forEach(card => {
			card.addEventListener('click', () => {
				const data = JSON.parse(card.dataset.venue);
				console.log(data);
				displayOpeningHourCards(data.name, data.openingHours); // Display opening hour cards
			});		
		});

		// Dipslay opening hour cards for the selected venue
		function displayOpeningHourCards(venueName, openingHours) {
			openingHourCardsContainer.classList.remove('hidden');
			venueCardsContainer.classList.add('hidden');

			selectedVenue.textContent = venueName;
			selectedVenue.classList.remove('hidden');

			addOpeningHourButton.classList.remove('hidden');
			closeOpeningHourCardsButton.classList.remove('hidden');

			openingHourCardsContainer.innerHTML = '';
			openingHours.forEach(openingHour => {
				openingHourCardsContainer.innerHTML += `
					<div class='bg-bgSemiDark border-[1px] border-borderDark rounded p-4'>
						<div class='flex justify-between items-center'>
							<h4 class='text-[1.25rem] font-semibold'>${openingHour.day}</h4>
							${openingHour.isCurrent ? "<p class='py-[.125rem] px-2 text-[.75rem] font-medium text-primary border-[1px] border-primary rounded-full'>Current</p>" : ''}
						</div>
						<p>${openingHour.openingTime} - ${openingHour.closingTime}</p>
						<div class='flex justify-start mt-4 gap-[.5rem]'>
							<button class='py-1 px-2 text-primary border-[1px] border-primary rounded hover:text-primaryHover hover:border-primaryHover duration-[.2s] ease-in-out'>
								Edit
							</button>
							<button class='bg-red-500 text-textDark py-1 px-2 border-[1px] border-red-500 rounded hover:bg-red-600 hover:border-red-600'>
								Delete
							</button>
						</div>
					</div>
				`;
			});
		}

		// Close opening hour cards and show venue cards
		function closeOpeningHourCards() {
			openingHourCardsContainer.classList.add('hidden');
			venueCardsContainer.classList.remove('hidden');

			selectedVenue.textContent = '';
			selectedVenue.classList.add('hidden');

			addOpeningHourButton.classList.add('hidden');
			closeOpeningHourCardsButton.classList.add('hidden');
		}

		// Add click event listener to close opening hour cards button
		closeOpeningHourCardsButton.addEventListener('click', closeOpeningHourCards);

		/*== Add News ==*/
	});
</script>