<?php
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
	$venueController = new VenueController();
	$allVenues = $venueController->getAllVenues();
	?>
	<div id="venueCardsContainer" class="grid grid-cols-<?php echo count($allVenues) > 5 ? '5' : count($allVenues) ?> gap-6 w-full">
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
	<div id="openingHoursCardsContainer" class="grid grid-cols-5 gap-4 hidden"></div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const openingHoursCardsContainer = document.getElementById('openingHoursCardsContainer');
		const venueCardsContainer = document.getElementById('venueCardsContainer');
		const selectedVenue = document.getElementById('selectedVenue');
		const addOpeningHourButton = document.getElementById('addOpeningHourButton');
		const closeOpeningHourCardsButton = document.getElementById('closeOpeningHourCardsButton');

		// Add click event listener to each venue card
		document.querySelectorAll('.venueCard').forEach(card => {
			// Fetch opening hours for the selected venue
			card.addEventListener('click', () => {
				const xhr = new XMLHttpRequest();
				const baseRoute = '<?php echo $_SESSION['baseRoute'];?>';

				// Parse the venue data from the card's data attribute
				const data = JSON.parse(card.getAttribute('data-venue'));
				const venueData = {
						action: 'getOpeningHoursById',
						venueId: data.id
				};
				
				// Convert venueData to query string
				const params = Object.keys(venueData)
						.map(key => `${encodeURIComponent(key)}=${encodeURIComponent(venueData[key])}`)
						.join('&');

				// Add params to the GET request URL
				xhr.open('GET', `${baseRoute}openingHours/getById?${params}`, true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState === 4 && xhr.status === 200) {
						let response;
						try {
								response = JSON.parse(xhr.response);
						} catch (e) {
								console.error('Could not parse response as JSON:', e);
								return;
						}

						if (!response.error) {
								displayOpeningHourCards(data.name, response.openingHours); // Display opening hour cards
						} else {
								console.error('Error:', response.errors);
						}
					}
				};
    		xhr.send();
			});
		});

		// Dipslay opening hour cards for the selected venue
		function displayOpeningHourCards(venueName, openingHours) {
			openingHoursCardsContainer.classList.remove('hidden');
			venueCardsContainer.classList.add('hidden');

			selectedVenue.textContent = venueName;
			selectedVenue.classList.remove('hidden');

			addOpeningHourButton.classList.remove('hidden');
			closeOpeningHourCardsButton.classList.remove('hidden');

			openingHoursCardsContainer.innerHTML = '';
			openingHours.forEach(openingHour => {
				openingHoursCardsContainer.innerHTML += `
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
			openingHoursCardsContainer.classList.add('hidden');
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